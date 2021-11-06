<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Address;
use App\Form\AddressType;
use App\Form\AddressCompanyType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AddressController extends AbstractController
{

    private EntityManagerInterface $em;

    protected $auth;

    public function __construct(AuthorizationCheckerInterface $auth, EntityManagerInterface $em)
    {
        $this->auth = $auth;
        $this->em = $em;
    }

    /**
     * @Route("/address", name="address")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function index(AddressRepository $addressRepository): Response
    {
        return $this->render('address/index.html.twig', [
            'addresses' => $addressRepository->findAll(),
        ]);
    }

    /**
     * @Route("address/new_company", name="address_new_company", methods={"GET","POST"})
     */
    public function newCompanyAddress(Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressCompanyType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address/new_company.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    /**
     * @Route("address/new_user", name="address_new_user", methods={"GET","POST"})
     */
    public function newUserAddress(Request $request, EntityManagerInterface $em): Response
    {

        $id = $request->query->get('id');
        $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);

        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->auth->isGranted('ROLE_SUPER_ADMIN')) {
                $address->setUser($user);
            }
            $user->setChangedAt(new DateTimeImmutable());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address/new_user.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    /**
     * @Route("address/{id}", name="address_show", methods={"GET"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function show(Address $address): Response
    {
        return $this->render('address/show.html.twig', [
            'address' => $address,
        ]);
    }

    /**
     * @Route("address/{id}/edit_company", name="address_edit_company", methods={"GET","POST"})
     */
    public function editCompany(Request $request, Address $address): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address/edit_company.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

        /**
     * @Route("address/{id}/edit_user", name="address_edit_user", methods={"GET","POST"})
     */
    public function editUser(Request $request, Address $address, DateTimeImmutable $date): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getUser()->setChangedAt($date);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address/edit_user.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    /**
     * @Route("address/{id}", name="address_delete", methods={"POST"})
     */
    public function delete(Request $request, Address $address): Response
    {
        if ($this->isCsrfTokenValid('delete' . $address->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($address);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
    }
}
