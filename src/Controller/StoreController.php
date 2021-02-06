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
        $products = $this->productRepository->findAll();

        return $this->render('store/productList.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/{id}/details/{slug}", name="store_product", requirements={"id" = "\d+"})
     * @param Request $request
     * @param int $id
     * @param string $slug
     * @return Response
     */
    public function product(int $id, string $slug): Response
    {
        $product= $this->productRepository->find($id);

        if(!$product || $product->getSlug()  !== $slug){
            throw $this->createNotFoundException();
        }

        return $this->render('store/product.html.twig', [
            'product'=> $product,

        ]);
    }

}
