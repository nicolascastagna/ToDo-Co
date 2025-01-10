<?php

namespace App\Controller\Task;

use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskListController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TaskRepository $taskRepository
    ) {
    }

    #[Route(path: '/tasks', name: 'task_list', methods: [Request::METHOD_GET])]
    public function list(): Response
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->taskRepository->findAll()]);
    }
}
