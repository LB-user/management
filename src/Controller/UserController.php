<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserAdminType;
use App\Form\UserHierarchyType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

                return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
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
        if($actualUser->getId() == $user->getId() || in_array('ROLE_SUPER_ADMIN', $actualUser->getRoles(), true))
        {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user_show', [], Response::HTTP_SEE_OTHER);
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
        
        $form = $this->createForm(UserHierarchyType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('user/edit_team.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit_admin", name="user_edit_admin", methods={"GET","POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function editAdmin(Request $request, User $user): Response
    {
        $form = $this->createForm(UserAdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('user/edit_admin.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, User $user): Response
    {
        $actualUser = $this->getUser();
        if(($actualUser->getId() == $user->getId() || in_array('ROLE_ADMIN', $actualUser->getRoles(), true)))
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

    public function searchBar()
    {
        $form = $this->createFormBuilder(null)
        ->add('choice', ChoiceType::class, [
            'label' => 'Rechercher par :',
            'attr' => [
                'class' => 'w-50 form-control'
            ],
            'choices'  => array(
                'nom' => 'user.lastname',
                'compétences' => 'skill',
                'appétences' => 'appetence',
            )
        ])
        ->add('query', TextType::class, [
            'label' => 'Rechercher',
            'attr' => [
                'class' => 'w-50 form-control'
            ],
        ])
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'mt-2 btn-danger'
            ]
        ])
        ->getForm();
        return $this->render('user/search_bar.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
