<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Brewery;

class BreweryController extends AbstractController
{
    /**
     * @Route("/brewery/{id}", name="brewery", methods={"GET"})
     */
    public function find(int $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Brewery::class);

        $brewer = $rep->find($id);
        if (!$brewer) {
            return new Response('Could not find Brewery', 404);
        }

        return $this->json([
            'name'        => $brewer->getName(),
            'address'     => $brewer->getAddress(),
            'city'        => $brewer->getCity(),
            'state'       => $brewer->getState(),
            'country'     => $brewer->getCountry(),
            'coordinates' => $brewer->getCoordinates(),
            'website'     => $brewer->getWebsite(),
        ]);
    }
}
