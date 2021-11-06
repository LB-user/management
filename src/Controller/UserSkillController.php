<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserSkill;
use App\Form\UserSkillType;
use App\Repository\UserSkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserSkillController extends AbstractController
{
    protected $auth;

    public function __construct(AuthorizationCheckerInterface $auth) {
        $this->auth = $auth;
    }
    
    /**
     * @Route("/user/skill", name="user_skill")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function index(UserSkillRepository $userSkillRepository): Response
    {
        return $this->render('user_skill/index.html.twig', [
            'user_skills' => $userSkillRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/skill/new", name="user_skill_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
            $id = $request->query->get('id');
            $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);

            $userSkill = new UserSkill();
            $form = $this->createForm(UserSkillType::class, $userSkill);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if(!$this->auth->isGranted('ROLE_SUPER_ADMIN')) {
                $userSkill->setUserId($user);
                }
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
     * @Route("/user/skill/{id}", name="user_skill_show", methods={"GET"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function show(UserSkill $userSkill): Response
    {
        return $this->render('user_skill/show.html.twig', [
            'user_skill' => $userSkill,
        ]);
    }

    /**
     * @Route("/user/skill/edit/{id}", name="user_skill_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, UserSkill $userSkill): Response
    {
            $form = $this->createForm(UserSkillType::class, $userSkill);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('user_skill/edit.html.twig', [
                'user_skill' => $userSkill,
                'form' => $form,
            ]);
    }

    /**
     * @Route("/user/skill/{id}", name="user_skill_delete", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, UserSkill $userSkill): Response
    {
            if ($this->isCsrfTokenValid('delete'.$userSkill->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($userSkill);
                $entityManager->flush();
            }
            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        
    }
}