<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie', name: 'movie_')]
class MovieController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(): Response
    {
        return new Response("Liste de films");
    }

    #[Route('/{id}', name: 'view', requirements: ["id" => "\d+"])]
    public function view(int $id): Response
    {
        return new Response(sprintf("Film %s", $id));
    }

    #[Route('/create', name: 'create')]
    #[Route('/{id}/edit', name: 'edit', requirements: ["id" => "\d+"])]
    public function form(int $id = null): Response
    {
        return new Response("Formulaire de film");
    }

    #[Route('/{id}/delete', name: 'delete', requirements: ["id" => "\d+"])]
    public function delete(int $id): Response
    {
        return new Response("Suppression de film");
    }
}
