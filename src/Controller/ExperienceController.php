<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Form\ExperienceType;
use App\Repository\ExperienceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExperienceController extends AbstractController
{

    /**
     * @Route("/experience", name="experience")
     */
    public function index(ExperienceRepository $experienceRepository): Response
    {
        return $this->render('experience/index.html.twig', [
            'experiences' => $experienceRepository->findAll(),
        ]);
    }

    /**
     * @Route("experience/new", name="experience_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $experience = new Experience();
        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($experience);
            $entityManager->flush();

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('experience/new.html.twig', [
            'experience' => $experience,
            'form' => $form,
        ]);
    }

    /**
     * @Route("experience/{id}", name="experience_show", methods={"GET"})
     */
    public function show(Experience $experience): Response
    {
        return $this->render('experience/show.html.twig', [
            'experience' => $experience,
        ]);
    }

    /**
     * @Route("experience/{id}/edit", name="experience_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Experience $experience): Response
    {

        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('experience/edit.html.twig', [
            'experience' => $experience,
            'form' => $form,
        ]);
    }

    /**
     * @Route("experience/{id}", name="experience_delete", methods={"POST"})
     */
    public function delete(Request $request, Experience $experience): Response
    {
        if ($this->isCsrfTokenValid('delete' . $experience->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($experience);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
    }
}
