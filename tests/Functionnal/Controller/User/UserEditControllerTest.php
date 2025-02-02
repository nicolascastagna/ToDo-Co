<?php

namespace App\Tests\Functionnal\Controller\User;

use App\Repository\UserRepository;
use App\Tests\DataFixtures\UserFixtures;
use App\Tests\Functionnal\AbstractTodoWebTestCase;

class UserEditControllerTest extends AbstractTodoWebTestCase
{
    public function testDisplayCreateUserForm(): void
    {
        $user = $this->get(UserRepository::class)->findOneByEmail(UserFixtures::EMAIL_ADMIN);
        $this->loginAdmin();
        $this->requestGET(sprintf($this->getRoute(), $user->getId()));

        $this->assertOKResponse();

        $this->assertSelectorExists('input[name="user[username]"]');
        $this->assertSelectorExists('input[name="user[password][first]"]');
        $this->assertSelectorExists('input[name="user[password][second]"]');
        $this->assertSelectorExists('select[name="user[roles]"]');
    }

    public function testSubmitValidEditUserForm(): void
    {
        $user = $this->get(UserRepository::class)->findOneByEmail(UserFixtures::EMAIL_ADMIN);
        $this->loginAdmin();
        $crawler = $this->requestGET(sprintf($this->getRoute(), $user->getId()));

        $this->assertOKResponse();

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'TestUserEdited';
        $form['user[password][first]'] = 'password123456';
        $form['user[password][second]'] = 'password123456';
        $form['user[email]'] = 'user-test2@email.com';
        $form['user[roles]'] = 'ROLE_ADMIN';

        $this->client->submit($form);
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! L\'utilisateur a bien été modifié');

        $user = $this->userRepository->findOneBy(['username' => 'TestUserEdited']);
        $this->assertNotNull($user);
        $this->assertEquals('ROLE_ADMIN', $user->getRoles()[0]);
    }


    public function getRoute(): string
    {
        return '/users/%s/edit';
    }
}
