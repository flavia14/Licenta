<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: FrontSensor::class)]
    private Collection $frontSensors;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: BackSensor::class)]
    private Collection $backSensors;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Actuator::class)]
    private Collection $actuator;

    public function __construct()
    {
        $this->frontSensors = new ArrayCollection();
        $this->backSensors = new ArrayCollection();
        $this->actuator = new ArrayCollection();
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

    /**
     * @return Collection<int, FrontSensor>
     */
    public function getFrontSensors(): Collection
    {
        return $this->frontSensors;
    }

    public function addFrontSensor(FrontSensor $frontSensor): self
    {
        if (!$this->frontSensors->contains($frontSensor)) {
            $this->frontSensors->add($frontSensor);
            $frontSensor->setCar($this);
        }

        return $this;
    }

    public function removeFrontSensor(FrontSensor $frontSensor): self
    {
        if ($this->frontSensors->removeElement($frontSensor)) {
            // set the owning side to null (unless already changed)
            if ($frontSensor->getCar() === $this) {
                $frontSensor->setCar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BackSensor>
     */
    public function getBackSensors(): Collection
    {
        return $this->backSensors;
    }

    public function addBackSensor(BackSensor $backSensor): self
    {
        if (!$this->backSensors->contains($backSensor)) {
            $this->backSensors->add($backSensor);
            $backSensor->setYes($this);
        }

        return $this;
    }

    public function removeBackSensor(BackSensor $backSensor): self
    {
        if ($this->backSensors->removeElement($backSensor)) {
            // set the owning side to null (unless already changed)
            if ($backSensor->getCar() === $this) {
                $backSensor->setCar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Actuator>
     */
    public function getActuator(): Collection
    {
        return $this->actuator;
    }

    public function addActuator(Actuator $actuator): self
    {
        if (!$this->actuator->contains($actuator)) {
            $this->actuator->add($actuator);
            $actuator->setCar($this);
        }

        return $this;
    }

    public function removeActuator(Actuator $actuator): self
    {
        if ($this->actuator->removeElement($actuator)) {
            // set the owning side to null (unless already changed)
            if ($actuator->getCar() === $this) {
                $actuator->setCar(null);
            }
        }

        return $this;
    }
}
