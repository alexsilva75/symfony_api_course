<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

use App\Entity\BlogPost;

class AppFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        // $product = new Product();
        // $manager->persist($product);
        for($i = 0; $i < 50 ; $i++){

            $blogPost = new BlogPost();
            $blogPost->setTitle($this->faker->words(5,true));
            $blogPost->setContent($this->faker->words(200,true));
            $blogPost->setPublished(new \DateTime('now'));
            $blogPost->setAuthor($this->faker->name());
            $blogPost->setSlug($this->faker->slug());
            
            $manager->persist($blogPost);
        }

        $manager->flush();
    }
}
