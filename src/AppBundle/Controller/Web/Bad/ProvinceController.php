<?php

namespace AppBundle\Controller\Web\Bad;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Province;

/**
 * Province controller.
 *
 * @Route("/province")
 */
class ProvinceController extends Controller
{
    /**
     * Lists all Province entities.
     *
     * @Route("/", name="web_bad_province_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $provinces = $em->getRepository('AppBundle:Province')->findAll();

        return $this->render('bad/province/index.html.twig', array(
            'provinces' => $provinces,
        ));
    }

    /**
     * Creates a new Province entity.
     *
     * @Route("/new", name="web_bad_province_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $province = new Province();
        $form = $this->createForm('AppBundle\Form\Web\Bad\ProvinceType', $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($province);
            $em->flush();

            return $this->redirectToRoute('web_bad_province_show', array('id' => $province->getId()));
        }

        return $this->render('bad/province/new.html.twig', array(
            'province' => $province,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Province entity.
     *
     * @Route("/{id}", name="web_bad_province_show")
     * @Method("GET")
     */
    public function showAction(Province $province)
    {
        $deleteForm = $this->createDeleteForm($province);

        return $this->render('bad/province/show.html.twig', array(
            'province' => $province,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Province entity.
     *
     * @Route("/{id}/edit", name="web_bad_province_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Province $province)
    {
        $deleteForm = $this->createDeleteForm($province);
        $editForm = $this->createForm('AppBundle\Form\Web\Bad\ProvinceType', $province);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($province);
            $em->flush();

            return $this->redirectToRoute('web_bad_province_edit', array('id' => $province->getId()));
        }

        return $this->render('bad/province/edit.html.twig', array(
            'province' => $province,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Province entity.
     *
     * @Route("/{id}", name="web_bad_province_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Province $province)
    {
        $form = $this->createDeleteForm($province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($province);
            $em->flush();
        }

        return $this->redirectToRoute('web_bad_province_index');
    }

    /**
     * Creates a form to delete a Province entity.
     *
     * @param Province $province The Province entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Province $province)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('web_bad_province_delete', array('id' => $province->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
