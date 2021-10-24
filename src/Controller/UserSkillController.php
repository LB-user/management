<?php

namespace App\Controller;

use App\Entity\UserSkill;
use App\Form\UserSkillType;
use App\Repository\UserSkillRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserSkillController extends AbstractController
{
    /**
     * @Route("/userskill", name="user_skill")
     */
    public function index(UserSkillRepository $userSkillRepository): Response
    {
        return $this->render('user_skill/index.html.twig', [
            'user_skills' => $userSkillRepository->findAll(),
        ]);
    }

    /**
     * @Route("/userskill/new", name="user_skill_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userSkill = $this->getUserSkill();

            $userSkill = new UserSkill();
            $form = $this->createForm(UserSkillType::class, $userSkill);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userSkill);
                $entityManager->flush();

                return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('user_skill/new.html.twig', [
                'user_skill' => $userSkill,
                'form' => $form,
            ]);
    }

    /**
     * @Route("/userskill/{id}", name="user_skill_show", methods={"GET"})
     */
    public function show(userSkill $userSkill): Response
    {
        return $this->render('user_skill/show.html.twig', [
            'user_skill' => $userSkill,
        ]);
    }

    /**
     * @Route("/userskill/edit/{id}", name="user_skill_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserSkill $userSkill): Response
    {
        $actualUserSkill = $this->getUserSkill();
        if($actualUserSkill->getId() == $userSkill->getId() || in_array('ROLE_SUPER_ADMIN', $actualUserSkill->getRoles(), true))
        {
            $form = $this->createForm(UserSkillType::class, $userSkill);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user_skill', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('user_skill/edit.html.twig', [
                'user_skill' => $userSkill,
                'form' => $form,
            ]);
        }
        else {
            return $this->redirectToRoute('user');
        }
    }

    /**
     * @Route("/userskill/{id}", name="user_skill_delete", methods={"POST"})
     */
    public function delete(Request $request, UserSkill $userSkill): Response
    {
        $actualUserSkill = $this->getUserSkill();
        if(($actualUserSkill->getId() == $userSkill->getId() || in_array('ROLE_SUPER_ADMIN', $actualUserSkill->getRoles(), true)))
        {
            if ($this->isCsrfTokenValid('delete'.$userSkill->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($userSkill);
                $entityManager->flush();
            }
            return $this->redirectToRoute('user_skill', [], Response::HTTP_SEE_OTHER);
        }
        else {
            return $this->redirectToRoute('user');
        }
    }
}