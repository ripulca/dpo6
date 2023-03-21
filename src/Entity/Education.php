<?php
//образование
namespace App\Entity;

use App\Repository\EducationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: EducationRepository::class)]
class Education
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    // #[Assert\NotBlank]
    // #[Assert\Length(max:255,
    //     maxMessage: 'Ваш уровень не может быть больше {{ limit }} символов в длину',)]
    private ?string $level = null;

    #[ORM\Column(length: 255, nullable: true)]
    // #[Assert\Length(max:255,
    //     maxMessage: 'Ваш институт не может быть больше {{ limit }} символов в длину',)]
    private ?string $institution = null;

    #[ORM\Column(length: 255, nullable: true)]
    // #[Assert\Length(max:255,
    //     maxMessage: 'Ваш факультет не может быть больше {{ limit }} символов в длину',)]
    private ?string $faculty = null;

    #[ORM\Column(length: 255, nullable: true)]
    // #[Assert\Length(max:255,
    //     maxMessage: 'Ваша специальность не может быть больше {{ limit }} символов в длину',)]
    private ?string $specialization = null;

    #[ORM\Column(nullable: true)]
    #[Assert\LessThan(2023)]
    #[Assert\GreaterThan(1970)]
    private ?int $gard_year = null;

    #[ORM\ManyToOne(inversedBy: 'educations', cascade:["persist"])]
    #[Ignore]
    private ?Resume $resume = null;

    // public function __construct(?string $level, ?string $institution=null, ?string $faculty=null, ?string $specialization=null, ?int $gard_year=null){
    //     $this->level = $level;
    //     $this->institution = $institution;
    //     $this->faculty = $faculty;
    //     $this->specialization = $specialization;
    //     $this->gard_year = $gard_year;
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getInstitution(): ?string
    {
        return $this->institution;
    }

    public function setInstitution(?string $institution): self
    {
        $this->institution = $institution;

        return $this;
    }

    public function getFaculty(): ?string
    {
        return $this->faculty;
    }

    public function setFaculty(?string $faculty): self
    {
        $this->faculty = $faculty;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(?string $specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getGardYear(): ?int
    {
        return $this->gard_year;
    }

    public function setGardYear(?int $gard_year): self
    {
        $this->gard_year = $gard_year;

        return $this;
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(?Resume $resume): self
    {
        $this->resume = $resume;

        return $this;
    }
}
