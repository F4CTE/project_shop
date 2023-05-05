<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
class AppFixtures extends Fixture
{
    public const NB_USERS = 2;
    public const NB_ADMINS = 1;
    public const NB_CATEGORIES = 50;
    public const NB_PRODUCTS = 200;
    public const CATEGORY_REF_PREFIX = 'CATEGORY_';
    public const USER_REF_PREFIX = 'USER_';

    public function __construct()
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_USERS; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email)
                ->setPassword('password');

                if($i < self::NB_ADMINS) {
                    $user->setRoles(['ROLE_ADMIN']);
                }
                $this->addReference(self::USER_REF_PREFIX . $i, $user);
            $manager->persist($user);
        }

        for ($i = 1; $i <= self::NB_CATEGORIES; $i++) {
            $category = new Category();
            $category
                ->setName($faker->realText(15))
                ->setDescription($faker->realTextBetween(200, 500));
            $this->addReference('CATEGORY_' . $i, $category);
            $manager->persist($category);
        }


        for ($i = 0; $i < self::NB_PRODUCTS; $i++) {
            $post = new Product();
            $post
                ->setName($faker->realText(35))
                ->setVisible($faker->boolean(90))
                ->setDescription($faker->paragraphs(6, true))
                ->setTaxFreePrice($faker->randomFloat(2, 1, 1000))
                ->setDiscount($faker->boolean(20))
                ->setDateCreated($faker->dateTimeBetween('-2 years'))
                ->setUser(
                    $this->getReference(
                        self::USER_REF_PREFIX . $faker->numberBetween(0, self::NB_USERS -1)
                    )
                )
                ->setCategory(
                    $this->getReference(
                        self::CATEGORY_REF_PREFIX . $faker->numberBetween(1, self::NB_CATEGORIES)
                    )
                );
            $manager->persist($post);
        }

        $manager->flush();
    }
    
}
