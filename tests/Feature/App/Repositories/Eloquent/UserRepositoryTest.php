<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Core\Domain\Repositories\UserRepositoryInterface;
use Exception;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new UserRepository(new User());
    }

    public function test_if_implements_interface()
    {
        $this->assertInstanceOf(UserRepositoryInterface::class, $this->repository);
    }

    public function test_insert()
    {
        $input = [
            'name' => 'User 1',
            'email' => 'test@mail.com',
            'password' => '12345'
        ];

        $output = $this->repository->store($input);

        $this->assertDatabaseHas('users', [
            'id' => 1
        ]);
        $this->assertEquals($input['name'], $output->name);
    }

    public function test_find_by_id_not_found()
    {
        $this->expectException(Exception::class);

        $this->repository->findById('fakeId');
    }

    public function test_find_by_id()
    {
        $user = User::factory()->create();

        $output = $this->repository->findById($user->id);

        $this->assertEquals($user->id, $output->id);
        $this->assertEquals($user->name, $output->name);
    }

    public function test_find_all_empty()
    {
        $output = $this->repository->findAll();

        $this->assertCount(0, $output);
    }

    public function test_pagination()
    {
        User::factory()->count(20)->create();

        $output = $this->repository->paginate();

        $this->assertCount(15, $output->items());
        $this->assertEquals(20, $output->total());
    }

    public function test_pagination_with_total_page()
    {
        User::factory()->count(50)->create();

        $output = $this->repository->paginate(totalPerPage: 10);

        $this->assertCount(10, $output->items());
        $this->assertEquals(50, $output->total());
    }

    public function test_update_not_found()
    {
        $this->expectException(Exception::class);

        $input = [
            'name' => 'User 1',
            'email' => 'test@mail.com',
            'password' => '12345'
        ];

        $this->repository->update('fakeId', $input);
    }

    public function test_update()
    {
        $createdUser = User::factory()->create();

        $input = [
            'name' => 'User 1',
            'email' => 'test@mail.com'
        ];

        $output = $this->repository->update($createdUser->id, $input);

        $this->assertNotEquals($input['name'], $createdUser->name);
        $this->assertEquals($input['name'], $output->name);
    }

    public function test_delete_not_found()
    {
        $this->expectException(Exception::class);

        $this->repository->delete('fakeId');
    }

    public function test_delete()
    {
        $createdUser = User::factory()->create();

        $success = $this->repository->delete($createdUser->id);

        $this->assertTrue($success);
    }
}
