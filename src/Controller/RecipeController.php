<?php


namespace App\Controller;

use App\Entity\Recipes;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{


    /**
     * @Route("/api/my-recipes/{username}", name="repicesFromUser")
     * @param string $username
     * @return JsonResponse
     */
    public function recipesFromUser( string $username )
    {
        $recipes = $this
            ->getDoctrine()
            ->getRepository( Users::class )
            ->findOneBy( ['username' => $username ] )
            ->getRecipes()
            ->toArray();

        return $this->json( [ 'recipes' => $recipes ] );
    }

    /**
     * @Route("/api/recipe-full-infos/{recipe_id}", name="repiceFullInfos")
     * @param int $recipe_id
     * @return JsonResponse
     */
    public function recipeFullInfo( int $recipe_id )
    {
        $recipe = $this
            ->getDoctrine()
            ->getRepository( Recipes::class )
            ->find( $recipe_id );

        $ingredients = $recipe
            ->getRecipeIngredients()
            ->toArray();

        $ingredientsLabel = [];
        foreach( $ingredients as $ingredient ) {
            $ingredientsLabel[] = $ingredient->getIngredient();
        }

        $medium = $recipe
            ->getMedia();


        $steps = $recipe
            ->getRecipeSteps()
            ->toArray();

        $stepsLabel = [];
        foreach( $steps as $step ) {
            $stepsLabel[] = $step->getStep();
        }

        return $this->json( [
            'ingredients' => $ingredients,
            'ingredientsLabel' => $ingredientsLabel,
            'medium' => $medium,
            'recipe' => $recipe,
            'steps' => $steps,
            'stepsLabel' => $stepsLabel
        ] );
    }

    /**
     * @Route("/api/recipes-with-ingredients/{recipe_id}", name="recipesWithIngredients")
     * @param int $recipe_id
     * @return JsonResponse
     */
    public function recipesWithIngredients( int $recipe_id )
    {
        $current_ingredients_object = $this
            ->getDoctrine()
            ->getRepository( Recipes::class )
            ->find( $recipe_id )
            ->getRecipeIngredients()
            ->toArray();

        $current_ingredients = [];

        foreach( $current_ingredients_object as $current_ingredient_object ) {
            $current_ingredients[] = $current_ingredient_object->getIngredient()->getId();
        }
        $recipes = $this
            ->getDoctrine()
            ->getRepository( Recipes::class )
            ->findAll();

        $result = [];

        foreach( $recipes as $recipe ) {
            if( count($result) >= 3 )  return $this->json( [ 'recipes' => $result ] );

            $to_check_ingredients_object = $recipe
                ->getRecipeIngredients()
                ->toArray();
            $to_check_ingredients = [];

            foreach( $to_check_ingredients_object as $to_check_ingredient_object ) {
                $to_check_ingredients[] = $to_check_ingredient_object->getIngredient()->getId();
            }

            if( count(array_intersect( $current_ingredients, $to_check_ingredients )) >=3 ) {
                $result[] = $recipe;
            }
        }

        return $this->json( [ 'recipes' => $result ] );
    }
}
