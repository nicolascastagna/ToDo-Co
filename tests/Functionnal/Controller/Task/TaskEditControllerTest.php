<?php

namespace App\Tests\Functionnal\Controller\Task;

use App\Repository\TaskRepository;
use App\Tests\DataFixtures\TaskFixtures;
use App\Tests\Functionnal\AbstractTodoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskEditControllerTest extends AbstractTodoWebTestCase
{
    private $testTask;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testTask = $this->get(TaskRepository::class)->findOneBy(['title' => TaskFixtures::TASK_USER_LIST_INDEX . '1']);
    }

    public function testSubmitValidEditTaskForm(): void
    {
        $this->loginAdmin();

        $crawler = $this->requestGET(sprintf($this->getRoute(), $this->testTask->getId()));

        $this->assertOKResponse();

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'TacheTestEdited';
        $form['task[content]'] = 'Contenu de la tache editée';

        $this->client->submit($form);
        $this->assertResponseRedirects('/tasks', Response::HTTP_FOUND);
        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! La tâche a bien été modifiée.');

        $task = $this->getTask('TacheTestEdited');
        $this->assertNotNull($task);
    }


    public function getRoute(): string
    {
        return '/tasks/%s/edit';
    }
}
