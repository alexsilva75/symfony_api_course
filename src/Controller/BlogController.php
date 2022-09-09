<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController
{
    
    #[Route('/{page}',  name: 'blog_list', defaults: ['page' => 1])]
    public function list($page){
        return $this->json([
            'page' => $page,
            
        ]);
    }

    #[Route('/post/{id}', name: 'blog_by_id', requirements: ['id' => "\d+"] )]
    public function post(){
        return $this->json([
            'message' => 'Welcome to your new BLOG BY ID controller!',
            'path' => 'src/Controller/BlogController.php',
        ]);
    }

    #[Route('/post/{slug}', name: 'blog_by_slug')]
    public function postBySlug(){
        return $this->json([
            'message' => 'Welcome to your new  BLOG BY SLUG controller!',
            'path' => 'src/Controller/BlogController.php',
        ]);
    }
}
