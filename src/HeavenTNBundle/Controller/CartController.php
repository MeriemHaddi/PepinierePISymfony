<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arshavin
 * Date: 25/02/2018
 * Time: 15:18
 */

namespace HeavenTNBundle\Controller;


use HeavenTNBundle\Entity\Cart;
use HeavenTNBundle\Entity\Commande;
use HeavenTNBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function addToCartAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $product = $em->getRepository('HeavenTNBundle:Product')->find($id);
        $user = $this->get('security.token_storage')->getToken()->getUser();

            $cart = new Cart();
            $cart->SetUser($user);
            $cart->setProduct($product);
            $cart->setQuantity(2);
            $cart->setStatus("Being Treated");
            $cart->setPrice($product->getPrice());

        $em->persist($cart);
            $em->persist($product);
            $em->flush();


        return $this->redirectToRoute('_cupcakes_cart');

    }


    public function showCartAction(Request $request)

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

        public function removeFromCartAction($id)
        {
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('HeavenTNBundle:Cart')->find($id);
            $product1 = $em->getRepository('HeavenTNBundle:Product')->find($product->getProduct()->getIdproduct());

        $em->persist($product1);
        $em->remove($product);

        $em->flush();
            return $this->redirectToRoute('_cupcakes_cart');

    }

    public function commandeadminAction(Request $request)

    {   $em = $this->getDoctrine()->getManager();


        $price=0;
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user_id = $user->getId();

        $carts = $em->getRepository('HeavenTNBundle:Cart')->findByUser($user_id);
        foreach ($carts as $cart)
        {
            $price=$price+$cart->product->getPrice()*$price;
        }




        return $this->render('@HeavenTN/Cart/commandeadmin.html.twig', array('carts' => $carts,'price'=>$price));

    }









}