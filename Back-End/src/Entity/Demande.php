<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
#[ApiResource(formats: ['json'])]
#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $statut = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    private ?JobOffer $joboffer = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    private ?Candidat $candidat = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on:"create")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on:"update")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $Full_name = null;

    #[ORM\Column(length: 255)]
    private ?string $Email_address = null;

    #[ORM\Column(length: 255)]
    private ?string $Message = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    private ?Recruiter $Recruiter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getJoboffer(): ?JobOffer
    {
        return $this->joboffer;
    }

    public function setJoboffer(?JobOffer $joboffer): self
    {
        $this->joboffer = $joboffer;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->Full_name;
    }

    public function setFullName(string $Full_name): self
    {
        $this->Full_name = $Full_name;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->Email_address;
    }

    public function setEmailAddress(string $Email_address): self
    {
        $this->Email_address = $Email_address;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): self
    {
        $this->Message = $Message;

        return $this;
    }

    public function getRecruiter(): ?Recruiter
    {
        return $this->Recruiter;
    }

    public function setRecruiter(?Recruiter $Recruiter): self
    {
        $this->Recruiter = $Recruiter;

        return $this;
    }
}
