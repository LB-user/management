<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DocumentController extends AbstractController
{
    protected $auth;

    public function __construct(AuthorizationCheckerInterface $auth) {
        $this->auth = $auth;
    }
    
    /**
     * @Route("/document", name="document")
     * @IsGranted("ROLE_SUPER_ADMIN, message="Va chier"")
     */
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
        ]);
    }

    /**
     * @Route("document/new", name="document_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $id = $request->query->get('id');
        $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);

        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!$this->auth->isGranted('ROLE_SUPER_ADMIN')) {
            $document->setUser($user);
            }
            $user->setChangedAt(new DateTimeImmutable());
            $file = $document->getName();
            $fileName = date("Y_m_d_hms", time()). "_" . $file . "_" . $user->getLastName()."_".$user->getFirstName(). ".".$form->get('attachement')->getData()->guessExtension() ;
            $dataFile = $form['attachement']->getData();
            $dataFile->move($this->getParameter('kernel.project_dir') . '/public/', $fileName);

            $document->setAttachement($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($document);
            $entityManager->flush();

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER); 
        }

        return $this->renderForm('document/new.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    /**
     * @Route("document/{id}", name="document_show", methods={"GET"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function show(Document $document): Response
    {
        return $this->render('document/show.html.twig', [
            'document' => $document,
        ]);
    }

    /**
     * @Route("document/{id}/edit", name="document_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Document $document): Response
    {

        $this->denyAccessUnlessGranted('document_edit', $document);

        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getUser()->setChangedAt(new DateTimeImmutable());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document/edit.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    /**
     * @Route("document/{id}", name="document_delete", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Document $document): Response
    {
        $this->denyAccessUnlessGranted('document_delete', $document);

        if ($this->isCsrfTokenValid('delete' . $document->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($document);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
    }
}
