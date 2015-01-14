<?php

namespace MES\APP\FrontendBundle\Controller;

use Frontend\FrontendBundle\Entity\Catagory;
use Frontend\FrontendBundle\Entity\Problems;
use MES\APP\FrontendBundle\Form\ProblemsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Catagory controller.
 *
 * @Route("/problems")
 */
class ProblemsController extends Controller
{

    /**
     * Lists all Catagory entities.
     *
     * @Route("/", name="problem")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('Frontend\FrontendBundle\Entity\Problems')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Catagory entity.
     *
     * @Route("/", name="problem_create")
     * @Method("POST")
     * @Template("FrontendBundle:Problems:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Problems();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('problem_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Catagory entity.
     *
     * @param Catagory $entity The entity
     *
     * @return Form The form
     */
    private function createCreateForm(Problems $entity)
    {
        $form = $this->createForm(new ProblemsType(), $entity, array(
            'action' => $this->generateUrl('problem_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Catagory entity.
     *
     * @Route("/new", name="problem_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Problems();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Catagory entity.
     *
     * @Route("/{id}", name="problem_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Frontend\FrontendBundle\Entity\Problems')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catagory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Catagory entity.
     *
     * @Route("/{id}/edit", name="problem_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Frontend\FrontendBundle\Entity\Problems')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catagory entity.');
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
    * Creates a form to edit a Catagory entity.
    *
    * @param Catagory $entity The entity
    *
    * @return Form The form
    */
    private function createEditForm(Problems $entity)
    {
        $form = $this->createForm(new ProblemsType(), $entity, array(
            'action' => $this->generateUrl('problem_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Catagory entity.
     *
     * @Route("/{id}", name="problem_update")
     * @Method("PUT")
     * @Template("FrontendBundle:Problems:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Frontend\FrontendBundle\Entity\Problems')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catagory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('problem_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Catagory entity.
     *
     * @Route("/{id}", name="problem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('Frontend\FrontendBundle\Entity\Problems')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Catagory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('problem'));
    }

    /**
     * Creates a form to delete a Catagory entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('problem_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
