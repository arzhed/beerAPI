<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

class UserController extends AbstractController
{
    use ValidatorTrait;

    /**
     * @Route("/user", name="user", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(User::class);

        $missing = $this->checkMandatoryParams(['email','password', 'pseudo'], $request);
        if ($missing !== true) {
            return new Response("Parameter '$missing' is missing", 400);
        }

        $user = $rep->findOneBy(['email' => $request->request->get('email')]);
        if ($user) {
            return new Response("Duplicate", 409);
        }

        //@TODO check email format + password length and complexity + pseudo unicity

        $user = $rep->create([
            'email'    => $request->get('email'),
            'password' => $request->get('password'),
            'pseudo'   => $request->get('pseudo')
        ]);

        //@TODO send confirmation email

        return $this->json([
            'id'       => $user->getId(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'pseudo'   => $user->getPseudo()
        ]);
    }
}
