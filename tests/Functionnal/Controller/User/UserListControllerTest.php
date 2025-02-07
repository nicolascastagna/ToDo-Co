<?php

namespace App\Tests\Functionnal\Controller\User;

use App\Tests\Functionnal\AbstractTodoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserListControllerTest extends AbstractTodoWebTestCase
{
    public function testGetUserListAsRoleAdmin(): void
    {
        $this->loginAdmin();
        $this->requestGET(sprintf($this->getRoute()));

        $this->assertOKResponse();
    }

    public function testGetUserListAsRoleUser(): void
    {
        $this->loginUser();
        $this->requestGET(sprintf($this->getRoute()));

        $this->assertResponseRedirects('/', Response::HTTP_FOUND);
        $this->client->followRedirect();
    }

    public function getRoute(): string
    {
        return '/users';
    }
}
