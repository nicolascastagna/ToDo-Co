<?php

namespace App\Tests\Functionnal\Controller\User;

use App\Tests\Functionnal\AbstractTodoWebTestCase;

class UserAddControllerTest extends AbstractTodoWebTestCase
{
    public function testDisplayCreateUserForm(): void
    {
        $this->loginAdmin();
        $this->requestGET(sprintf($this->getRoute()));

        $this->assertOKResponse();

        $this->assertSelectorExists('input[name="user[username]"]');
        $this->assertSelectorExists('input[name="user[password][first]"]');
        $this->assertSelectorExists('input[name="user[password][second]"]');
        $this->assertSelectorExists('select[name="user[roles]"]');
    }

    public function testSubmitValidCreateUserForm(): void
    {
        $this->loginAdmin();

        $crawler = $this->requestGET(sprintf($this->getRoute()));

        $this->assertOKResponse();

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'TestUser';
        $form['user[password][first]'] = 'password123';
        $form['user[password][second]'] = 'password123';
        $form['user[email]'] = 'user-test@email.com';

        $this->client->submit($form);
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! L\'utilisateur a bien été ajouté.');

        $user = $this->userRepository->findOneBy(['username' => 'TestUser']);
        $this->assertNotNull($user);
        $this->assertEquals('ROLE_USER', $user->getRoles()[0]);
    }


    public function getRoute(): string
    {
        return '/users/create';
    }
}
