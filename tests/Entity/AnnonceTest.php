<?php
use App\Entity\Annonces;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnnonceTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testCreateAnnonce()
    {
        // Création d'une annonce de test
        $annonce = new Annonces();
        $annonce->setStatut('Actif');
        // Assurez-vous d'assigner un objet Produit existant à l'annonce selon votre modèle de données

        // Persistez l'annonce dans la base de données
        $this->entityManager->persist($annonce);
        $this->entityManager->flush();

        // Vérifiez que l'annonce a bien été persistée
        $annonceRepository = $this->entityManager->getRepository(Annonces::class);
        $createdAnnonce = $annonceRepository->findOneByStatut('Actif');

        $this->assertEquals('Actif', $createdAnnonce->getStatut());
        // Vérifiez également les attributs liés à l'objet Produit
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        // Supprimez les données de test de la base de données
        $this->entityManager->getRepository(Annonces::class)->createQueryBuilder('a')
            ->delete()
            ->getQuery()
            ->execute();

        $this->entityManager->close();
        $this->entityManager = null; // Évitez les fuites de mémoire
    }
}
