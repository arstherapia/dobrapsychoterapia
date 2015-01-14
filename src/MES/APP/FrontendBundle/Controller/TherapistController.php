<?php

namespace MES\APP\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Frontend\FrontendBundle\Entity\Therapist;
use Frontend\FrontendBundle\Form\TherapistType;

/**
 * Therapist controller.
 *
 * @Route("/therapist")
 */
class TherapistController extends Controller
{

    /**
     * Lists all Therapist entities.
     *
     * @Route("/", name="therapist")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontendBundle:Therapist')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Therapist entity.
     *
     * @Route("/", name="therapist_create")
     * @Method("POST")
     * @Template("FrontendBundle:Therapist:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Therapist();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('therapist_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Therapist entity.
     *
     * @param Therapist $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Therapist $entity)
    {
        $form = $this->createForm(new \MES\APP\FrontendBundle\Form\TherapistType(), $entity, array(
            'action' => $this->generateUrl('therapist_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Therapist entity.
     *
     * @Route("/new", name="therapist_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Therapist();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Therapist entity.
     *
     * @Route("/{id}", name="therapist_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Therapist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Therapist entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Therapist entity.
     *
     * @Route("/{id}/edit", name="therapist_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Therapist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Therapist entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Therapist entity.
    *
    * @param Therapist $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Therapist $entity)
    {
        $form = $this->createForm(new \MES\APP\FrontendBundle\Form\TherapistType(), $entity, array(
            'action' => $this->generateUrl('therapist_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Therapist entity.
     *
     * @Route("/{id}", name="therapist_update")
     * @Method("PUT")
     * @Template("FrontendBundle:Therapist:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Therapist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Therapist entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('therapist_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Therapist entity.
     *
     * @Route("/{id}", name="therapist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:Therapist')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Therapist entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('therapist'));
    }

    /**
     * Creates a form to delete a Therapist entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('therapist_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
