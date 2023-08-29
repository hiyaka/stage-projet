<?php

namespace App\DataFixtures;

use App\Entity\Batiments;
use App\Entity\Salles;
use Faker\Factory;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $passwordHasher;
    // protected $userRepository;
    // protected $categoryRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository, CategoryRepository $categoryRepository)
    {
        $this->passwordHasher = $passwordHasher;
        // $this->userRepository = $userRepository;
        // $this->categoryRepository = $categoryRepository;
    }
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');


        ///création de batiments et de salles
        for ($b = 0; $b < 5; $b++) {
            $batiment = new Batiments;
            $batiment->setName(strtoupper($faker->randomLetter()));
            $manager->persist($batiment);


            for ($s = 0; $s < mt_rand(10, 15); $s++) {
                $salle = new Salles;
                $salle->setName($faker->randomNumber())
                    ->setBatiments($batiment);


                $manager->persist($salle);
            }
        }

        /// création de demandes à compléter plus tard
        // for ($d = 0; $d < mt_rand(5, 10); $d++) {
        //     $demandes = new Demandes;
        //     $demandes->setCategory($faker->numberBetween(0, 3))
        //         ->setDescription($faker->paragraph())
        //         ->setUser(mt_rand(8, 18));

        //     $manager->persist($demandes);
        // }

        // création d'un admin
        $admin = new User;
        $hash = $this->passwordHasher->hashPassword($admin, "password");
        $admin->setEmail("cdtximperial@gmail.com")->setPassword($hash)->setFirstName("Christelle")->setLastName("Audoly")->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        /// boucle pour crée 5 users
        for ($u = 0; $u < 5; $u++) {
            $user = new User();
            $hash = $this->passwordHasher->hashPassword($user, "password");
            $email = $faker->userName . '@ac-nice.fr';
            $user->setEmail($email)
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setPassword($hash);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
