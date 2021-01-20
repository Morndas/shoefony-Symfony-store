<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\Store\ProductRepository;

class StoreController extends AbstractController
{

    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/products", name="store_list")
     */
    public function products(): Response
    {
        // A changer
        return $this->render('main/homepage.html.twig', [
            'products' => $this->productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/product/{id}/details/{slug}", name="store_product", requirements={"id" = "\d+"})
     * @param Request $request
     * @param int $id
     * @param string $slug
     * @return Response
     */
    public function product(Request $request, int $id, string $slug): Response
    {
        return $this->render('store/product.html.twig', array(
            'id' => $id,
            'slug' => $slug,
            'ip' => $request->getClientIp()
        ));
    }

}
