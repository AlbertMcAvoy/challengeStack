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
            'body[height]' => 'Testing',
            'body[BMI]' => 'Testing',
            'body[date_time]' => 'Testing',
        ]);

        self::assertResponseRedirects('/body/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Body();
        $fixture->setWeight('My Title');
        $fixture->setHeight('My Title');
        $fixture->setBMI('My Title');
        $fixture->setDate_time('My Title');

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
        $fixture->setHeight('My Title');
        $fixture->setBMI('My Title');
        $fixture->setDate_time('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'body[weight]' => 'Something New',
            'body[height]' => 'Something New',
            'body[BMI]' => 'Something New',
            'body[date_time]' => 'Something New',
        ]);

        self::assertResponseRedirects('/body/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getWeight());
        self::assertSame('Something New', $fixture[0]->getHeight());
        self::assertSame('Something New', $fixture[0]->getBMI());
        self::assertSame('Something New', $fixture[0]->getDate_time());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Body();
        $fixture->setWeight('My Title');
        $fixture->setHeight('My Title');
        $fixture->setBMI('My Title');
        $fixture->setDate_time('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/body/');
    }
}
