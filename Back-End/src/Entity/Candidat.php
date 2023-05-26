<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CandidatController;
use App\Repository\CandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;


#[ORM\Entity(repositoryClass: CandidatRepository::class)]
#[ApiResource(
    collectionOperations:
     [
        'post' => [
            'controller' => CandidatController::class,
            'deserialize' => false
        ],
        'get' => [
            '"method"'=>"GET",
            '"path"'=>"/getcandidats",
            '"controller"' => CandidatController::class,
        ],
    ],
    normalizationContext: ['groups' => ['read']],

)]
#[Vich\Uploadable]

class Candidat
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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[groups('read')]
    private ?\DateTimeInterface $date_of_birth = null;

    #[ORM\Column]
    #[groups('read')]
    private ?int $phone = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $job = null;
    


    #[ORM\Column]
    #[Gedmo\Timestampable(on:"create")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on:"update")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'candidat', targetEntity: Demande::class)]
    private Collection $demandes;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $profileTitle = null;


    #[ORM\Column(length: 255, nullable: true)]
    #[groups('read')]
    private ?string $imgProfilePath = null;

    #[Vich\UploadableField(mapping: 'upload_image_candidats', fileNameProperty: 'imgProfilePath')]
    private ?File $imgProfile = null;


    #[ORM\OneToMany(mappedBy: 'candidat', targetEntity: Cv::class)]
    private Collection $cvs;

    #[ORM\OneToMany(mappedBy: 'candidat', targetEntity: Language::class)]
    private Collection $languages;

    #[ORM\OneToMany(mappedBy: 'candidat', targetEntity: LicensesAndCertifications::class)]
    private Collection $licensesAndCertifications;

    #[ORM\OneToMany(mappedBy: 'candidat', targetEntity: Training::class)]
    private Collection $trainings;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[groups('read')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'candidat', targetEntity: Meet::class)]
    private Collection $meets;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->cvs = new ArrayCollection();
        $this->languages = new ArrayCollection();
        $this->licensesAndCertifications = new ArrayCollection();
        $this->trainings = new ArrayCollection();
        $this->meets = new ArrayCollection();
        
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

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(\DateTimeInterface $date_of_birth): self
    {
        $this->date_of_birth = $date_of_birth;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): self
    {
        $this->job = $job;

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
            $demande->setCandidat($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getCandidat() === $this) {
                $demande->setCandidat(null);
            }
        }

        return $this;
    }

    public function getProfileTitle(): ?string
    {
        return $this->profileTitle;
    }

    public function setProfileTitle(string $profileTitle): self
    {
        $this->profileTitle = $profileTitle;

        return $this;
    }

    /**
     * @return Collection<int, Cv>
     */
    public function getCvs(): Collection
    {
        return $this->cvs;
    }

    public function addCv(Cv $cv): self
    {
        if (!$this->cvs->contains($cv)) {
            $this->cvs->add($cv);
            $cv->setCandidat($this);
        }

        return $this;
    }

    public function removeCv(Cv $cv): self
    {
        if ($this->cvs->removeElement($cv)) {
            // set the owning side to null (unless already changed)
            if ($cv->getCandidat() === $this) {
                $cv->setCandidat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);
            $language->setCandidat($this);
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        if ($this->languages->removeElement($language)) {
            // set the owning side to null (unless already changed)
            if ($language->getCandidat() === $this) {
                $language->setCandidat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LicensesAndCertifications>
     */
    public function getLicensesAndCertifications(): Collection
    {
        return $this->licensesAndCertifications;
    }

    public function addLicensesAndCertification(LicensesAndCertifications $licensesAndCertification): self
    {
        if (!$this->licensesAndCertifications->contains($licensesAndCertification)) {
            $this->licensesAndCertifications->add($licensesAndCertification);
            $licensesAndCertification->setCandidat($this);
        }

        return $this;
    }

    public function removeLicensesAndCertification(LicensesAndCertifications $licensesAndCertification): self
    {
        if ($this->licensesAndCertifications->removeElement($licensesAndCertification)) {
            // set the owning side to null (unless already changed)
            if ($licensesAndCertification->getCandidat() === $this) {
                $licensesAndCertification->setCandidat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Training>
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings->add($training);
            $training->setCandidat($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getCandidat() === $this) {
                $training->setCandidat(null);
            }
        }

        return $this;
    }

    public function getImgProfilePath(): ?string
    {
        return $this->imgProfilePath;
    }

    public function setImgProfilePath(?string $imgProfilePath): self
    {
        $this->imgProfilePath = $imgProfilePath;

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
            $meet->setCandidat($this);
        }

        return $this;
    }

    public function removeMeet(Meet $meet): self
    {
        if ($this->meets->removeElement($meet)) {
            // set the owning side to null (unless already changed)
            if ($meet->getCandidat() === $this) {
                $meet->setCandidat(null);
            }
        }

        return $this;
    }












}
