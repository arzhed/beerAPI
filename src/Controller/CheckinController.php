<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Checkin;
use App\Entity\Beer;
use App\Entity\User;

class CheckinController extends AbstractController
{
    use ValidatorTrait;

    /**
     * @Route("/checkin", name="create_checkin", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(Checkin::class);

        /**
         * Validation
         **/
         //@TODO replace user_id param with JWT identification
        $missing = $this->checkMandatoryParams(['note', 'beer_id', 'user_id'], $request);
        if ($missing !== true) {
            return new Response("Parameter '$missing' is missing", 400);
        }

        $note = $request->get('note');
        if (!is_numeric($note)) {
            return new Response("Note must be numeric", 400);
        }
        $note = (float) $note;
        if ($note > 10 || $note < 0) {
            return new Response("Note must be between 0 and 10.0", 400);
        }

        $beer = $this->getDoctrine()->getRepository(Beer::class)->find($request->get('beer_id'));
        if (!$beer) {
            return new Response("Could not find Beer", 400);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('user_id'));
        if (!$user) {
            return new Response("Could not find User", 400);
        }
        /**
         * END Validation
         **/

         $checkin = $rep->createOrUpdate($note, $beer, $user);

        return $this->json([
            'note'    => $checkin->getNote(),
            'beer_id' => $checkin->getBeer()->getId(),
            'user_id' => $checkin->getUser()->getId()
        ]);
    }
}
