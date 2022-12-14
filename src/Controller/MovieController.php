<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie', name: 'movie_')]
class MovieController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private MovieRepository $movieRepository)
    {
    }

    #[Route('', name: 'list')]
    public function list(): Response
    {
        $movies = $this->movieRepository->findBy([], ['title' => 'ASC']);

        return $this->render('movie/list.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/{id}', name: 'view', requirements: ["id" => "\d+"])]
    public function view(int $id): Response
    {
        $movie = $this->movieRepository->find($id);
        dd($movie);

        return new Response(sprintf("Film %s", $id));
    }

    #[Route('/create', name: 'create')]
    #[Route('/{id}/edit', name: 'edit', requirements: ["id" => "\d+"])]
    public function form(int $id = null, Request $request): Response
    {
        if($id == NULL) {
            // Create
            $movie = new Movie();
        } else {
            // Edit
            $movie = $this->movieRepository->find($id);
        }

        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($movie);
            $this->em->flush();
            $this->addFlash("success", "Film bien enregistrĂ©");
            return $this->redirectToRoute("movie_list");
        }

        return $this->renderForm("movie/form.html.twig", ["form" => $form]);
    }

    #[Route('/{id}/delete', name: 'delete', requirements: ["id" => "\d+"])]
    public function delete(Movie $movie): Response
    {
       $this->em->remove($movie);
       $this->em->flush();

        return $this->redirectToRoute('movie_list');
    }

    #[Route('/search/{term}', name: 'search')]
    public function search(string $term): Response
    {
        $movies = $this->movieRepository->search($term);

        return $this->render('movie/list.html.twig', [
            'movies' => $movies,
        ]);
    }
}

