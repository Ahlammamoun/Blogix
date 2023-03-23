<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PostRepository;
use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;



class PostController extends AbstractController
{
    /**
     * @Route("/", name="posts_list")
     */
    public function list(PostRepository $postRepo): Response
    {
        $postList = $postRepo->findAll();
        // dd($postList);
        return $this->render('post/list.html.twig', [
            'postList' => $postList ,

    ]);
    }

    /**
     * @Route("/post/{id}", name="post", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function show(int $id, PostRepository $postRepo, request $request, EntityManagerInterface $doctrine): Response
    {
        dump($request);
    
            $post = $postRepo->find($id);
            //dd($post);

            if ($post === null) {
                    throw $this->createNotFoundException('article inexistant');
            }


        if ($request->isMethod("POST")) {



            $username = $request->request->get("username");
            $body = $request->request->get("body");

          

            $comment = new Comment();
            $comment->setUsername($username);
            $comment->setBody($body);
            $comment->setCreatedAt(new DateTimeImmutable("now"));


            $comment->setPost($post);

            $doctrine->persist($comment);
            $doctrine->flush();
    





        }
  
           

        
      
        return $this->render('post/show.html.twig', [
            'post' => $post,
            
            

        ]);
    }








}
