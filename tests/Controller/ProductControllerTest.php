<?php

namespace App\Test\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ProductRepository $repository;
    private string $path = '/product/crud/maker/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Product::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Product index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'product[name]' => 'Testing',
            'product[visible]' => 'Testing',
            'product[discount]' => 'Testing',
            'product[taxFreePrice]' => 'Testing',
            'product[description]' => 'Testing',
            'product[dateCreated]' => 'Testing',
            'product[category]' => 'Testing',
        ]);

        self::assertResponseRedirects('/product/crud/maker/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Product();
        $fixture->setName('My Title');
        $fixture->setVisible('My Title');
        $fixture->setDiscount('My Title');
        $fixture->setTaxFreePrice('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDateCreated('My Title');
        $fixture->setCategory('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Product');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Product();
        $fixture->setName('My Title');
        $fixture->setVisible('My Title');
        $fixture->setDiscount('My Title');
        $fixture->setTaxFreePrice('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDateCreated('My Title');
        $fixture->setCategory('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'product[name]' => 'Something New',
            'product[visible]' => 'Something New',
            'product[discount]' => 'Something New',
            'product[taxFreePrice]' => 'Something New',
            'product[description]' => 'Something New',
            'product[dateCreated]' => 'Something New',
            'product[category]' => 'Something New',
        ]);

        self::assertResponseRedirects('/product/crud/maker/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getVisible());
        self::assertSame('Something New', $fixture[0]->getDiscount());
        self::assertSame('Something New', $fixture[0]->getTaxFreePrice());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getDateCreated());
        self::assertSame('Something New', $fixture[0]->getCategory());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Product();
        $fixture->setName('My Title');
        $fixture->setVisible('My Title');
        $fixture->setDiscount('My Title');
        $fixture->setTaxFreePrice('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDateCreated('My Title');
        $fixture->setCategory('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/product/crud/maker/');
    }
}
