<?php

namespace App\Service;

use App\Repository\FoodRepository;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class foodCache
{
    private $cache;
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }
    public function get(FoodRepository $foodRepository, $libelle)
    {
        $foods =  $this->cache->get('all_aliment', function (ItemInterface $item) use ($foodRepository, $libelle) {
            $data = $foodRepository->findAll();
            $item->set($data);
            return $data;
        });
        return $foods;
    }
}
