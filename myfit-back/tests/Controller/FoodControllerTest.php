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
            'food[libelle]' => 'Testing',
            'food[calories]' => 'Testing',
            'food[energy]' => 'Testing',
            'food[water]' => 'Testing',
            'food[protein]' => 'Testing',
            'food[glucid]' => 'Testing',
            'food[lipid]' => 'Testing',
            'food[sugar]' => 'Testing',
            'food[ag_sature]' => 'Testing',
            'food[cholesterol]' => 'Testing',
            'food[calcium]' => 'Testing',
            'food[fer]' => 'Testing',
            'food[magnesium]' => 'Testing',
            'food[sodium]' => 'Testing',
            'food[group_id]' => 'Testing',
            'food[sub_group_id]' => 'Testing',
            'food[sub_sub_group_id]' => 'Testing',
            'food[meal]' => 'Testing',
        ]);

        self::assertResponseRedirects('/food/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Food();
        $fixture->setLibelle('My Title');
        $fixture->setCalories('My Title');
        $fixture->setEnergy('My Title');
        $fixture->setWater('My Title');
        $fixture->setProtein('My Title');
        $fixture->setGlucid('My Title');
        $fixture->setLipid('My Title');
        $fixture->setSugar('My Title');
        $fixture->setAg_sature('My Title');
        $fixture->setCholesterol('My Title');
        $fixture->setCalcium('My Title');
        $fixture->setFer('My Title');
        $fixture->setMagnesium('My Title');
        $fixture->setSodium('My Title');
        $fixture->setGroup_id('My Title');
        $fixture->setSub_group_id('My Title');
        $fixture->setSub_sub_group_id('My Title');
        $fixture->setMeal('My Title');

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
        $fixture->setLibelle('My Title');
        $fixture->setCalories('My Title');
        $fixture->setEnergy('My Title');
        $fixture->setWater('My Title');
        $fixture->setProtein('My Title');
        $fixture->setGlucid('My Title');
        $fixture->setLipid('My Title');
        $fixture->setSugar('My Title');
        $fixture->setAg_sature('My Title');
        $fixture->setCholesterol('My Title');
        $fixture->setCalcium('My Title');
        $fixture->setFer('My Title');
        $fixture->setMagnesium('My Title');
        $fixture->setSodium('My Title');
        $fixture->setGroup_id('My Title');
        $fixture->setSub_group_id('My Title');
        $fixture->setSub_sub_group_id('My Title');
        $fixture->setMeal('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'food[libelle]' => 'Something New',
            'food[calories]' => 'Something New',
            'food[energy]' => 'Something New',
            'food[water]' => 'Something New',
            'food[protein]' => 'Something New',
            'food[glucid]' => 'Something New',
            'food[lipid]' => 'Something New',
            'food[sugar]' => 'Something New',
            'food[ag_sature]' => 'Something New',
            'food[cholesterol]' => 'Something New',
            'food[calcium]' => 'Something New',
            'food[fer]' => 'Something New',
            'food[magnesium]' => 'Something New',
            'food[sodium]' => 'Something New',
            'food[group_id]' => 'Something New',
            'food[sub_group_id]' => 'Something New',
            'food[sub_sub_group_id]' => 'Something New',
            'food[meal]' => 'Something New',
        ]);

        self::assertResponseRedirects('/food/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLibelle());
        self::assertSame('Something New', $fixture[0]->getCalories());
        self::assertSame('Something New', $fixture[0]->getEnergy());
        self::assertSame('Something New', $fixture[0]->getWater());
        self::assertSame('Something New', $fixture[0]->getProtein());
        self::assertSame('Something New', $fixture[0]->getGlucid());
        self::assertSame('Something New', $fixture[0]->getLipid());
        self::assertSame('Something New', $fixture[0]->getSugar());
        self::assertSame('Something New', $fixture[0]->getAg_sature());
        self::assertSame('Something New', $fixture[0]->getCholesterol());
        self::assertSame('Something New', $fixture[0]->getCalcium());
        self::assertSame('Something New', $fixture[0]->getFer());
        self::assertSame('Something New', $fixture[0]->getMagnesium());
        self::assertSame('Something New', $fixture[0]->getSodium());
        self::assertSame('Something New', $fixture[0]->getGroup_id());
        self::assertSame('Something New', $fixture[0]->getSub_group_id());
        self::assertSame('Something New', $fixture[0]->getSub_sub_group_id());
        self::assertSame('Something New', $fixture[0]->getMeal());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Food();
        $fixture->setLibelle('My Title');
        $fixture->setCalories('My Title');
        $fixture->setEnergy('My Title');
        $fixture->setWater('My Title');
        $fixture->setProtein('My Title');
        $fixture->setGlucid('My Title');
        $fixture->setLipid('My Title');
        $fixture->setSugar('My Title');
        $fixture->setAg_sature('My Title');
        $fixture->setCholesterol('My Title');
        $fixture->setCalcium('My Title');
        $fixture->setFer('My Title');
        $fixture->setMagnesium('My Title');
        $fixture->setSodium('My Title');
        $fixture->setGroup_id('My Title');
        $fixture->setSub_group_id('My Title');
        $fixture->setSub_sub_group_id('My Title');
        $fixture->setMeal('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/food/');
    }
}
