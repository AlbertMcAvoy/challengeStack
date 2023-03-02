<?php

namespace App\Test\Controller;

use App\Entity\Body;
use App\Repository\BodyRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BodyControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private BodyRepository $repository;
    private string $path = '/body/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Body::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Body index');

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
            'body[weight]' => 'Testing',
            'body[date_time]' => 'Testing',
            'body[objectif_weight]' => 'Testing',
            'body[user]' => 'Testing',
        ]);

        self::assertResponseRedirects('/body/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Body();
        $fixture->setWeight('My Title');
        $fixture->setDate_time('My Title');
        $fixture->setObjectif_weight('My Title');
        $fixture->setUser('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Body');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Body();
        $fixture->setWeight('My Title');
        $fixture->setDate_time('My Title');
        $fixture->setObjectif_weight('My Title');
        $fixture->setUser('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'body[weight]' => 'Something New',
            'body[date_time]' => 'Something New',
            'body[objectif_weight]' => 'Something New',
            'body[user]' => 'Something New',
        ]);

        self::assertResponseRedirects('/body/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getWeight());
        self::assertSame('Something New', $fixture[0]->getDate_time());
        self::assertSame('Something New', $fixture[0]->getObjectif_weight());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Body();
        $fixture->setWeight('My Title');
        $fixture->setDate_time('My Title');
        $fixture->setObjectif_weight('My Title');
        $fixture->setUser('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/body/');
    }
}
