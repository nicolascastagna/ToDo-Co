<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Task;
use App\Entity\User;
use App\Tests\Builder\TaskBuilder;
use App\Tests\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUsername()
    {
        $user = (new UserBuilder())
            ->setUsername('TestUsername')
            ->build();
        $this->assertSame('TestUsername', $user->getUsername());
    }

    public function testGetUserIdentifier()
    {
        $user = (new UserBuilder())
            ->setUsername('TestUsername')
            ->build();
        $this->assertSame($user->getUsername(), $user->getUserIdentifier());
    }

    public function testPassword()
    {
        $user = (new UserBuilder())
            ->setPassword('TestPassword')
            ->build();
        $this->assertSame('TestPassword', $user->getPassword());
    }

    public function testEmail()
    {
        $user = (new UserBuilder())
            ->setEmail('TestEmail')
            ->build();
        $this->assertSame('TestEmail', $user->getEmail());
    }

    public function testAddTask()
    {
        $user = (new UserBuilder())->build();
        $task = (new TaskBuilder())->build();
        $user->addTask($task);

        $this->assertContains($task, $user->getTasks());
    }

    public function testRemoveTask()
    {
        $user = (new UserBuilder())->build();
        $task = (new TaskBuilder())->build();
        $user->addTask($task);
        $user->removeTask($task);

        $this->assertEmpty($user->getTasks());
    }
}
