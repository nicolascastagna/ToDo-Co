<?php

namespace App\Tests\Functionnal\Controller\Task;

use App\Tests\Functionnal\AbstractTodoWebTestCase;

class TaskListControllerTest extends AbstractTodoWebTestCase
{
    public function testGetTaskList(): void
    {
        $this->loginAdmin();
        $this->requestGET(sprintf($this->getRoute()));

        $this->assertOKResponse();
    }

    public function getRoute(): string
    {
        return '/tasks';
    }
}
