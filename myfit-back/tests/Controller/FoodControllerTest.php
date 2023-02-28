<?php

namespace App\Test\Controller;

use App\Entity\Food;
use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FoodControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FoodRepository $repository;
    private string $path = '/food/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Food::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Food index');

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
            'food[calories]' => 'Testing',
            'food[nutrients]' => 'Testing',
            'food[water]' => 'Testing',
            'food[date_time]' => 'Testing',
        ]);

        self::assertResponseRedirects('/food/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Food();
        $fixture->setCalories('My Title');
        $fixture->setNutrients('My Title');
        $fixture->setWater('My Title');
        $fixture->setDate_time('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Food');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Food();
        $fixture->setCalories('My Title');
        $fixture->setNutrients('My Title');
        $fixture->setWater('My Title');
        $fixture->setDate_time('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'food[calories]' => 'Something New',
            'food[nutrients]' => 'Something New',
            'food[water]' => 'Something New',
            'food[date_time]' => 'Something New',
        ]);

        self::assertResponseRedirects('/food/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCalories());
        self::assertSame('Something New', $fixture[0]->getNutrients());
        self::assertSame('Something New', $fixture[0]->getWater());
        self::assertSame('Something New', $fixture[0]->getDate_time());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Food();
        $fixture->setCalories('My Title');
        $fixture->setNutrients('My Title');
        $fixture->setWater('My Title');
        $fixture->setDate_time('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/food/');
    }
}
