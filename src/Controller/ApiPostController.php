<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository)
    {
        return $this->json($postRepository->findAll(), 200, [], ['groups' => 'post:read']);
    }

    /**
     * @Route("/api/post", name="api_post_index", methods={"POST"})
     */
    public function store(
        Request $request,
        SerializerInterface $serializerInterface,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validatorInterface
    ) {
        $json = $request->getContent();

        try {
            $post = $serializerInterface->deserialize($json, Post::class, "json");

            $post->setCreatedAt(new \DateTime());

            $errors = $validatorInterface->validate($post);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->json($post, 201, [], ['groups' => 'post:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
