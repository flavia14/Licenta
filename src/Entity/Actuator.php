<?php

namespace App\Entity;

use App\Repository\ActuatorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActuatorRepository::class)]
class Actuator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $priority = null;

    #[ORM\Column]
    private ?bool $value = null;

    #[ORM\Column(nullable: true)]
    private ?bool $feedback = null;

    #[ORM\ManyToOne(inversedBy: 'actuator')]
    private ?Car $car = null;

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

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function isValue(): ?bool
    {
        return $this->value;
    }

    public function setValue(bool $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function isFeedback(): ?bool
    {
        return $this->feedback;
    }

    public function setFeedback(?bool $feedback): self
    {
        $this->feedback = $feedback;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }
}
