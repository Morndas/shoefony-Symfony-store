<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class StoreController extends AbstractController
{
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

        /*$product = $this->productRepository->find($id);
        if (null === $product) {
            throw new NotFoundHttpException();
        }

        if ($product->getSlug() !== $slug) {
            return $this->redirectToRoute('store_product', [
                'id' => $id,
                'slug' => $product->getSlug(),
            ], Response::HTTP_MOVED_PERMANENTLY);
        }

        return $this->render('store/product.html.twig', [
            'product' => $product,
            'brands' => $this->brandRepository->findBy([], ['name' => 'ASC']),
        ]);*/
    }

}
