<?php

namespace HeavenTNBundle\Controller;

use HeavenTNBundle\Entity\Product;
use HeavenTNBundle\Entity\Promotion;
use HeavenTNBundle\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use UserBundle\Entity\User;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('HeavenTNBundle:Product')->findBy(array());

        foreach ($products as $e)
        {
            $diff =($e->getQuantite())-($e->getMinAlert());
            if ($diff <50) {
                $e->setStockstate("Warning");
            }

            if ($diff >=50 && $diff <=100) {
                $e->setStockstate("Check your Stock");
            }
            if ($diff>100){
                $e->setStockstate("Good");             }

        }

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

    public function indexfrontAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('HeavenTNBundle:Product')->findBy(array());

        foreach ($products as $e)
        {
            $diff =($e->getQuantite())-($e->getMinAlert());
            if ($diff <50) {
                $e->setStockstate("Warning");
            }

            if ($diff >=50 && $diff <=100) {
                $e->setStockstate("Check your Stock");
            }
            if ($diff>100){
                $e->setStockstate("Good");             }

        }

        return $this->render('product/indexfront.html.twig', array(
            'products' => $products,
        ));
    }







    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('HeavenTNBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('productimage')->getData();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->getExtension();

            // Move the file to the directory where brochures are stored
            $path = "http://127.0.0.1/" ;
            $file->move("C:\wamp64\www", $fileName);
            $product->setProductimage($path.$fileName);
             $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('product_index');


        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     */
    public function showAction(Request $request,Product $product)
    {

        $user=$this->getUser();
        $review=$this->getDoctrine()->getRepository(Review::class)->findAll();
        $u=$this->getDoctrine()->getRepository(User::class)->find($user);
        $deleteForm = $this->createDeleteForm($product);
        if($request->isMethod('POST'))
        {
            $rev=new Review();
            $date=new \DateTime();
            $rev->setDate($date);
            $rev->setUser($user);
            $rev->setProduct($product);
            $rev->setDescription($request->get('text'));
            $rev->setName($u->getFirstName());
            $em=$this->getDoctrine()->getManager();
            $em->persist($rev);
            $em->flush();
            return $this->redirect('show');
        }



        return $this->render('product/show.html.twig', array(
            'review'=>$review,
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('HeavenTNBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $file = $editForm->get('productimage')->getData();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->getExtension();

            // Move the file to the directory where brochures are stored
            $path = "http://127.0.0.1/" ;
            $file->move("C:\wamp64\www", $fileName);
            $product->setProductimage($path.$fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index', array('idproduct' => $product->getIdproduct()));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('idproduct' => $product->getIdproduct())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function showreviewsAction(Request $request)

    {   $em = $this->getDoctrine()->getManager();


        $price=0;
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $carts = $em->getRepository('HeavenTNBundle:Cart')->findByUser($user_id);
        $com=new Commande();


        foreach ($carts as $cart)
        {
            if($request->isMethod('POST')) {
                $product = $this->getDoctrine()->getRepository(Product::class)->find($cart->getProduct());
                $com->setClient($user);
                $com->setQuantity($request->get('quantite'));
                $com->setStatus($cart->getStatus());
                $com->setPrice($product->getPrice());
                $em = $this->getDoctrine()->getManager();

                $em->persist($com);
                $em->flush();
                return $this->redirect('//localhost/pepinierepi/web/app_dev.php/heaven/Cart');
            }
            $price=$price+$cart->product->getPrice()*$price;
        }




        return $this->render('@HeavenTN/Cart/cart.html.twig', array('carts' => $carts,'price'=>$price));

    }

    public function sortAction($sort)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($sort=='ASC'){
            $query = $entityManager->createQuery(
                'SELECT p
    FROM HeavenTNBundle:Product p
    ORDER BY p.price ASC'
            );
        }else {
            $query = $entityManager->createQuery(
                'SELECT p
    FROM HeavenTNBundle:Product p
    ORDER BY p.price DESC'
            );
        }


        $products = $query->getResult();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }



}
