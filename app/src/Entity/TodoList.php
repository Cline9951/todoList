<?php

namespace App\Entity;

use App\Repository\TodoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoListRepository::class)]
class TodoList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'todolist', targetEntity: Task::class)]
    private $task_id;

    public function __construct()
    {
        $this->task_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTaskId(): Collection
    {
        return $this->task_id;
    }

    public function addTaskId(Task $taskId): self
    {
        if (!$this->task_id->contains($taskId)) {
            $this->task_id[] = $taskId;
            $taskId->setTodolist($this);
        }

        return $this;
    }

    public function removeTaskId(Task $taskId): self
    {
        if ($this->task_id->removeElement($taskId)) {
            // set the owning side to null (unless already changed)
            if ($taskId->getTodolist() === $this) {
                $taskId->setTodolist(null);
            }
        }

        return $this;
    }
}
