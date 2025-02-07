<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Entity\Task;
use App\Entity\User;
use DateTime;

class TaskBuilder
{
    private ?Task $task;

    private ?int $id = null;
    private ?DateTime $createdAt = null;
    private ?string $title = null;
    private ?string $content = null;
    private ?bool $isDone = null;
    private ?User $user = null;

    /**
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @return Task
     */
    public function build(): Task
    {
        $this->task = new Task();
        $this->addId();
        $this->addCreatedAt();
        $this->addTitle();
        $this->addContent();
        $this->addIsDone();
        $this->addUser();

        return $this->task;
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
     * @param DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param bool $isDone
     *
     * @return $this
     */
    public function setIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    /**
     * @param User|null $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    private function addCreatedAt(): void
    {
        if (null === $this->createdAt) {
            return;
        }

        $this->task->setCreatedAt($this->createdAt);
    }

    private function addTitle(): void
    {
        if (null === $this->title) {
            return;
        }

        $this->task->setTitle($this->title);
    }

    private function addContent(): void
    {
        if (null === $this->content) {
            return;
        }

        $this->task->setContent($this->content);
    }

    private function addIsDone(): void
    {
        if (null === $this->isDone) {
            return;
        }

        $this->task->toggle($this->isDone);
    }

    private function addUser(): void
    {
        if (null === $this->user) {
            return;
        }

        $this->task->setUser($this->user);
    }

    private function addId(): void
    {
        if (null === $this->id) {
            return;
        }

        $this->task->setId($this->id);
    }
}
