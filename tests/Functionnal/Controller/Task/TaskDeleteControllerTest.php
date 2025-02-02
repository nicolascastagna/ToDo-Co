<?php

namespace App\Tests\Functionnal\Controller\Task;

use App\Repository\TaskRepository;
use App\Tests\DataFixtures\TaskFixtures;
use App\Tests\Functionnal\AbstractTodoWebTestCase;

class TaskDeleteControllerTest extends AbstractTodoWebTestCase
{
    private $testTask;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testTask = $this->get(TaskRepository::class)->findOneBy(['title' => TaskFixtures::TASK_USER_LIST_INDEX . '1']);
    }

    public function testDeleteTaskRedirect(): void
    {
        $this->loginAdmin();

        $this->requestGET(sprintf($this->getRoute(), $this->testTask->getId()));

        $this->client->followRedirect();
        $this->assertOKResponse();
    }


    public function getRoute(): string
    {
        return '/tasks/%s/delete';
    }
}
