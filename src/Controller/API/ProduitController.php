<?php

namespace App\Controller\API;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/produits', name: 'api_produits_')]
class ProduitController extends AbstractController
{
    #[Route('', name: 'add', methods: 'POST')]
    public function addProduit(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $produit = new Produit();
        $produit->setName($data['name']);
        $produit->setPrix($data['prix']);
        $produit->setDescription($data['description']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produit);
        $entityManager->flush();

        return $this->json($produit, 201, [], ['groups' => 'read']);
    }

    #[Route('', name: 'get_all', methods: 'GET')]
    public function getAllProduits(ProduitRepository $produitRepository): JsonResponse
    {
        $produits = $produitRepository->findAll();

        return $this->json($produits, 200, [], ['groups' => 'read']);
    }

    #[Route('/{id}', name: 'get', methods: 'GET')]
    public function getProduit(Produit $produit): JsonResponse
    {
        return $this->json($produit, 200, [], ['groups' => 'read']);
    }

    #[Route('/{id}', name: 'update', methods: 'PUT')]
    public function updateProduit(Request $request, Produit $produit): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $produit->setName($data['name']);
        $produit->setPrix($data['prix']);
        $produit->setDescription($data['description']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json($produit, 200, [], ['groups' => 'read']);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function deleteProduit(Produit $produit): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($produit);
        $entityManager->flush();

        return $this->json(null, 204);
    }
}
