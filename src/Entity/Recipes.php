<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\RecipesRepository")
 */
class Recipes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $preparation_duration;

    /**
     * @ORM\Column(type="string")
     */
    private $baking_duration;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $additional_infos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="recipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Media", mappedBy="recipe", cascade={"persist", "remove"})
     */
    private $media;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecipeSteps", mappedBy="recipe")
     */
    private $recipeSteps;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecipeIngredients", mappedBy="recipe")
     */
    private $recipeIngredients;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating_stars;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $title;

    public function __construct()
    {
        $this->recipeSteps = new ArrayCollection();
        $this->recipeIngredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPreparationDuration(): ?string
    {
        return $this->preparation_duration;
    }

    public function setPreparationDuration(string $preparation_duration): self
    {
        $this->preparation_duration = $preparation_duration;

        return $this;
    }

    public function getBakingDuration(): ?string
    {
        return $this->baking_duration;
    }

    public function setBakingDuration(string $baking_duration): self
    {
        $this->baking_duration = $baking_duration;

        return $this;
    }

    public function getAdditionalInfos(): ?string
    {
        return $this->additional_infos;
    }

    public function setAdditionalInfos(?string $additional_infos): self
    {
        $this->additional_infos = $additional_infos;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(Media $media): self
    {
        $this->media = $media;

        // set the owning side of the relation if necessary
        if ($media->getRecipe() !== $this) {
            $media->setRecipe($this);
        }

        return $this;
    }

    /**
     * @return Collection|RecipeSteps[]
     */
    public function getRecipeSteps(): Collection
    {
        return $this->recipeSteps;
    }

    public function addRecipeStep(RecipeSteps $recipeStep): self
    {
        if (!$this->recipeSteps->contains($recipeStep)) {
            $this->recipeSteps[] = $recipeStep;
            $recipeStep->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeStep(RecipeSteps $recipeStep): self
    {
        if ($this->recipeSteps->contains($recipeStep)) {
            $this->recipeSteps->removeElement($recipeStep);
            // set the owning side to null (unless already changed)
            if ($recipeStep->getRecipe() === $this) {
                $recipeStep->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RecipeIngredients[]
     */
    public function getRecipeIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function addRecipeIngredient(RecipeIngredients $recipeIngredient): self
    {
        if (!$this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients[] = $recipeIngredient;
            $recipeIngredient->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredients $recipeIngredient): self
    {
        if ($this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->removeElement($recipeIngredient);
            // set the owning side to null (unless already changed)
            if ($recipeIngredient->getRecipe() === $this) {
                $recipeIngredient->setRecipe(null);
            }
        }

        return $this;
    }

    public function getRatingStars(): ?int
    {
        return $this->rating_stars;
    }

    public function setRatingStars(int $rating_stars): self
    {
        $this->rating_stars = $rating_stars;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
