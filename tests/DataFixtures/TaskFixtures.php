<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures;

use App\Entity\User;
use App\Tests\Builder\TaskBuilder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public const TASK_ADMIN = 'task_admin';
    public const TASK_USER_PREFIX = 'task_user_';

    public const TASKS_ARRAY = [
        [
            'title' => 'Tâche admin',
            'content' => 'Ceci est une description de la tâche créée par l\'utilisateur admin.',
            'isDone' => false,
            'user' => UserFixtures::EMAIL_ADMIN,
            'ref' => self::TASK_ADMIN
        ],
        [
            'title' => 'Tâche de l\'utilisateur user1',
            'content' => 'Ceci est une description de la tâche créée par l\'utilisateur user1.',
            'isDone' => false,
            'user' => UserFixtures::EMAIL_USER1,
            'ref' => self::TASK_USER_PREFIX . '1'
        ],
        [
            'title' => 'Tâche de l\'utilisateur user2',
            'content' => 'Ceci est une description de la tâche créée par l\'utilisateur user2.',
            'isDone' => true,
            'user' => UserFixtures::EMAIL_USER2,
            'ref' => self::TASK_USER_PREFIX . '2'
        ],
        [
            'title' => 'Tâche de l\'utilisateur user3',
            'content' => 'Ceci est une description de la tâche créée par l\'utilisateur user3.',
            'isDone' => true,
            'user' => UserFixtures::EMAIL_USER3,
            'ref' => self::TASK_USER_PREFIX . '3'
        ],
        [
            'title' => 'Tâche de l\'utilisateur user4',
            'content' => 'Ceci est une description de la tâche créée par l\'utilisateur user4.',
            'isDone' => false,
            'user' => UserFixtures::EMAIL_USER4,
            'ref' => self::TASK_USER_PREFIX . '4'
        ],
        [
            'title' => 'Tâche de l\'utilisateur user5',
            'content' => 'Ceci est une description de la tâche créée par l\'utilisateur user5.',
            'isDone' => false,
            'user' => UserFixtures::EMAIL_USER5,
            'ref' => self::TASK_USER_PREFIX . '5'
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TASKS_ARRAY as ['title' => $title, 'content' => $content, 'isDone' => $isDone, 'user' => $user, 'ref' => $ref]) {
            /** @var User $userRef */
            $userRef = $this->getReference($user, User::class);
            $newTask = $this->initTask($title, $content, $isDone, $userRef)
                ->build();
            $manager->persist($newTask);
            $this->addReference($ref, $newTask);
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    /**
     * @param string $title
     * @param string $content
     * @param User $user
     *
     * @return TaskBuilder
     */
    private function initTask(string $title, string $content, bool $isDone, User $user): TaskBuilder
    {
        return TaskBuilder::create()
            ->setTitle($title)
            ->setContent($content)
            ->setIsDone($isDone)
            ->setUser($user);
    }
}
