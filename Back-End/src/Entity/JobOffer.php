<?php

namespace App\Entity;

use App\Repository\JobOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
#[ORM\Entity(repositoryClass: JobOfferRepository::class)]
#[ApiResource(formats: ['json'])]

class JobOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titlejob = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'jobOffers')]
    private ?Recruiter $Recruiter = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on:"create")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on:"update")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $salary = null;

    #[ORM\Column(length: 255)]
    private ?string $CONTRACT = null;

    #[ORM\OneToMany(mappedBy: 'joboffer', targetEntity: Demande::class)]
    private Collection $demandes;

    #[ORM\Column(length: 255)]
    private ?string $salaryMin = null;

    #[ORM\Column(length: 255)]
    private ?string $SalaryMax = null;

    #[ORM\Column(length: 255)]
    private ?string $State = null;

    #[ORM\Column(length: 255)]
    private ?string $CurrencyPosition = null;

    #[ORM\Column(length: 255)]
    private ?string $Qualifications = null;

    #[ORM\Column(length: 255)]
    private ?string $Country = null;

    #[ORM\Column(length: 255)]
    private ?string $City = null;

    #[ORM\Column(length: 255)]
    private ?string $FullAdress = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $expeience = null;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitlejob(): ?string
    {
        return $this->titlejob;
    }

    public function setTitlejob(string $titlejob): self
    {
        $this->titlejob = $titlejob;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getCONTRACT(): ?string
    {
        return $this->CONTRACT;
    }

    public function setCONTRACT(string $CONTRACT): self
    {
        $this->CONTRACT = $CONTRACT;

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setJoboffer($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getJoboffer() === $this) {
                $demande->setJoboffer(null);
            }
        }

        return $this;
    }

    public function getSalaryMin(): ?string
    {
        return $this->salaryMin;
    }

    public function setSalaryMin(string $salaryMin): self
    {
        $this->salaryMin = $salaryMin;

        return $this;
    }

    public function getSalaryMax(): ?string
    {
        return $this->SalaryMax;
    }

    public function setSalaryMax(string $SalaryMax): self
    {
        $this->SalaryMax = $SalaryMax;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->State;
    }

    public function setState(string $State): self
    {
        $this->State = $State;

        return $this;
    }

    public function getCurrencyPosition(): ?string
    {
        return $this->CurrencyPosition;
    }

    public function setCurrencyPosition(string $CurrencyPosition): self
    {
        $this->CurrencyPosition = $CurrencyPosition;

        return $this;
    }

    public function getQualifications(): ?string
    {
        return $this->Qualifications;
    }

    public function setQualifications(string $Qualifications): self
    {
        $this->Qualifications = $Qualifications;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): self
    {
        $this->Country = $Country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getFullAdress(): ?string
    {
        return $this->FullAdress;
    }

    public function setFullAdress(string $FullAdress): self
    {
        $this->FullAdress = $FullAdress;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getExpeience(): ?int
    {
        return $this->expeience;
    }

    public function setExpeience(int $expeience): self
    {
        $this->expeience = $expeience;

        return $this;
    }

}
