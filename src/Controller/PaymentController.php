<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
        #[Route('/payment', name: 'app_payment')]
        public function index(): Response
        {
                Stripe::setApiKey($_ENV["STRIPE_SECRET"]);

                $session = Session::create([
                        'payment_method_types' => ['card'],
                        'line_items' => [[
                                'price_data' => [
                                        'currency' => 'eur',
                                        'unit_amount' => 890,
                                        'product_data' => [
                                                'name' => 'Abonnement Premium',
                                                'images' => ['https://raw.githubusercontent.com/aurelieparsonneau/Codeshare/main/public/img/codeshare.png'],

                                        ],
                                ],
                                'quantity' => 1,
                        ]],
                        'mode' => 'payment',
                        'success_url' => $this->generateUrl('app_payment_success', [], 0),
                        'cancel_url' => $this->generateUrl('app_payment_cancel', [], 0),
                ]);

                return $this->redirect($session->url, 303);
        }

        #[Route('/payment/success', name: 'app_payment_success')]
        public function success(EntityManagerInterface $em): Response
        {
                $user = $this->getUser();
                $user->setRoles(["ROLE_PREMIUM"]);

                $em->persist($user);
                $em->flush();

                $this->addFlash('message', 'La paiement a bien été effectué. Vous êtes désormais Premium !');

                return $this->redirectToRoute('app_page');
        }

        #[Route('/payment/cancel', name: 'app_payment_cancel')]
        public function cancel(): Response
        {
                $this->addFlash('message', 'Le paiement a n\' pas abouti. Réessayez.');

                return $this->redirectToRoute('app_page');
        }
}
