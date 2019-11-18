<?php

namespace HeavenTNBundle\Controller;

use HeavenTNBundle\Entity\Cart;
use HeavenTNBundle\Entity\Commande;
use HeavenTNBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;


class MobileController extends Controller
{public function showCartMAction()

{    $tasks = $this->getDoctrine()->getManager()
    ->getRepository(Cart::class)
    ->findAll();

    $serializer = new Serializer([new ObjectNormalizer()]);
    $formatted = $serializer->normalize($tasks);
    return new JsonResponse($formatted);
    }

    public function newAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $p=$this->getDoctrine()->getRepository(Product::class)->find($request->get('id_product'));
        $u=$this->getDoctrine()->getRepository(User::class)->find($request->get('user_id'));
        $cart = new Cart();
        $cart->SetUser($u);
        $cart->setProduct($p);
        $cart->setQuantity($request->get('quantity'));
        $cart->setStatus("Being Treated");
        $cart->setPrice($request->get('price'));

        $em->persist($cart);

        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($cart);
        return new JsonResponse($formatted);
    }
    public function removeFromCartMAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('HeavenTNBundle:Cart')->find($id);
        $product1 = $em->getRepository('HeavenTNBundle:Product')->find($cart->getProduct()->getIdproduct());

        $em->persist($product1);
        $em->remove($cart);

        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($product1);
        return new JsonResponse($formatted);
    }

    public function findAction($id,Request $request)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(Cart::class)
            ->find($id);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks->getProduct()->getIdProduct());
        return new JsonResponse($formatted);
    }
    public function findUserAction($id,Request $request)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(Cart::class)
            ->find($id);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks->getUser()->getId());
        return new JsonResponse($formatted);
    }
    public function ProdAction()

    {    $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($product);
        return new JsonResponse($formatted);
    }
    public function ProdIDAction($id,Request $request)

    {    $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->find($id);


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($product);
        return new JsonResponse($formatted);
    }

    public function afficherCommandeAction()

    {    $tasks = $this->getDoctrine()->getManager()
        ->getRepository(Commande::class)
        ->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function ajouterCommandeAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $u=$this->getDoctrine()->getRepository(User::class)->find($request->get('client_id'));
        $commande = new Commande();
        $commande->SetClient($u);
        $date=new \DateTime();

        $commande->setQuantity($request->get('Quantity'));
        $commande->setStatus($request->get('status'));
        $commande->setPrice($request->get('price'));
        $commande->setDate($date);


        $em->persist($commande);

        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commande);
        return new JsonResponse($formatted);
    }
    public function findUserCommandeAction($id,Request $request)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(Commande::class)
            ->find($id);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks->getClient()->getId());
        return new JsonResponse($formatted);
    }

    public function ModifierqauntiteAction(Request $request)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($request->get('id'));

            $product->setQuantite($request->get('quantite'));

            $this->getDoctrine()->getManager()->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($product);
        return new JsonResponse($formatted);
    }
}
