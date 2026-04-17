<?php

namespace Tests\Unit;

use Application\UseCases\User\FindRegisteredUserUseCase;
use Application\UseCases\User\RegisterUserUseCase;
use Application\UseCases\User\UpdateUserProfileUseCase;
use Domain\Contracts\Auth0UserProfileSyncInterface;
use Domain\Contracts\UserAvatarStorageInterface;
use Domain\Contracts\UserRepositoryInterface;
use Domain\Models\User;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\UploadedFile;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class UserUseCasesTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_register_user_uploads_avatar_and_persists_attributes(): void
    {
        $payload = [
            'name' => 'Maria Silva',
            'email' => 'maria@example.com',
            'password' => 'secret123',
        ];

        $avatar = Mockery::mock(UploadedFile::class);

        $repository = Mockery::mock(UserRepositoryInterface::class);
        $storage = Mockery::mock(UserAvatarStorageInterface::class);

        $storage->shouldReceive('upload')->once()->with($avatar)->andReturn('avatars/maria.jpg');
        $storage->shouldReceive('url')->once()->with('avatars/maria.jpg')->andReturn('https://cdn.test/avatars/maria.jpg');

        $repository->shouldReceive('create')->once()->with(Mockery::on(function (array $attributes): bool {
            return $attributes['name'] === 'Maria Silva'
                && $attributes['email'] === 'maria@example.com'
                && $attributes['password'] === 'secret123'
                && $attributes['auth_identifier'] === 'auth0|maria'
                && $attributes['avatar_path'] === 'avatars/maria.jpg'
                && $attributes['avatar_url'] === 'https://cdn.test/avatars/maria.jpg';
        }))->andReturn(new User());

        $result = (new RegisterUserUseCase())->execute($payload, $avatar, 'auth0|maria', $repository, $storage);

        $this->assertInstanceOf(User::class, $result);
    }

    public function test_update_profile_syncs_auth0_updates_user_and_deletes_old_avatar(): void
    {
        $user = new User();
        $user->name = 'Old Name';
        $user->email = 'old@example.com';
        $user->auth_identifier = 'auth0|abc';
        $user->avatar_path = 'avatars/old.jpg';

        $payload = [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'password' => '',
        ];

        $avatar = Mockery::mock(UploadedFile::class);

        $repository = Mockery::mock(UserRepositoryInterface::class);
        $storage = Mockery::mock(UserAvatarStorageInterface::class);
        $auth0Sync = Mockery::mock(Auth0UserProfileSyncInterface::class);

        $storage->shouldReceive('upload')->once()->with($avatar)->andReturn('avatars/new.jpg');
        $storage->shouldReceive('url')->once()->with('avatars/new.jpg')->andReturn('https://cdn.test/avatars/new.jpg');
        $storage->shouldReceive('delete')->once()->with('avatars/old.jpg');

        $auth0Sync->shouldReceive('sync')->once()->with('auth0|abc', Mockery::on(function (array $profile): bool {
            return $profile['name'] === 'New Name'
                && $profile['email'] === 'new@example.com'
                && $profile['picture'] === 'https://cdn.test/avatars/new.jpg';
        }));

        $repository->shouldReceive('update')->once()->with($user, Mockery::on(function (array $attributes): bool {
            return $attributes['name'] === 'New Name'
                && $attributes['email'] === 'new@example.com'
                && !array_key_exists('password', $attributes)
                && $attributes['avatar_path'] === 'avatars/new.jpg'
                && $attributes['avatar_url'] === 'https://cdn.test/avatars/new.jpg';
        }))->andReturn($user);

        $result = (new UpdateUserProfileUseCase())->execute($user, $payload, $avatar, $repository, $storage, $auth0Sync);

        $this->assertSame($user, $result);
    }

    public function test_find_registered_user_returns_existing_user_by_auth_identifier(): void
    {
        $authenticatedUser = new GenericUser([
            'id' => 'auth0|known',
            'email' => 'known@example.com',
            'name' => 'Known User',
        ]);

        $knownUser = new User();
        $knownUser->auth_identifier = 'auth0|known';

        $repository = Mockery::mock(UserRepositoryInterface::class);

        $repository->shouldReceive('findByAuthIdentifier')->once()->with('auth0|known')->andReturn($knownUser);
        $repository->shouldNotReceive('findByEmail');

        $result = (new FindRegisteredUserUseCase())->execute($authenticatedUser, $repository);

        $this->assertSame($knownUser, $result);
    }

    public function test_find_registered_user_creates_user_when_missing_and_flag_enabled(): void
    {
        $authenticatedUser = new GenericUser([
            'id' => 'auth0|new',
            'email' => 'new-user@example.com',
            'name' => 'New User',
            'picture' => 'https://images.test/pic.jpg',
        ]);

        $repository = Mockery::mock(UserRepositoryInterface::class);
        $createdUser = new User();

        $repository->shouldReceive('findByAuthIdentifier')->once()->with('auth0|new')->andReturn(null);
        $repository->shouldReceive('findByEmail')->once()->with('new-user@example.com')->andReturn(null);
        $repository->shouldReceive('create')->once()->with(Mockery::on(function (array $attributes): bool {
            return $attributes['name'] === 'New User'
                && $attributes['email'] === 'new-user@example.com'
                && $attributes['auth_identifier'] === 'auth0|new'
                && is_string($attributes['password'])
                && strlen($attributes['password']) === 40
                && $attributes['avatar_url'] === 'https://images.test/pic.jpg';
        }))->andReturn($createdUser);

        $result = (new FindRegisteredUserUseCase())->execute($authenticatedUser, $repository, true);

        $this->assertSame($createdUser, $result);
    }

    public function test_find_registered_user_links_auth_identifier_to_existing_email_user(): void
    {
        $authenticatedUser = new GenericUser([
            'id' => 'auth0|link',
            'email' => 'linked@example.com',
            'name' => 'Linked User',
        ]);

        $emailUser = new User();
        $emailUser->email = 'linked@example.com';
        $emailUser->auth_identifier = null;

        $repository = Mockery::mock(UserRepositoryInterface::class);

        $repository->shouldReceive('findByAuthIdentifier')->once()->with('auth0|link')->andReturn(null);
        $repository->shouldReceive('findByEmail')->once()->with('linked@example.com')->andReturn($emailUser);
        $repository->shouldReceive('update')->once()->with($emailUser, ['auth_identifier' => 'auth0|link'])->andReturn($emailUser);

        $result = (new FindRegisteredUserUseCase())->execute($authenticatedUser, $repository);

        $this->assertSame($emailUser, $result);
    }
}
