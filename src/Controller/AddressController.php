<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AddressController extends AbstractController
{
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
     * @Route("address/new", name="address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
            $address = new Address();
            $form = $this->createForm(AddressType::class, $address);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($address);
                $entityManager->flush();

                return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('address/new.html.twig', [
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
     * @Route("address/{id}/edit", name="address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Address $address): Response
    {

            $form = $this->createForm(AddressType::class, $address);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('address/edit.html.twig', [
                'address' => $address,
                'form' => $form,
            ]);
    }

    /**
     * @Route("address/{id}", name="address_delete", methods={"POST"})
     */
    public function delete(Request $request, Address $address): Response
    {
            if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($address);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);

    }
}
