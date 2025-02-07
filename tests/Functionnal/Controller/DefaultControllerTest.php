<?php

namespace App\Tests\Controller;

use App\Tests\Functionnal\AbstractTodoWebTestCase;

class DefaultControllerTest extends AbstractTodoWebTestCase
{
    public function testHomepage(): void
    {
        $this->loginUser();
        $this->requestGET(sprintf($this->getRoute()));

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
        $this->assertOKResponse();
    }

    public function getRoute(): string
    {
        return '/';
    }
}
