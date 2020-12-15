<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Beer;

class BeerController extends AbstractController
{
    /**
     * @Route("/beer", name="beer")
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
}
