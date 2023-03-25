<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
    public function show(int $id, PostRepository $postRepo): Response
    {
        //dump($request);
    
            $post = $postRepo->find($id);
            //dd($post);

           /* if ($post === null) {
                    throw $this->createNotFoundException('article inexistant');
            }

            $commentForFormulaire = new Comment();


            $form = $this->createForm(CommentType::class, $commentForFormulaire);

            $form->handleRequest($request);

            if ($request->isMethod("POST")) {

                    if ($form->isSubmitted() && $form->isValid()){


                       /* $username = $request->request->get("username");
                        $body = $request->request->get("body");
                        $comment = new Comment();
                        $comment->setUsername($username);
                        $comment->setBody($body);
                        $commentForFormulaire->setPost($post);

                        $commentForFormulaire->setCreatedAt(new DateTimeImmutable("now"));

                        $doctrine->persist($commentForFormulaire);
                        $doctrine->flush();

                        return $this->redirectToRoute("post", ["id" => $id]);*/
 


        return $this->renderForm('post/show.html.twig', [
            'post' => $post,
          
        ]);
    }



     /**
     * @Route("/new/{id}", name="new_comment", methods={"GET", "POST"})
     */
    public function new(int $id, PostRepository $postRepo, Request $request, CommentRepository $CommentRepository): Response
    {

        $post = $postRepo->find($id);

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setPost($post);
            $CommentRepository->add($comment, true);

            return $this->redirectToRoute("post", ["id" => $id]);

        }

        return $this->renderForm('post/new_comment.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }




















}
