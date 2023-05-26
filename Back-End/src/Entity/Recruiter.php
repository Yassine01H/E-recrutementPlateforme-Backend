<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RecruiterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Controller\RecruiterController;
#[ORM\Entity(repositoryClass: RecruiterRepository::class)]
#[ApiResource(
    collectionOperations:
     [
        'post' => [
            'controller' => RecruiterController::class,
            'deserialize' => false
        ],
        'get' => [
            '"method"'=>"GET",
            '"path"'=>"/getrecruiters",
            '"controller"' => RecruiterController::class,
        ],
    ],
    normalizationContext: ['groups' => ['read']],

)]
#[Vich\Uploadable]
class Recruiter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[groups('read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $web_site = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $company_name = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $company_adress = null;

    #[ORM\Column]
    #[groups('read')]
    private ?int $phone = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $logo = null;

    #[Vich\UploadableField(mapping: 'upload_image_recruiters', fileNameProperty: 'logo')]
    private ?File $imgProfile = null;

    #[ORM\Column(type: Types::TEXT)]
    #[groups('read')]
    private ?string $company_description = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $activity_area = null;

    #[ORM\Column]
    #[groups('read')]
    #[Gedmo\Timestampable(on:"create")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[groups('read')]
    #[Gedmo\Timestampable(on:"update")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[groups('read')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'Recruiter', targetEntity: Meet::class)]
    private Collection $meets;

    #[ORM\OneToMany(mappedBy: 'Recruiter', targetEntity: Demande::class)]
    private Collection $demandes;

    public function __construct()
    {
        $this->meets = new ArrayCollection();
        $this->demandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }
    
    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getWebSite(): ?string
    {
        return $this->web_site;
    }

    public function setWebSite(string $web_site): self
    {
        $this->web_site = $web_site;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    public function setCompanyName(string $company_name): self
    {
        $this->company_name = $company_name;

        return $this;
    }

    public function getCompanyAdress(): ?string
    {
        return $this->company_adress;
    }

    public function setCompanyAdress(string $company_adress): self
    {
        $this->company_adress = $company_adress;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getCompanyDescription(): ?string
    {
        return $this->company_description;
    }

    public function setCompanyDescription(string $company_description): self
    {
        $this->company_description = $company_description;

        return $this;
    }

    public function getActivityArea(): ?string
    {
        return $this->activity_area;
    }

    public function setActivityArea(string $activity_area): self
    {
        $this->activity_area = $activity_area;

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

    public function getImgProfile(): ?File
    {
        return $this->imgProfile;
    }

    public function setImgProfile(?File $imgProfile): self
    {
        $this->imgProfile = $imgProfile;

        return $this;
    }



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Meet>
     */
    public function getMeets(): Collection
    {
        return $this->meets;
    }

    public function addMeet(Meet $meet): self
    {
        if (!$this->meets->contains($meet)) {
            $this->meets->add($meet);
            $meet->setRecruiter($this);
        }

        return $this;
    }

    public function removeMeet(Meet $meet): self
    {
        if ($this->meets->removeElement($meet)) {
            // set the owning side to null (unless already changed)
            if ($meet->getRecruiter() === $this) {
                $meet->setRecruiter(null);
            }
        }

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
            $demande->setRecruiter($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getRecruiter() === $this) {
                $demande->setRecruiter(null);
            }
        }

        return $this;
    }
}
