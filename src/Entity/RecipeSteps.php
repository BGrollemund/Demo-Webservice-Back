<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\RecipeStepsRepository")
 */
class RecipeSteps
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $step_order;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipes", inversedBy="recipeSteps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Steps", inversedBy="recipeSteps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $step;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStepOrder(): ?int
    {
        return $this->step_order;
    }

    public function setStepOrder(int $step_order): self
    {
        $this->step_order = $step_order;

        return $this;
    }

    public function getRecipe(): ?Recipes
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipes $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getStep(): ?Steps
    {
        return $this->step;
    }

    public function setStep(?Steps $step): self
    {
        $this->step = $step;

        return $this;
    }
}
