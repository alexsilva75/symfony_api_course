<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController
{
    
    #[Route('/{page}',  name: 'blog_list', defaults: ['page' => 1], methods: ['GET'], requirements: ['page' => "\d+"])]
    public function list($page, Request $request, BlogPostRepository $blogPostRepository){
        $limit = $request->get('limit', 10);
        $blogPosts = $blogPostRepository->findAll();

        $blogPostsUrls = array_map(function(BlogPost $post){
            return $this->generateUrl('blog_by_slug', ['slug' => $post->getSlug()]);
        },$blogPosts);

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'blog_posts_urls' => $blogPostsUrls,
            
        ]);
    }

    #[Route('/post/{id}', name: 'blog_by_id', requirements: ['id' => "\d+"], methods: ['GET']  )]
    public function post(
    BlogPost $post // Needs composer require sensio/framework-extra-bundle
    ){
        return $this->json([
            'blog_post' => $post//$blogPostRepository->find($id),
          
        ]);
    }

    #[Route('/post/{slug}', name: 'by_slug', methods: ['GET'])]
    /**
     * @ParamConverter("post", class="App\Entity\BlogPost")
     */
    public function postBySlug(
     $post // Needs composer require sensio/framework-extra-bundle
    ){
        return $this->json([
            'blog_post' => $post //$blogPostRepository->findOneBy(['slug' => $slug]),
            
        ]);
    }

    #[Route('/add', name: 'blog_add', methods:['POST'])]
    public function add(Request $request, SerializerInterface $serializer, BlogPostRepository $blogPostRepository){
        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');

        //dd($blogPost);
        $blogPostRepository->add($blogPost, true);

        return $this->json($blogPost);
    }

    #[Route('/post/{id}', name: '_delete', methods:['DELETE'])]
    public function delete(BlogPost $post, BlogPostRepository $blogPostRepository){
        try {
            //code...
            $blogPostRepository->remove($post, true);

            //return $this->json(['status' =>'OK', 'message' => 'The record was deleted successfully!'],200);
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);

        } catch (\Throwable $th) {
            //throw $th;
            return $this->json(['status' =>'ERROR', 'message' => 'Error deleting BlogPost record']);
        }
        

    }
}
