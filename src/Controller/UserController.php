<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    // #[Route('/user', name: 'app_user')]
    // public function index(): Response
    // {
    //     return $this->render('user/index.html.twig', [
    //         'controller_name' => 'UserController',
    //     ]);
    // }



    #[Route('/profile/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //mettre à jour et modifier les utilisateur 

            // On récupère l'utilisateur connecté
            $user = $this->getUser();
            $job = $form->get('job')->getData();
            $bio = $form->get('bio')->getData();
            $town = $form->get('town')->getData();
            $country = $form->get('country')->getData();

            $user->setJob($job)
                ->setBio($bio)
                ->setTown($town)
                ->setCountry($country);

            // // On lui donne le rôle ROLE_PREMIUM
            // $user->setEmail(['']);
            // $user->setJob([]);
            // $user->setBio([]);
            // $user->setTown([]);
            // $user->setCountry([]);

            // On enregistre l'utilisateur en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            // 'user' => $user,

            'form' => $form,
        ]);
    }


    #[Route('/profile/delete', name: 'profile_delete')]
    public function profileDelete(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $entityManager->remove($user);
        $entityManager->flush();
    }










}
