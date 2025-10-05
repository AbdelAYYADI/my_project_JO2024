<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $bookDate = null;

    #[ORM\Column]
    private ?float $grossPrice = null;

    #[ORM\Column]
    private ?float $netPrice = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $rateDiscount = null;

    #[ORM\Column]
    #[Assert\Expression(
        "this.getNetTotal() == this.getNetPrice() * this.getNbrPerson()",
        message: "Le Net Total doit être égal au prix net unitaire multiplié par le nombre de personnes."
    )]
    private ?float $netTotal = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\GreaterThan(
        value: 0,
        )
    ]
    private ?int $nbrPerson = null;

    #[Assert\NotBlank(message: 'Veuillez saisir le nom complet')]
    #[Assert\NotNull()]
    #[ORM\Column(length: 255)]
    private ?string $fulllName = null;

    #[ORM\Column]
    private ?bool $isConfirmed = null;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $bookingKey = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $personList = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Payment $payment = null;


    public function __construct()
    {
        $this->bookingKey = Uuid::V7();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookDate(): ?\DateTimeImmutable
    {
        return $this->bookDate;
    }

    public function setBookDate(\DateTimeImmutable $bookDate): static
    {
        $this->bookDate = $bookDate;

        return $this;
    }

    public function getGrossPrice(): ?float
    {
        return $this->grossPrice;
    }

    public function setGrossPrice(float $grossPrice): static
    {
        $this->grossPrice = $grossPrice;

        return $this;
    }

    public function getNetPrice(): ?float
    {
        return $this->netPrice;
    }

    public function setNetPrice(float $netPrice): static
    {
        $this->netPrice = $netPrice;

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

    public function getNbrPerson(): ?int
    {
        return $this->nbrPerson;
    }

    public function setNbrPerson(int $nbrPerson): static
    {
        $this->nbrPerson = $nbrPerson;

        return $this;
    }


    public function isConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): static
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    public function getNetTotal(): ?float
    {
        return $this->netTotal;
    }

    public function setNetTotal(float $netTotal): static
    {
        $this->netTotal = $netTotal;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fulllName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fulllName = $fullName;

        return $this;
    }

    public function getBookingKey(): ?Uuid
    {
        return $this->bookingKey;
    }

    public function setBookingKey(Uuid $bookingKey): static
    {
        $this->bookingKey = $bookingKey;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPersonList(): ?array
    {
        return $this->personList;
    }

    public function setPersonList(?array $personList): static
    {
        $this->personList = $personList;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): static
    {
        $this->payment = $payment;

        return $this;
    }

}
