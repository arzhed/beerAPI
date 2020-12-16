<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Beer;
use App\Entity\Brewery;

class BeerController extends AbstractController
{

    use ValidatorTrait;

    /**
     * @Route("/beer", name="beers", methods={"GET"})
     */
    public function index(): Response
    {
        $beerRepository = $this->getDoctrine()->getRepository(Beer::class);

        $sort = $_GET['sort'] ?? null;
        $offset = (int)($_GET['offset'] ?? 0);
        $limit = (int)($_GET['limit'] ?? 5);

        $beers = $beerRepository->get($sort, $offset, $limit);

        return $this->json($beers);
    }

    /**
     * @Route("/beer/{id}", name="beer", methods={"GET"})
     */
    public function find(int $id)
    {
        $beer = $this->getDoctrine()->getRepository(Beer::class)->find($id);

        if (!$beer) {
            return $this->getResponse()->setStatusCode('404');
        }

        return $this->json([
            'id'          => $beer->getId(),
            'name'        => $beer->getName(),
            'abv'         => $beer->getAbv(),
            'ibu'         => $beer->getIbu(),
            'description' => $beer->getDescription(),
            'brewery_id'  => $beer->getBrewery()->getId()
        ]);
    }

    /**
     * @Route("/beer", name="create_beer", methods={"POST"})
     */
    public function create(Request $request)
    {
        $missing = $this->checkMandatoryParams(['name', 'ibu', 'abv'], $request);
        if ($missing !== true) {
            return new Response("Parameter '$missing' is missing", 400);
        }

        $brewery_id = $request->request->get('brewery_id');
        $brewer = is_numeric($brewery_id)
            ? $this->getDoctrine()->getRepository(Brewery::class)->find((int)$brewery_id)
            : null;

        $beer = $this->getDoctrine()->getRepository(Beer::class)->createFromArray([
            'name'        => $request->request->get('name'),
            'ibu'         => $request->request->get('ibu'),
            'abv'         => $request->request->get('abv'),
            'description' => $request->request->get('description')
        ], $brewer);

        if ($beer) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($beer);
            $em->flush();
        } else {
            return new Response("Possibly a duplicate", 409);
        }

        return $this->json($beer->getId());
    }

    /**
     * @Route("/beer/{id}", name="update_beer", methods={"PUT"})
     */
    public function update(int $id, Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(Beer::class);

        $beer = $rep->find($id);
        if (!$beer)
            return new Response('Could not find Beer', 404);

        $beer = $rep->update($beer, [
            'name'        => $request->get('name'),
            'ibu'         => $request->get('ibu'),
            'abv'         => $request->get('abv'),
            'description' => $request->get('description'),
            'brewery_id'  => $request->get('brewery_id')
        ]);

        return $this->json([
            'id'          => $beer->getId(),
            'name'        => $beer->getName(),
            'abv'         => $beer->getAbv(),
            'ibu'         => $beer->getIbu(),
            'description' => $beer->getDescription(),
            'brewery_id'  => $beer->getBrewery()->getId()
        ]);
    }

    /**
     * @Route("/beer/{id}", name="delete_beer", methods={"DELETE"})
     */
    public function delete(int $id)
    {
        $rep = $this->getDoctrine()->getRepository(Beer::class);

        $beer = $rep->find($id);
        if (!$beer)
            return new Response('Could not find Beer', 404);

        $em = $this->getDoctrine()->getManager();
        $em->remove($beer);
        $em->flush();

        return new Response('OK');
    }

}
