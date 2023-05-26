<?php

namespace App\Entity;

use App\Repository\MeetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
#[ORM\Entity(repositoryClass: MeetRepository::class)]
#[ApiResource(formats: ['json'])]
class Meet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $urlMeet = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'meets')]
    private ?Candidat $candidat = null;

    #[ORM\ManyToOne(inversedBy: 'meets')]
    private ?Recruiter $Recruiter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlMeet(): ?string
    {
        return $this->urlMeet;
    }

    public function setUrlMeet(string $urlMeet): self
    {
        $this->urlMeet = $urlMeet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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
