<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateEvent = null;

    #[ORM\Column(type: 'json')]
    private array $programEvent = [];

    #[ORM\Column(length: 120)]
    private ?string $location = null;

    #[ORM\Column]
    private ?float $ticketPrice = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sport $sport = null;


    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'event')]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeImmutable
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeImmutable $dateEvent): static
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getProgramEvent(): array
    {
        return $this->programEvent;
    }

    public function setProgramEvent(array $programEvent): static
    {
        $this->programEvent = $programEvent;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): static
    {
        $this->sport = $sport;

        return $this;
    }

    public function getTicketPrice(): ?float
    {
        return $this->ticketPrice;
    }

    public function setTicketPrice(float $ticketPrice): static
    {
        $this->ticketPrice = $ticketPrice;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setEvent($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getEvent() === $this) {
                $booking->setEvent(null);
            }
        }

        return $this;
    }

}
