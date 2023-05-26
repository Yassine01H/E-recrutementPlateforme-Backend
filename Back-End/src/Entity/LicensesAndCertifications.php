<?php

namespace App\Entity;

use App\Repository\LicensesAndCertificationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiResource;
#[ORM\Entity(repositoryClass: LicensesAndCertificationsRepository::class)]
#[ApiResource(formats: ['json'])]
class LicensesAndCertifications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $issuing_body = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_of_issue = null;



    #[ORM\Column(length: 255)]
    private ?string $iddegree = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $degree_url = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on:"create")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on:"update")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'licensesAndCertifications')]
    private ?Candidat $candidat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIssuingBody(): ?string
    {
        return $this->issuing_body;
    }

    public function setIssuingBody(string $issuing_body): self
    {
        $this->issuing_body = $issuing_body;

        return $this;
    }

    public function getDateOfIssue(): ?\DateTimeInterface
    {
        return $this->date_of_issue;
    }

    public function setDateOfIssue(\DateTimeInterface $date_of_issue): self
    {
        $this->date_of_issue = $date_of_issue;

        return $this;
    }



    public function getIddegree(): string
    {
        return $this->iddegree;
    }

    public function setIddegree(string $iddegree): self
    {
        $this->iddegree = $iddegree;

        return $this;
    }

    public function getDegreeUrl(): ?string
    {
        return $this->degree_url;
    }

    public function setDegreeUrl(string $degree_url): self
    {
        $this->degree_url = $degree_url;

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

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }
}
