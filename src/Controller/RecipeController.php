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
}
