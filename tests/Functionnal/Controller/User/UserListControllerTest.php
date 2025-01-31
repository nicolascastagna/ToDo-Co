<?php

namespace App\Tests\Functionnal\Controller\User;

use App\Tests\Functionnal\AbstractTodoWebTestCase;

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

        $this->assertForbiddenResponse();
    }

    public function getRoute(): string
    {
        return '/users';
    }
}
