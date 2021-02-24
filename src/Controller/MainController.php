<?php


namespace App\Controller;


use App\Repository\Store\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Controller\Manager\ContactManager;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{

    private ContactManager $contactManager;
    private ProductRepository $productRepository; // je ne peux pas afficher les produits sur la homepage autrement (?)

    public function __construct(ContactManager $contactManager ,ProductRepository $productRepository)
    {
        $this->contactManager = $contactManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/", name="main_homepage")
     */
    public function homepage() :Response {

        $newProducts = $this->productRepository->findLastCreated();
        $popProducts = $this->productRepository->findMostCommProducts();

        return $this->render('main/homepage.html.twig', [
            'newProducts' => $newProducts,
            'popProducts' => $popProducts
        ]);
    }

    /**
     * @Route("/presentation", name="main_presentation")
     */
    public function presentation(): Response
    {
        return $this->render('main/presentation.html.twig');
    }

    /**
     * @Route("/contact", name="main_contact", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function contact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Merci, votre message a été pris en compte !');

            $this->contactManager->save($contact);

            return $this->redirectToRoute('main_contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
