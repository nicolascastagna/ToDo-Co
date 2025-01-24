<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures;

use App\Entity\User;
use App\Tests\Builder\UserBuilder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const EMAIL_ANONYMOUS = 'anonymous@email.com';
    public const USERNAME_ANONYMOUS = 'anonymous_user';
    public const EMAIL_ADMIN = 'admin@email.com';
    public const USERNAME_ADMIN = 'admin_user';
    public const PASSWORD = 'password';

    public const EMAIL_USER1 = 'user1@email.com';
    public const EMAIL_USER2 = 'user2@email.com';
    public const EMAIL_USER3 = 'user3@email.com';
    public const EMAIL_USER4 = 'user4@email.com';
    public const EMAIL_USER5 = 'user5@email.com';

    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const USERS_ARRAY = [
        [
            'ref' => self::EMAIL_ANONYMOUS,
            'username' => self::USERNAME_ANONYMOUS,
            'password' => self::PASSWORD,
            'roles' => [self::ROLE_USER],
            // 'ref' => self::EMAIL_ANONYMOUS,
        ],
        [
            'ref' => self::EMAIL_ADMIN,
            'username' => self::USERNAME_ADMIN,
            'password' => self::PASSWORD,
            'roles' => [self::ROLE_ADMIN],
            // 'ref' => self::EMAIL_ADMIN,
        ],
        [
            'ref' => self::EMAIL_USER1,
            'username' => 'user1',
            'password' => self::PASSWORD . '-1',
            'roles' => [self::ROLE_USER],
            // 'ref' => self::EMAIL_USER1,
        ],
        [
            'ref' => self::EMAIL_USER2,
            'username' => 'user2',
            'password' => self::PASSWORD . '-2',
            'roles' => [self::ROLE_USER],
            // 'ref' => self::EMAIL_USER2,
        ],
        [
            'ref' => self::EMAIL_USER3,
            'username' => 'user3',
            'password' => self::PASSWORD . '-3',
            'roles' => [self::ROLE_USER],
            // 'ref' => self::EMAIL_USER3,
        ],
        [
            'ref' => self::EMAIL_USER4,
            'username' => 'user4',
            'password' => self::PASSWORD . '-4',
            'roles' => [self::ROLE_USER],
            // 'ref' => self::EMAIL_USER4,
        ],
        [
            'ref' => self::EMAIL_USER5,
            'username' => 'user5',
            'password' => self::PASSWORD . '-5',
            'roles' => [self::ROLE_USER],
            // 'ref' => self::EMAIL_USER5,
        ]
    ];

    public function __construct(private readonly UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS_ARRAY as ['ref' => $ref, 'username' => $username, 'password' => $password, 'roles' => $roles]) {
            $newUser = $this->initUser($username, $ref, $password, $roles)
                ->setPassword($this->hasher->hashPassword(new User(), $password))
                ->build();
            $manager->persist($newUser);
            $this->addReference($ref, $newUser);
        }

        $manager->flush();
    }

    /**
     * @param string $username
     * @param string $email
     * @param array $roles
     *
     * @return UserBuilder
     */
    private function initUser(string $username, string $ref, string $password, array $roles): UserBuilder
    {
        return UserBuilder::create($this->hasher)
            ->setUsername($username)
            ->setEmail($ref)
            ->setPassword($password)
            ->setRoles($roles);
    }
}
