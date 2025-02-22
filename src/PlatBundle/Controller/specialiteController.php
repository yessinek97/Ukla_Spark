<?php

namespace PlatBundle\Controller;

use PlatBundle\Entity\specialite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Specialite controller.
 *
 */
class specialiteController extends Controller
{
    /**
     * Lists all specialite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $specialites = $em->getRepository('PlatBundle:specialite')->findAll();

        return $this->render('specialite/index.html.twig', array(
            'specialites' => $specialites,
        ));
    }

    /**
     * Creates a new specialite entity.
     *
     */
    public function newAction(Request $request)
    {
        $specialite = new Specialite();
        $form = $this->createForm('PlatBundle\Form\specialiteType', $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $image=$request->get('image');
            $specialite->setImage($image);
            $em->persist($specialite);
            $em->flush();

            return $this->redirectToRoute('specialite_show', array('id' => $specialite->getId()));
        }

        return $this->render('specialite/new.html.twig', array(
            'specialite' => $specialite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a specialite entity.
     *
     */
    public function showAction(specialite $specialite)
    {
        $deleteForm = $this->createDeleteForm($specialite);

        return $this->render('specialite/show.html.twig', array(
            'specialite' => $specialite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing specialite entity.
     *
     */
    public function editAction(Request $request, specialite $specialite)
    {
        $deleteForm = $this->createDeleteForm($specialite);
        $editForm = $this->createForm('PlatBundle\Form\specialiteType', $specialite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specialite_edit', array('id' => $specialite->getId()));
        }

        return $this->render('specialite/edit.html.twig', array(
            'specialite' => $specialite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a specialite entity.
     *
     */
    public function deleteAction(Request $request, specialite $specialite)
    {
        $form = $this->createDeleteForm($specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specialite);
            $em->flush();
        }

        return $this->redirectToRoute('specialite_index');
    }

    /**
     * Creates a form to delete a specialite entity.
     *
     * @param specialite $specialite The specialite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(specialite $specialite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specialite_delete', array('id' => $specialite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
