<?php

namespace App\Controller\API;

use App\Repository\AnnoncesRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/main/', name: 'api_main_')]
class MainController extends AbstractController
{

    #[Route('produits', name: 'produits', methods: "GET")]
    public function produits(ProduitRepository $produitRepository): JsonResponse
    {
        return $this->json($produitRepository->findAll(), 200, [], ['groups' => 'read']);
    }

    #[Route('annonces', name: 'annonces', methods: "GET")]
    public function annonces(AnnoncesRepository $annoncesRepository): JsonResponse
    {
        return $this->json($annoncesRepository->findAll(), 200, [], ['groups' => 'read']);
    }
}
