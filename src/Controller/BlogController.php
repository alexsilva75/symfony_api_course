<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController
{
    
    #[Route('/{page}',  name: 'blog_list', defaults: ['page' => 1], methods: ['GET'])]
    public function list($page){
        return $this->json([
            'page' => $page,
            
        ]);
    }

    #[Route('/post/{id}', name: 'blog_by_id', requirements: ['id' => "\d+"], methods: ['GET']  )]
    public function post(){
        return $this->json([
            'message' => 'Welcome to your new BLOG BY ID controller!',
            'path' => 'src/Controller/BlogController.php',
        ]);
    }

    #[Route('/post/{slug}', name: 'blog_by_slug', methods: ['GET'])]
    public function postBySlug(){
        return $this->json([
            'message' => 'Welcome to your new  BLOG BY SLUG controller!',
            'path' => 'src/Controller/BlogController.php',
        ]);
    }

    #[Route('/add', name: 'blog_add', methods:['POST'])]
    public function add(Request $request, Serializer $serializer, BlogPostRepository $blogPostRepository){
        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');

        //dd($blogPost);
        $blogPostRepository->add($blogPost, true);

        return $this->json($blogPost);
    }
}
