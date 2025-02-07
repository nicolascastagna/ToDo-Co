<?php

namespace App\Tests\Functionnal\Controller\User;

use App\Repository\UserRepository;
use App\Tests\DataFixtures\UserFixtures;
use App\Tests\Functionnal\AbstractTodoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserEditControllerTest extends AbstractTodoWebTestCase
{
    private $testUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testUser = $this->get(UserRepository::class)->findOneByEmail(UserFixtures::EMAIL_ADMIN);
    }

    public function testDisplayCreateUserForm(): void
    {
        $this->loginAdmin();
        $this->requestGET(sprintf($this->getRoute(), $this->testUser->getId()));

        $this->assertOKResponse();

        $this->assertSelectorExists('input[name="user[username]"]');
        $this->assertSelectorExists('input[name="user[password][first]"]');
        $this->assertSelectorExists('input[name="user[password][second]"]');
        $this->assertSelectorExists('select[name="user[roles]"]');
    }

    public function testSubmitInvalidEditUserForm(): void
    {
        $this->loginAdmin();
        $crawler = $this->requestGET(sprintf($this->getRoute(), $this->testUser->getId()));

        $this->assertOKResponse();

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'TestUserEdited';
        $form['user[password][first]'] = 'password123456';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'user-test2@email.com';
        $form['user[roles]'] = 'ROLE_ADMIN';

        $this->client->submit($form);
        $this->assertUnprocessableResponse();
    }


    public function testSubmitValidEditUserForm(): void
    {
        $this->loginAdmin();
        $crawler = $this->requestGET(sprintf($this->getRoute(), $this->testUser->getId()));

        $this->assertOKResponse();

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'TestUserEdited';
        $form['user[password][first]'] = 'password123456';
        $form['user[password][second]'] = 'password123456';
        $form['user[email]'] = 'user-test2@email.com';
        $form['user[roles]'] = 'ROLE_ADMIN';

        $this->client->submit($form);
        $this->assertResponseRedirects('/users', Response::HTTP_FOUND);
        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! L\'utilisateur a bien été modifié');

        $user = $this->getUser('user-test2@email.com');
        $this->assertNotNull($user);
        $this->assertEquals('ROLE_ADMIN', $user->getRoles()[0]);
    }


    public function getRoute(): string
    {
        return '/users/%s/edit';
    }
}
