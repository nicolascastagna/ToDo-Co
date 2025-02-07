<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Task;
use App\Tests\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUsername()
    {
        $user = UserBuilder::create()
            ->setUsername('TestUsername')
            ->build();

        $this->assertSame('TestUsername', $user->getUsername());
    }

    public function testGetUserIdentifier()
    {
        $user = UserBuilder::create()
            ->setEmail('test@example.com')
            ->build();

        $this->assertSame($user->getEmail(), $user->getUserIdentifier());
    }

    public function testPassword()
    {
        $user = UserBuilder::create()
            ->setPassword('TestPassword')
            ->build();

        $this->assertSame('TestPassword', $user->getPassword());
    }

    public function testEmail()
    {
        $user = UserBuilder::create()
            ->setEmail('TestEmail')
            ->build();

        $this->assertSame('TestEmail', $user->getEmail());
    }

    public function testAddTask()
    {
        $user = UserBuilder::create()->build();
        $task = new Task();
        $user->addTask($task);

        $this->assertContains($task, $user->getTasks());
    }

    public function testRemoveTask()
    {
        $user = UserBuilder::create()->build();
        $task = new Task();
        $user->addTask($task);

        $this->assertCount(1, $user->getTasks());

        $user->removeTask($task);

        $this->assertEmpty($user->getTasks());
    }
}
