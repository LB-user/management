<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserHierarchyType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();

            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('user_skill', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('user/new.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(user $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, User $user): Response
    {
        $actualUser = $this->getUser();
        if($actualUser->getId() == $user->getId() || $actualUser->getRoles() == ['ROLE_SUPER_ADMIN'])
        {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }
        else {
            return $this->redirectToRoute('user');
        }
    }

        /**
     * @Route("/{id}/edit_team", name="user_edit_team", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editTeam(Request $request, User $user): Response
    {
        $actualUser = $this->getUser();
        if($actualUser->getId() != $user->getId())
        {
            $form = $this->createForm(UserHierarchyType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
            }
            return $this->renderForm('user/edit_team.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }
        else {
            return $this->redirectToRoute('user');
        }
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, User $user): Response
    {
        $actualUser = $this->getUser();
        if(($actualUser->getId() == $user->getId() || $actualUser->getRoles() == ['ROLE_SUPER_ADMIN']))
        {
            if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($user);
                $entityManager->flush();
            }
            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }
        else {
            return $this->redirectToRoute('user');
        }
    }
}
