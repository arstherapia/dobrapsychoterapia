<?php

namespace MES\APP\FrontendBundle\Controller;

use Frontend\FrontendBundle\Entity\Movies;
use Knp\Component\Pager\Paginator;
use MES\APP\FrontendBundle\Form\MoviesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Movies controller.
 *
 * @Route("/filmy")
 */
class MoviesController extends Controller {

    /**
     * Displays a form to create a new Movies entity.
     *
     * @Route("/new", name="filmy_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Movies();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Lists all Movies entities.
     *
     * @Route("/{page}", name="filmy", defaults={"page" = 1}, requirements={"id" = "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request, $page) {
        $em = $this->getDoctrine()->getManager();

//        $dql = "SELECT a FROM FrontendBundle:Movies a";
//        $query = $em->createQuery($dql);

        $query = $em
                ->createQueryBuilder()
                ->select('mov')
                ->from('FrontendBundle:Movies', 'mov')
                ->leftJoin('mov.therapist', 'th')
                ->leftJoin('mov.languages', 'lg')
                ->getQuery()
                ->getResult();
        /* @var $paginator Paginator */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->query->get('page', $page)/* page number */, 100000
        );
        return ['entities' => $pagination];
    }

    /**
     * Creates a new Movies entity.
     *
     * @Route("/", name="filmy_create")
     * @Method("POST")
     * @Template("FrontendBundle:Movies:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Movies();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('filmy_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Movies entity.
     *
     * @param Movies $entity The entity
     *
     * @return Form The form
     */
    private function createCreateForm(Movies $entity) {
        $form = $this->createForm(new MoviesType(), $entity, array(
            'action' => $this->generateUrl('filmy_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a Movies entity.
     *
     * @Route("/display/{id}", name="filmy_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Movies')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movies entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Movies entity.
     *
     * @Route("/edit/{id}", name="filmy_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Movies')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movies entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Movies entity.
     *
     * @param Movies $entity The entity
     *
     * @return Form The form
     */
    private function createEditForm(Movies $entity) {
        $form = $this->createForm(new MoviesType(), $entity, array(
            'action' => $this->generateUrl('filmy_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Movies entity.
     *
     * @Route("/update/{id}", name="filmy_update")
     * @Method("PUT")
     * @Template("FrontendBundle:Movies:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Movies')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movies entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('filmy_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Movies entity.
     *
     * @Route("/delete/{id}", name="filmy_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:Movies')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Movies entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('filmy'));
    }

    /**
     * Creates a form to delete a Movies entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('filmy_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Usuń', 'attr' => [ 'class' => 'btn btn-danger']))
                        ->getForm()
        ;
    }

}
