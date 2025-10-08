<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PriceOfferRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['numberPerson'], message: 'Offre déjà existante pour ce nombre de participants')] 
#[ORM\Entity(repositoryClass: PriceOfferRepository::class)]
class PriceOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $numberPerson = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $rateDiscount = null;

    
    public function __construct()
    {
    
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getNumberPerson(): ?int
    {
        return $this->numberPerson;
    }

    public function setNumberPerson(int $numberPerson): static
    {
        $this->numberPerson = $numberPerson;

        return $this;
    }

    public function getRateDiscount(): ?int
    {
        return $this->rateDiscount;
    }

    public function setRateDiscount(int $rateDiscount): static
    {
        $this->rateDiscount = $rateDiscount;

        return $this;
    }

}
