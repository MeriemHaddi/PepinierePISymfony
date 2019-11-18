<?php

namespace HeavenTNBundle\Controller;

use Knp\Snappy\Pdf;
use HeavenTNBundle\Entity\Commande;
use HeavenTNBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    public function totalAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

       $com=$this->getDoctrine()->getRepository(Commande::class)->findByClient($user->getId());
        $date=new \DateTime();

        foreach ($com as $item) {
            $item->setDate($date);
            $item->getDate();
            $item->setStatus('Being Treated');
            $item->setPrice($item->getPrice() * $item->getQuantity());
            $em=$this->getDoctrine()->getManager();
            $em->flush();
       }


        return $this->render('commande/total.html.twig',array(
            'com'=>$com
        ));
    }
    /**
     * Lists all commande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('HeavenTNBundle:Commande')->findAll();

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,
        ));

    }

    /**
     * Creates a new commande entity.
     *
     */


    /**
     * Finds and displays a commande entity.
     *
     */
    public function showAction(Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('commande/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     */
    public function editAction(Request $request, Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('HeavenTNBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commande entity.
     *
     */
    public function deleteAction(Request $request, Commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('commande_index');
    }

    /**
     * Creates a form to delete a commande entity.
     *
     * @param Commande $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function approveAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $commande=$em->getRepository('HeavenTNBundle:Commande')->find($id);
        $commande->setStatus('Approved');
        $em->persist($commande);
        $em->flush();



        return $this->redirectToRoute('commande_index');

        return $this->render('commande/index.html.twig', array(
            'commande' => $commande
        ));
    }


    public function ignoreAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $commande=$em->getRepository('HeavenTNBundle:Commande')->find($id);
        $commande->setStatus('Unapproved');
        $em->persist($commande);
        $em->flush();



        return $this->redirectToRoute('commande_index');
        return $this->render('commande/index.html.twig', array(
            'commande' => $commande
        ));
    }

    public function sortAction($sort)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($sort=='ASC'){
            $query = $entityManager->createQuery(
                'SELECT c
    FROM HeavenTNBundle:Commande c
    ORDER BY c.price ASC'
            );
        }else {
            $query = $entityManager->createQuery(
                'SELECT c
    FROM HeavenTNBundle:Commande c
    ORDER BY c.price DESC'
            );
        }


        $commande = $query->getResult();

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commande,
        ));
    }


    public function pdfAction()
    {   $em = $this->getDoctrine()->getManager();
        $commande=$em->getRepository('HeavenTNBundle:Commande')->findAll();
        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('@HeavenTN/commande/pdf.html.twig', array('commandes'=>$commande
            //..Send some data to your view if you need to //
        ));

        $filename = 'mesfacture';


        return new Response(

            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        )
            ;
    }
}
