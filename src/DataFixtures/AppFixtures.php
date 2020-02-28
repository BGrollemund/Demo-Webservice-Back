<?php

namespace App\DataFixtures;

use App\Entity\Ingredients;
use App\Entity\Media;
use App\Entity\RecipeIngredients;
use App\Entity\Recipes;
use App\Entity\RecipeSteps;
use App\Entity\Steps;
use App\Entity\Users;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Faker\Factory;
use Faker\Generator;
use Bezhanov\Faker\ProviderCollectionHelper;
use Bezhanov\Faker\Provider\Food;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var Generator
     */
    private $faker;

    public function __construct( UserPasswordEncoderInterface $encoder )
    {
        $this->encoder = $encoder;

        $this->faker = Factory::create();
        ProviderCollectionHelper::addAllProvidersTo($this->faker);
        $this->faker->addProvider(new Food($this->faker));
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadIngredients($manager);
        $this->loadSteps($manager);
        $this->loadRecipes($manager);
        $this->loadMedia($manager);
        $this->loadRecipeIngredients($manager);
        $this->loadRecipeSteps($manager);
    }

    public function loadUsers( ObjectManager $manager )
    {
        for( $i=1; $i<6; $i++ ) {
            $user = new Users();
            $user
                ->setUsername($this->faker->userName)
                ->setPassword($this->encoder->encodePassword($user, '123'));
            $this->setReference('user-'.$i, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function loadIngredients( ObjectManager $manager )
    {
        for( $i=1; $i<21; $i++ ) {
            $ingredient = new Ingredients();
            $ingredient->setLabel($this->faker->ingredient);
            $this->setReference('ingredient-'.$i, $ingredient);
            $manager->persist($ingredient);
        }

        for( $i=21; $i<31; $i++ ) {
            $spice = new Ingredients();
            $spice->setLabel($this->faker->spice);
            $this->setReference('ingredient-'.$i, $spice);
            $manager->persist($spice);
        }

        $manager->flush();
    }

    public function loadSteps( ObjectManager $manager )
    {
        for( $i=1; $i<51; $i++ ) {
            $step = new Steps();
            $step
                ->setLabel($this->faker->word)
                ->setDescription($this->faker->paragraph(3, true));
            $this->setReference('step-'.$i, $step);
            $manager->persist($step);
        }

        $manager->flush();
    }

    public function loadRecipes( ObjectManager $manager )
    {
        for( $i=1; $i<6; $i++ ) {
            for( $j=1; $j<21; $j++ ) {
                $rand_time_1 = '0' . rand(0,2) . ':' . ['00', '15', '30', '45'][rand(0,3)] ;
                $rand_time_2 = '0' . rand(0,1) . ':' . ['00', '15', '30', '45'][rand(0,3)] ;

                $recipe = new Recipes();
                $recipe
                    ->setTitle( $this->faker->word )
                    ->setPreparationDuration( $rand_time_1 )
                    ->setBakingDuration( $rand_time_2 )
                    ->setAdditionalInfos ($this->faker->words(10, true) )
                    ->setRatingStars( rand(1,5) )
                    ->setUser( $this->getReference('user-'.$i) );
                $this->setReference('recipe-'.$i.'-'.$j, $recipe);
                $manager->persist($recipe);
            }
        }

        $manager->flush();
    }

    public function loadMedia( ObjectManager $manager )
    {
        for( $i=1; $i<6; $i++ ) {
            for( $j=1; $j<21; $j++ ) {
                $medium = new Media();
                $medium
                    ->setFilename( 'recipe-'.$i.'-'.$j.'.jpg' )
                    ->setUpdatedAt( new DateTime('now') )
                    ->setRecipe( $this->getReference('recipe-'.$i.'-'.$j) );
                $manager->persist($medium);
            }
        }

        $manager->flush();
    }

    public function loadRecipeIngredients( ObjectManager $manager )
    {
        for( $i = 1; $i < 6; $i++ ) {
            for( $j = 1; $j < 21; $j++ ) {
                for( $k = 0; $k < 6; $k++ ) {
                    $recipe_ingredient = new RecipeIngredients();
                    $recipe_ingredient
                        ->setQuantity($this->faker->measurement)
                        ->setRecipe($this->getReference('recipe-' . $i . '-' . $j))
                        ->setIngredient($this->getReference( 'ingredient-'.(rand($k*5+1, $k*5+5))));
                    $manager->persist($recipe_ingredient);
                }
            }
        }

        $manager->flush();
    }

    public function loadRecipeSteps( ObjectManager $manager )
    {
        for( $i = 1; $i < 6; $i++ ) {
            for( $j = 1; $j < 21; $j++ ) {
                for( $k = 0; $k < 10; $k++ ) {
                    $recipe_step = new RecipeSteps();
                    $recipe_step
                        ->setStepOrder($k+1)
                        ->setRecipe($this->getReference('recipe-' . $i . '-' . $j))
                        ->setStep($this->getReference( 'step-'.(rand($k*5+1, $k*5+5))));
                    $manager->persist($recipe_step);
                }
            }
        }

        $manager->flush();
    }
}
