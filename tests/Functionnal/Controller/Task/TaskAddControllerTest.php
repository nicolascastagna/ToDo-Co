<?php

namespace App\Tests\Functionnal\Controller\Task;

use App\Tests\Functionnal\AbstractTodoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskAddControllerTest extends AbstractTodoWebTestCase
{
    public function testSubmitValidCreateTaskForm(): void
    {
        $this->loginUser();

        $crawler = $this->requestGET(sprintf($this->getRoute()));

        $this->assertOKResponse();

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'TacheTest';
        $form['task[content]'] = 'Contenu de la tache';

        $this->client->submit($form);
        $this->assertResponseRedirects('/tasks', Response::HTTP_FOUND);
        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! La tâche a bien été ajoutée.');

        $task = $this->getTask('TacheTest');
        $this->assertNotNull($task);
    }

    public function getRoute(): string
    {
        return '/tasks/create';
    }
}
