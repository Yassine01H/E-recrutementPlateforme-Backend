<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CvController;
use App\Repository\CvRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: CvRepository::class)]
#[ApiResource(
    collectionOperations:
     [
        'post' => [
            'controller' => CvController::class,
            'deserialize' => false
        ],
        'get' => [
            '"method"'=>"GET",
            '"path"'=>"/getcvs",
            '"controller"' => CvController::class,
        ],
    ],
    normalizationContext: ['groups' => ['read']],

)]
#[Vich\Uploadable]
class Cv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[groups('read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $title_cv = null;

    #[ORM\Column(length: 255)]
    #[groups('read')]
    private ?string $img_cv = null;

    #[Vich\UploadableField(mapping: 'upload_cv_candidats', fileNameProperty: 'img_cv')]
    private ?File $cv = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on:"create")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on:"update")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'cvs')]
    private ?Candidat $candidat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleCv(): ?string
    {
        return $this->title_cv;
    }

    public function setTitleCv(string $title_cv): self
    {
        $this->title_cv = $title_cv;

        return $this;
    }

    public function getImgCv(): ?string
    {
        return $this->img_cv;
    }

    public function setImgCv(string $img_cv): self
    {
        $this->img_cv = $img_cv;

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

    public function getCv(): ?File
    {
        return $this->cv;
    }

    public function setCv(?File $cv): self
    {
        $this->cv = $cv;

        return $this;
    }
}
