<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepo): Response
    {
        return $this->render('home/index.html.twig', [
            'shows' => $movieRepo->findAll(),
        ]);
    }

    #[Route('/create', name: 'app_create', methods: ["GET", "POST"])]
    public function create(MovieRepository $movieRepo,Request $request): JsonResponse
    {
        try {
            $content = json_decode($request->getContent(), true);
            $movie = (new Movie())
                ->setName($content['name'])
                ->setSynopsis($content['synopsis'])
                ->setType($content['type'])
                ->setCreationDate(new \DateTimeImmutable('now'));

            $movieRepo->save($movie, true);
            return $this->json('Your show has been successfully added.', 201);
        } catch ( \Exception $exception) {
            return $this->json('An error occured while creating a show', 400);
        }
    }

    #[Route('/get-all', name: 'app_get_all', methods: ["GET"])]
    public function getAll(MovieRepository $movieRepo): Response
    {
        return $this->json($movieRepo->findAll(), 200);
    }

    #[Route('/get/{id}', name: 'app_get', methods: ["GET"])]
    public function get(MovieRepository $movieRepo, int $id): Response
    {
        return $this->json($movieRepo->find($id), 200);
    }
}
