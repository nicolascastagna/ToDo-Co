<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserListController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    #[Route(path: '/users', name: 'user_list', methods: [Request::METHOD_GET])]
    public function list(): Response
    {
        return $this->render('user/list.html.twig', ['users' => $this->userRepository->findAll()]);
    }
}
