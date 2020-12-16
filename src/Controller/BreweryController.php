<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Brewery;

class BreweryController extends AbstractController
{
    use ValidatorTrait;

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

    /**
     * @Route("/brewery", name="create_brewery", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(Brewery::class);

        $missing = $this->checkMandatoryParams(['name'], $request);
        if ($missing !== true) {
            return new Response("Parameter '$missing' is missing", 400);
        }

        $brewer = $rep->findOneBy(['name' => $request->request->get('name')]);
        if ($brewer) {
            return new Response("Duplicate", 409);
        }

        $brewer = $rep->create([
            'brewery'     => $request->get('name'),
            'address'     => $request->get('address'),
            'city'        => $request->get('city'),
            'state'       => $request->get('state'),
            'country'     => $request->get('country'),
            'coordinates' => $request->get('coordinates'),
            'website'     => $request->get('website')
        ]);

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

    /**
     * @Route("/brewery/{id}", name="update_brewery", methods={"PUT"})
     */
    public function update(int $id, Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(Brewery::class);

        $brewer = $rep->find($id);
        if (!$brewer) {
            return new Response('Not Found', 404);
        }

        try {
            $brewer = $rep->update($brewer, [
                'name'        => $request->get('name'),
                'address'     => $request->get('address'),
                'city'        => $request->get('city'),
                'state'       => $request->get('state'),
                'country'     => $request->get('country'),
                'coordinates' => $request->get('coordinates'),
                'website'     => $request->get('website')
            ]);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 400);
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
