<?php


namespace App\Controller;

use App\Entity\Users;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/id-by-user/{username}", name="recipes-by-user")
     * @param string $username
     * @return JsonResponse
     */
    public function getIdByUser( string $username )
    {
        $user_id = $this
            ->getDoctrine()
            ->getRepository(Users::class)
            ->findOneBy( ['username' => $username ] )
            ->getId();

        return $this->json(['id' => $user_id ]);
    }
}
