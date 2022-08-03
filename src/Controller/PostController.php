<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'post', methods: ['GET'])]
    public function post(): Response
    {
        return $this->render('post/post.html.twig');
    }

    #[Route('/post/make', name: 'post_make', methods: ['GET'])]
    public function postMake(): Response
    {
        return $this->render('post/make.html.twig');
    }

    #[Route('/post/edit', name: 'post_edit', methods: ['GET'])]
    public function postEdit(): Response
    {
        return $this->render('post/make.html.twig');
    }
}
