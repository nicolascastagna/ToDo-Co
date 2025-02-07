<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use App\Tests\Builder\TaskBuilder;
use DateTime;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testTitle()
    {
        $task = TaskBuilder::create()
            ->setTitle('Testitle')
            ->build();

        $this->assertSame('Testitle', $task->getTitle());
    }

    public function testCreatedAt()
    {
        $task = TaskBuilder::create()
            ->setCreatedAt(new DateTime())
            ->build();

        $now = new DateTime();

        $this->assertEqualsWithDelta($now, $task->getCreatedAt(), 2);
    }

    public function testIsDone()
    {
        $task = TaskBuilder::create()
            ->setIsDone(false)
            ->build();

        $this->assertFalse($task->isDone());
    }

    public function testTaskUser()
    {
        $author = new User();
        $task = TaskBuilder::create()
            ->setUser($author)
            ->build();

        $this->assertInstanceOf(User::class, $task->getUser());
    }
}
