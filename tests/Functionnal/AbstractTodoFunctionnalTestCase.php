<?php

declare(strict_types=1);

namespace App\Tests\Functionnal;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Tests\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractTodoFunctionnalTestCase extends WebTestCase
{
    protected ?KernelBrowser $client = null;

    protected ?UserRepository $userRepository = null;

    protected ?TaskRepository $taskRepository = null;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = $this->get(UserRepository::class);
        $this->taskRepository = $this->get(TaskRepository::class);
    }

    /**
     * @template  T of object
     *
     * @param class-string<T> $service
     *
     * @return T
     */
    protected function get(string $service)
    {
        return $this->getContainerInterface()->get($service);
    }

    protected function var(string $name): string
    {
        return $this->getContainerInterface()->getParameter($name);
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainerInterface(): ContainerInterface
    {
        return $this->client->getContainer();
    }

    /**
     * @param string $email
     */
    protected function login(string $email): void
    {
        $user = $this->getUser($email);
        $this->client->loginUser($user);
    }

    protected function loginAnonymous(): void
    {
        $this->login(UserFixtures::EMAIL_ANONYMOUS);
    }

    protected function loginUser(): void
    {
        $this->login(UserFixtures::EMAIL_USER1);
    }

    protected function loginAdmin(): void
    {
        $this->login(UserFixtures::EMAIL_ADMIN);
    }

    /**
     * @param string $email
     *
     * @return User|null
     */
    protected function getUser(string $email): ?User
    {
        return $this->userRepository->findOneByEmail($email);
    }

    /**
     * @param string $title
     *
     * @return Task|null
     */
    protected function getTask(string $title): ?Task
    {
        return $this->taskRepository->findOneBy(['title' => $title]);
    }
}
