<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SkillController extends AbstractController
{
    /**
     * @Route("/skill", name="skill")
     */
    public function index(SkillRepository $skillRepository): Response
    {
        return $this->render('skill/index.html.twig', [
            'skills' => $skillRepository->findAll(),
        ]);
    }

    /**
     * @Route("skill/new", name="skill_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

            $skill = new Skill();
            $form = $this->createForm(SkillType::class, $skill);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($skill);
                $entityManager->flush();

                return $this->redirectToRoute('skill', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('skill/new.html.twig', [
                'skill' => $skill,
                'form' => $form,
            ]);
    }

    /**
     * @Route("skill/{id}", name="skill_show", methods={"GET"})
     */
    public function show(Skill $skill): Response
    {
        return $this->render('skill/show.html.twig', [
            'skill' => $skill,
        ]);
    }

    /**
     * @Route("skill/{id}/edit", name="skill_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Skill $skill): Response
    {

            $form = $this->createForm(SkillType::class, $skill);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('skill', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('skill/edit.html.twig', [
                'skill' => $skill,
                'form' => $form,
            ]);
    }

    /**
     * @Route("skill/{id}", name="skill_delete", methods={"POST"})
     */
    public function delete(Request $request, Skill $skill): Response
    {
        $actualskill = $this->getSkill();
        if(($actualskill->getId() == $skill->getId() || $actualskill->getRoles() == ['ROLE_SUPER_ADMIN']))
        {
            if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($skill);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('skill', [], Response::HTTP_SEE_OTHER);
        }
        else {
            return $this->redirectToRoute('skill');
        }
    }
}
