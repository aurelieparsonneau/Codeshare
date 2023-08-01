<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Note;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{   
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // $product = new Product();


        // Création d'un utilisateur ADMIN
        $user = new User();
        $user->setEmail('hello@codeshare.fr')
        ->setUsername('admin')
        ->setPassword('$2y$13$4UbZtgjJ2J0JSmY45CZs4uGbUbckq1R.N64JltRbz7JTVpuo3YJzi') // mdp : admin
        ->setRoles(["ROLE_ADMIN"])
        ;
        
        // Enregistrement de l'utilisateur ADMIN en base de données
        $manager->persist($user);

        // Création d'un utilisateur USER
        $user2 = new User();
        $user2->setEmail('user@codeshare.fr')
        ->setUsername('user')
        ->setPassword('$2y$13$4UbZtgjJ2J0JSmY45CZs4uGbUbckq1R.N64JltRbz7JTVpuo3YJzi') // mdp : admin
        ->setRoles(["ROLE_USER"])
        ;

        // Enregistrement de l'utilisateur USER en base de données
        $manager->persist($user2);



        $noteTest = '
        <h1>Mon premier snippet</h1>
        <p>Voici mon premier snippet créé avec CodeXpress !</p>
        <p>Vous pouvez le modifier ou le supprimer depuis votre espace membre.</p>
        <p>Vous pouvez également le partager avec le lien généré.</p>
        ';

        $randomBoolean = [true, false];

        // Boucle pour créer 200 snippets de test
        for ($i=0; $i < 200; $i++) { 
            $note = new Note();
            $note->setTitle($faker->word(2))
            ->setContent($noteTest)
            ->setUser($user)
            ->setCreatedAt($faker->dateTimeBetween('-7 months'))
            ->setIsPublished($randomBoolean[array_rand($randomBoolean)])
            ->setIsPublic($randomBoolean[array_rand($randomBoolean)])
            ->setIsPro($randomBoolean[array_rand($randomBoolean)])
            ;

            $manager->persist($note);
        }

        // $manager->persist($product);

        $manager->flush();
    }
}
