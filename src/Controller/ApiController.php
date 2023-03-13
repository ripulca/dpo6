<?php

namespace App\Controller;

use App\Entity\Education;
use App\Entity\Resume;
use App\Repository\EducationRepository;
use App\Repository\ResumeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/cv', priority: 10000, format: 'json')]
class ApiController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    private ResumeRepository $resumeRepository;
    private EducationRepository $educationRepository;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->resumeRepository = $entityManager->getRepository(Resume::class);
        $this->educationRepository = $entityManager->getRepository(Education::class);
    }


    #[Route('/', name: 'get_all_resume')]
    public function index(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize(
                $this->resumeRepository->findAll(),
                'json'
            ),
            json: true
        );
    }

    #[Route('/add', name: 'add_resume')]
    public function add(Request $request): JsonResponse
    {
        /** @var Resume $resume */
        $resume = $this->serializer->deserialize(
            $request->getContent(),
            Resume::class,
            'json',
            [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['id', ['educations' => 'id']],
            ]
        );

        $errors = $this->validator->validate($resume);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new JsonResponse(['error' => $errorsString, 'resume' => $resume], Response::HTTP_BAD_REQUEST);
        }

        return $this->save($resume);
    }

    #[Route('/{id}', name: 'get_resume_by_id')]
    public function get($id): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize(
                $this->resumeRepository->findOneBy(['id' => $id]),
                'json'
            ),
            json: true
        );
    }

    #[Route('/{id}/edit', name: 'edit_resume')]
    public function edit($id, Request $request): JsonResponse
    {
        $resume = $this->resumeRepository->findOneBy(['id' => $id]);
        if ($resume === null) {
            return new JsonResponse(['error' => 
                'Cannot find resume with id=' . $id], Response::HTTP_BAD_REQUEST);
        }

        /** @var Resume $newResume */
        $newResume = $this->serializer->deserialize(
            $request->getContent(),
            Resume::class,
            'json',
        );

        $errors = $this->validator->validate($newResume);
        if (count($errors) > 0) {
            $errors = (string)$errors;

            return new JsonResponse(['error' => (string)$errors], Response::HTTP_BAD_REQUEST);
        }
        $resume->setAbout($newResume->getAbout());
        $resume->setStatus($newResume->getStatus());
        $resume->setProfession($newResume->getProfession());
        $resume->setCity($newResume->getCity());
        $resume->setPhoto($newResume->getPhoto());
        $resume->setFIO($newResume->getFIO());
        $resume->setPhone($newResume->getPhone());
        $resume->setEmail($newResume->getEmail());
        $resume->setBD($newResume->getBD());
        $resume->setAge($newResume->getAge());
        $resume->setSalary($newResume->getSalary());
        $resume->setSkills($newResume->getSkills());
        $educations=$newResume->geteducations();
        foreach ($educations as $education){
            $resume->addEducation($education);
        }
        try {
        $this->entityManager->persist($resume);
        $this->entityManager->flush();
            // $this->resumeRepository->update($resume, $newResume, true);
            // $this->resumeRepository->save($resume);
            return new JsonResponse('{"status": "ok"}', json: true);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    #[Route('/{id}/status/update', name: 'update_status_resume')]
    public function updateStatus($id, Request $request, DecoderInterface $decoder): JsonResponse
    {
        $resume = $this->resumeRepository->findOneBy(['id' => $id]);

        $status = $decoder->decode(
            $request->getContent(),
            'json',
        )['status'];

        $resume->setStatus($status);

        $errors = $this->validator->validate($resume, groups: ['status']);
        if (count($errors) > 0) {
            $errors = (string)$errors;

            return new JsonResponse(['error' => (string)$errors], Response::HTTP_BAD_REQUEST);
        }

        return $this->save($resume);
    }

    private function save(Resume $resume): JsonResponse
    {
        try {
            $this->resumeRepository->save($resume, true);
            // foreach ($resume->getEducations() as $education) {
            //     $this->educationRepository->save($education, true);
            // }
            return new JsonResponse('{"status": "ok"}', json: true);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
