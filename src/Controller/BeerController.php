<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Beer;

class BeerController extends AbstractController
{
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
     * @Route("/beer/{id}", name="beer")
     */
    public function find(int $id)
    {
        $beer = $this->getDoctrine()->getRepository(Beer::class)->find($id);

        if (!$beer) {
            return $this->getResponse()->setStatusCode('404');
        }

        return $this->json([
            'id'   => $beer->getId(),
            'name' => $beer->getName(),
            'abv'  => $beer->getAbv(),
            'ibu'  => $beer->getIbu(),
            'brewery_id' => $beer->getBrewery()->getId()
        ]);
    }

    /**
     * @Route("/beer", name="create_beer", methods={"POST"})
     */
    public function create()
    {
        return $this->json(['hola']);
    }


}
