<?php
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProduitTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testCreateProduit()
    {
        // Création d'un produit de test
        $produit = new Produit();
        $produit->setName('Produit A');
        $produit->setPrix(10);
        $produit->setDescription('Ceci est un produit de test');

        // Persistez le produit dans la base de données
        $this->entityManager->persist($produit);
        $this->entityManager->flush();

        // Vérifiez que le produit a bien été persisté
        $produitRepository = $this->entityManager->getRepository(Produit::class);
        $createdProduit = $produitRepository->findOneByName('Produit A');

        $this->assertEquals('Produit A', $createdProduit->getName());
        $this->assertEquals(10, $createdProduit->getPrix());
        $this->assertEquals('Ceci est un produit de test', $createdProduit->getDescription());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        // Supprimez les données de test de la base de données
        $this->entityManager->getRepository(Produit::class)->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->execute();

        $this->entityManager->close();
        $this->entityManager = null; // Évitez les fuites de mémoire
    }
}


