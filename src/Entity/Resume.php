<?php
// резюме
namespace App\Entity;

use App\Repository\ResumeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ResumeRepository::class)]
class Resume
{
    public const STATUSES = [
        'Новый',
        'Назначено собеседование',
        'Принят',
        'Отказ'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: Resume::STATUSES, message: 'Выберите валидный статус')]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private ?string $profession = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'Ваш город должно быть хотя бы {{ limit }} символов в длину',
        maxMessage: 'Ваш город не может быть больше {{ limit }} символов в длину',
    )]
    private ?string $city = null;

    #[ORM\Column(length: 800)]
    #[Assert\NotBlank]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'Ваше ФИО должно быть хотя бы {{ limit }} символов в длину',
        maxMessage: 'Ваше ФИО не может быть больше {{ limit }} символов в длину',
    )]
    private ?string $FIO = null;

    #[ORM\Column(length: 11)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 6,
        max: 11,
        minMessage: 'Ваш телефон должен быть хотя бы {{ limit }} символов в длину',
        maxMessage: 'Ваш телефон не может быть больше {{ limit }} символов в длину',
    )]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Ваш email не может быть больше {{ limit }} символов в длину',
    )]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\LessThan('-16 years')]
    private ?\DateTimeInterface $BD = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\GreaterThan(16)]
    #[Assert\LessThan(65)]
    private ?int $age = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\GreaterThan(16242)]
    private ?int $salary = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 500,
        maxMessage: 'Ваши навыки не могут быть больше {{ limit }} символов в длину',
    )]
    private ?string $skills = null;

    #[ORM\Column(length: 1000, nullable: true)]
    #[Assert\Length(
        max: 1000,
        maxMessage: 'Ваше описание не может быть больше {{ limit }} символов в длину',
    )]
    private ?string $about = null;

    #[ORM\OneToMany(mappedBy: 'resume', targetEntity: Education::class, cascade:["persist"])]
    private Collection $educations;

    public function __construct(?string $status, ?string $profession, ?string $city, ?string $photo, ?string $FIO, ?string $phone, ?string $email, ?\DateTimeInterface $BD, ?int $salary, ?string $skills, ?string $about)
    {
        $this->educations = new ArrayCollection();
        $this->status = $status;
        $this->profession = $profession;
        $this->city = $city;
        $this->photo = $photo;
        $this->FIO = $FIO;
        $this->phone = $phone;
        $this->email = $email;
        $this->BD = $BD;
        $this->salary = $salary;
        $this->skills = $skills;
        $this->about = $about;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getFIO(): ?string
    {
        return $this->FIO;
    }

    public function setFIO(string $FIO): self
    {
        $this->FIO = $FIO;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    public function getBD(): ?\DateTimeInterface
    {
        return $this->BD;
    }

    public function setBD(\DateTimeInterface $BD): self
    {
        $this->BD = $BD;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(string $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return Collection<int, Education>
     */
    public function getEducations(): Collection
    {
        return $this->educations;
    }

    public function addEducation(Education $education): self
    {
        if (!$this->educations->contains($education)) {
            $this->educations->add($education);
            $education->setResume($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): self
    {
        if ($this->educations->removeElement($education)) {
            // set the owning side to null (unless already changed)
            if ($education->getResume() === $this) {
                $education->setResume(null);
            }
        }

        return $this;
    }
}
