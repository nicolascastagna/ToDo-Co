<?php

namespace App\Tests\Controller\Security;

use App\Tests\Functionnal\AbstractTodoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends AbstractTodoWebTestCase
{
    public function testLoginFormSuccessful(): void
    {
        $crawler = $this->requestGET(sprintf($this->getRoute()));
        $this->assertOKResponse();

        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'user1';
        $form['password'] = 'password-1';

        $this->client->submit($form);
        $this->assertResponseRedirects('/', Response::HTTP_FOUND);
        $this->client->followRedirect();
    }

    public function getRoute(): string
    {
        return '/login';
    }
}
