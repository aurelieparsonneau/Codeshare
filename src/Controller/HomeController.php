<?php

namespace App\Controller;

use App\Repository\NoteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        NoteRepository $notes,
        PaginatorInterface $paginator, // Chargement de PaginatorInterface
        Request $request // Chargement de Request
    ): Response
    {
        $query = $notes->findBy(
            ['isPublished' => true, 'isPublic' => true], // Pour sélectionner les snippets publics et publiés
            ['createdAt' => 'DESC'], // Pour trier
            100 // Pour limiter l'affichage
        );

        // On utilise le paginator pour paginer les snippets
        $pagination = $paginator->paginate(
            $query, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            9 // Nombre de résultats par page
        );


        return $this->render('home/index.html.twig', [
            'notes' => $pagination
        ]);
    }


}


