<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

class UserBuilder
{
    private ?User $user;
    private ?int $id = null;
    private ?string $username = null;
    private ?string $password = null;
    private ?string $email = null;
    private array $roles = [];
    private ArrayCollection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    /**
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @return User
     */
    public function build(): User
    {
        $this->user = new User();
        $this->addId();
        $this->addUsername();
        $this->addPassword();
        $this->addEmail();
        $this->addRoles();
        $this->addTasks();

        return $this->user;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param ArrayCollection $tasks
     *
     * @return $this
     */
    public function setTasks(ArrayCollection $tasks): self
    {
        $this->tasks = $tasks;

        return $this;
    }

    private function addId(): void
    {
        if (null === $this->id) {
            return;
        }

        $this->user->setId($this->id);
    }

    private function addUsername(): void
    {
        if (null === $this->username) {
            return;
        }

        $this->user->setUsername($this->username);
    }

    private function addPassword(): void
    {
        if (null === $this->password) {
            return;
        }

        $this->user->setPassword($this->password);
    }

    private function addEmail(): void
    {
        if (null === $this->email) {
            return;
        }

        $this->user->setEmail($this->email);
    }

    private function addRoles(): void
    {
        if (empty($this->roles)) {
            return;
        }

        $this->user->setRoles($this->roles);
    }

    private function addTasks(): void
    {
        if ($this->tasks->isEmpty()) {
            return;
        }

        foreach ($this->tasks as $task) {
            $this->user->addTask($task);
        }
    }
}
