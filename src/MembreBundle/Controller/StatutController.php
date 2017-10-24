<?php

namespace MembreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MembreBundle\Entity\Statut;
use MembreBundle\Form\StatutType;

/**
 * Statut controller.
 *
 * @Route("/statut")
 */
class StatutController extends Controller
{
    /**
     * Lists all Statut entities.
     *
     * @Route("/", name="statut_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $statuts = $em->getRepository('MembreBundle:Statut')->findAll();

        return $this->render('statut/index.html.twig', array(
            'statuts' => $statuts,
        ));
    }

    /**
     * Creates a new Statut entity.
     *
     * @Route("/new", name="statut_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $statut = new Statut();
        $form = $this->createForm('MembreBundle\Form\StatutType', $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($statut);
            $em->flush();

            return $this->redirectToRoute('statut_show', array('id' => $statut->getId()));
        }

        return $this->render('statut/new.html.twig', array(
            'statut' => $statut,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Statut entity.
     *
     * @Route("/{id}", name="statut_show")
     * @Method("GET")
     */
    public function showAction(Statut $statut)
    {
        $deleteForm = $this->createDeleteForm($statut);

        return $this->render('statut/show.html.twig', array(
            'statut' => $statut,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Statut entity.
     *
     * @Route("/{id}/edit", name="statut_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Statut $statut)
    {
        $deleteForm = $this->createDeleteForm($statut);
        $editForm = $this->createForm('MembreBundle\Form\StatutType', $statut);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($statut);
            $em->flush();

            return $this->redirectToRoute('statut_edit', array('id' => $statut->getId()));
        }

        return $this->render('statut/edit.html.twig', array(
            'statut' => $statut,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Statut entity.
     *
     * @Route("/{id}", name="statut_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Statut $statut)
    {
        $form = $this->createDeleteForm($statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($statut);
            $em->flush();
        }

        return $this->redirectToRoute('statut_index');
    }

    /**
     * Creates a form to delete a Statut entity.
     *
     * @param Statut $statut The Statut entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Statut $statut)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('statut_delete', array('id' => $statut->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
