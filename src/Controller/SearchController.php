<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('choice', ChoiceType::class, [
                'label' => 'Rechercher par :',
                'attr' => [
                    'class' => 'w-50 form-control'
                ],
                'choices'  => array(
                    'nom' => 'name',
                    'compétences' => 'skill',
                    'appétences' => 'appetence',
                )
            ])
            ->add('query', TextType::class, [
                'label' => 'Entrez votre recherche :',
                'attr' => [
                    'class' => 'w-50 form-control'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'mt-2 btn-danger'
                ]
            ])
            ->getForm();
            return $this->render('user/search_bar.html.twig', [
                'form' => $form->createView()
            ]);
    }

        /**
     * @Route("/handleSearch", name="handleSearch")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     */
    public function handleSearch(Request $request, UserRepository $userRepository)
    {
        $choice = $request->request->get('form')['choice'];
        $query = $request->request->get('form')['query'];
        if($query && $choice == 'name') {
            $users = $userRepository->findUsersByLastName($query);
        } 
        elseif($query && $choice == 'skill') {
            $users = $userRepository->findUsersBySkillName($query);
        }
        elseif($query && $choice == 'appetence') {
            $users = $userRepository->findUsersAppetence($query);
        }
        return $this->render('search/index.html.twig', [
            'users' => $users
        ]);
    }
}
