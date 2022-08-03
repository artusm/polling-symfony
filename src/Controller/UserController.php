<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/posts', name: 'user_posts', methods: ['GET'])]
    public function userPosts(): Response
    {
        return $this->render('user/posts.html.twig');
    }

    #[Route('/user/comments', name: 'user_comments', methods: ['GET'])]
    public function userComments(): Response
    {
        return $this->render('user/comments.html.twig');
    }
}
