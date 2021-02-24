<?php


namespace App\Controller;


use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\Store\ProductRepository;
use App\Repository\Store\BrandRepository;

class StoreController extends AbstractController
{

    private ProductRepository $productRepository;
    private BrandRepository $brandRepository;

    public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository)
    {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @Route("/products", name="store_list")
     */
    public function products(): Response
    {
        $products = $this->productRepository->findAll();
        $brands = $this->brandRepository->findAll();

        return $this->render('store/productList.html.twig', [
            'products' => $products,
            'brands' => $brands
        ]);
    }

    /**
     * @Route("/products/brand/{brandId}", name="store_list_by_brand", requirements={"brandId" = "\d+"}, methods={"GET"})
     * @param int $brandId
     * @return Response
     */
    public function productsByBrand(int $brandId): Response
    {

        if($brandId === null){
            throw new NotFoundHttpException();
        }

        $products = $this->productRepository->findBy(
            ['brand' => $brandId]
        );

        return $this->render('store/productList.html.twig', [
            'products' => $products,
            'curent_brand_id' => $brandId
        ]);
    }

    /**
     * @Route("/product/{id}/details/{slug}", name="store_product", requirements={"id" = "\d+"}, methods={"GET"})
     * @param int $id
     * @param string $slug
     * @return Response
     */
    public function product(int $id, string $slug): Response
    {
        $product= $this->productRepository->find($id);

        if($product === null){
            throw new NotFoundHttpException();
        }

        /*if ($product->getSlug() !== $slug) {
            return $this->redirectToRoute()
        }*/

        return $this->render('store/product.html.twig', [
            'product'=> $product,
        ]);
    }

    public function brandsMenu(int $currentBrandId = null): Response
    {
        $brands = $this->brandRepository->findAll();

        return $this->render('store/_brandsMenu.html.twig',[
           'brands' => $brands,
           'current_brand_id' => $currentBrandId
        ]);
    }

}
