<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserSkillController extends AbstractController
{
    /**
     * @Route("/user/skill", name="user_skill")
     */
    public function index(): Response
    {
        return $this->render('user_skill/index.html.twig', [
            'controller_name' => 'UserSkillController',
        ]);
    }
}