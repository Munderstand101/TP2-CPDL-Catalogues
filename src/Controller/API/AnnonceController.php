<?php

namespace App\Controller\API;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/annonces', name: 'api_annonces_')]
class AnnonceController extends AbstractController
{
    #[Route('', name: 'add', methods: 'POST')]
    public function addAnnonce(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $annonce = new Annonces();
        $annonce->setStatut($data['statut']);
        // Assurez-vous de récupérer l'objet Produit correctement selon votre modèle de données
        $annonce->setProduit($data['produit']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($annonce);
        $entityManager->flush();

        return $this->json($annonce, 201, [], ['groups' => 'read']);
    }

    #[Route('', name: 'get_all', methods: 'GET')]
    public function getAllAnnonces(AnnoncesRepository $annonceRepository): JsonResponse
    {
        $annonces = $annonceRepository->findAll();

        return $this->json($annonces, 200, [], ['groups' => 'read']);
    }

    #[Route('/{id}', name: 'get', methods: 'GET')]
    public function getAnnonce(Annonces $annonce): JsonResponse
    {
        return $this->json($annonce, 200, [], ['groups' => 'read']);
    }

    #[Route('/{id}', name: 'update', methods: 'PUT')]
    public function updateAnnonce(Request $request, Annonce $annonce): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $annonce->setStatut($data['statut']);
        // Assurez-vous de mettre à jour l'objet Produit correctement selon votre modèle de données
        $annonce->setProduit($data['produit']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json($annonce, 200, [], ['groups' => 'read']);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function deleteAnnonce(Annonces $annonce): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($annonce);
        $entityManager->flush();

        return $this->json(null, 204);
    }
}
