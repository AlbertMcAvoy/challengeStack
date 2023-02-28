<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodRepository::class)]
class Food
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    private ?int $calories = null;

    #[ORM\Column(nullable: true)]
    private ?int $energy = null;

    #[ORM\Column(nullable: true)]
    private ?int $water = null;

    #[ORM\Column(nullable: true)]
    private ?int $protein = null;

    #[ORM\Column(nullable: true)]
    private ?int $glucid = null;

    #[ORM\Column(nullable: true)]
    private ?int $lipid = null;

    #[ORM\Column(nullable: true)]
    private ?int $sugar = null;

    #[ORM\Column(nullable: true)]
    private ?int $ag_sature = null;

    #[ORM\Column(nullable: true)]
    private ?int $cholesterol = null;

    #[ORM\Column(nullable: true)]
    private ?int $calcium = null;

    #[ORM\Column(nullable: true)]
    private ?int $fer = null;

    #[ORM\Column(nullable: true)]
    private ?int $magnesium = null;

    #[ORM\Column(nullable: true)]
    private ?int $sodium = null;

    #[ORM\ManyToOne(inversedBy: 'food')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FoodGroup $group_id = null;

    #[ORM\ManyToOne(inversedBy: 'food')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FoodSubGroup $sub_group_id = null;

    #[ORM\ManyToOne(inversedBy: 'food')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FoodSubSubGroup $sub_sub_group_id = null;

    #[ORM\ManyToMany(targetEntity: Meal::class, inversedBy: 'food')]
    private Collection $meal;

    public function __construct()
    {
        $this->meal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(?int $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getEnergy(): ?int
    {
        return $this->energy;
    }

    public function setEnergy(?int $energy): self
    {
        $this->energy = $energy;

        return $this;
    }

    public function getWater(): ?int
    {
        return $this->water;
    }

    public function setWater(?int $water): self
    {
        $this->water = $water;

        return $this;
    }

    public function getProtein(): ?int
    {
        return $this->protein;
    }

    public function setProtein(?int $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getGlucid(): ?int
    {
        return $this->glucid;
    }

    public function setGlucid(?int $glucid): self
    {
        $this->glucid = $glucid;

        return $this;
    }

    public function getLipid(): ?int
    {
        return $this->lipid;
    }

    public function setLipid(?int $lipid): self
    {
        $this->lipid = $lipid;

        return $this;
    }

    public function getSugar(): ?int
    {
        return $this->sugar;
    }

    public function setSugar(?int $sugar): self
    {
        $this->sugar = $sugar;

        return $this;
    }

    public function getAgSature(): ?int
    {
        return $this->ag_sature;
    }

    public function setAgSature(?int $ag_sature): self
    {
        $this->ag_sature = $ag_sature;

        return $this;
    }

    public function getCholesterol(): ?int
    {
        return $this->cholesterol;
    }

    public function setCholesterol(?int $cholesterol): self
    {
        $this->cholesterol = $cholesterol;

        return $this;
    }

    public function getCalcium(): ?int
    {
        return $this->calcium;
    }

    public function setCalcium(?int $calcium): self
    {
        $this->calcium = $calcium;

        return $this;
    }

    public function getFer(): ?int
    {
        return $this->fer;
    }

    public function setFer(?int $fer): self
    {
        $this->fer = $fer;

        return $this;
    }

    public function getMagnesium(): ?int
    {
        return $this->magnesium;
    }

    public function setMagnesium(?int $magnesium): self
    {
        $this->magnesium = $magnesium;

        return $this;
    }

    public function getSodium(): ?int
    {
        return $this->sodium;
    }

    public function setSodium(?int $sodium): self
    {
        $this->sodium = $sodium;

        return $this;
    }

    public function getGroupId(): ?FoodGroup
    {
        return $this->group_id;
    }

    public function setGroupId(?FoodGroup $group_id): self
    {
        $this->group_id = $group_id;

        return $this;
    }

    public function getSubGroupId(): ?FoodSubGroup
    {
        return $this->sub_group_id;
    }

    public function setSubGroupId(?FoodSubGroup $sub_group_id): self
    {
        $this->sub_group_id = $sub_group_id;

        return $this;
    }

    public function getSubSubGroupId(): ?FoodSubSubGroup
    {
        return $this->sub_sub_group_id;
    }

    public function setSubSubGroupId(?FoodSubSubGroup $sub_sub_group_id): self
    {
        $this->sub_sub_group_id = $sub_sub_group_id;

        return $this;
    }

    /**
     * @return Collection<int, Meal>
     */
    public function getMeal(): Collection
    {
        return $this->meal;
    }

    public function addMeal(Meal $meal): self
    {
        if (!$this->meal->contains($meal)) {
            $this->meal->add($meal);
        }

        return $this;
    }

    public function removeMeal(Meal $meal): self
    {
        $this->meal->removeElement($meal);

        return $this;
    }
}
