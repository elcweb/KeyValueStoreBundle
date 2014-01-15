<?php

namespace Elcweb\KeyValueStoreBundle\Controller;

use Elcweb\KeyValueStoreBundle\Entity\KeyValue;
use Elcweb\KeyValueStoreBundle\Form\KeyValueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/keyvalue")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Show soft deleted users
        $filters = $em->getFilters();
        $filters->disable('softdeleteable');

        $items = $em->getRepository('ElcwebKeyValueStoreBundle:KeyValue')->findAll();

        return array('items' => $items);
    }

    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $model = new KeyValue();
        $form  = $this->createForm(new KeyValueType(), $model);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($model);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Saved.');

                return $this->redirect($this->generateUrl('elcweb_keyvaluestore_default_index'));
            }
        }

        return array('form' => $form->createView(), 'actionName' => 'Create');
    }

    /**
     * @Route("/edit/{key}")
     * @Template("ElcwebKeyValueStoreBundle:Default:create.html.twig")
     */
    public function editAction($key, Request $request)
    {
        $em    = $this->getDoctrine()->getManager();
        $model = $em->getRepository('ElcwebKeyValueStoreBundle:KeyValue')->findOneBy(array('key' => $key));

        if (!$model) {
            throw $this->createNotFoundException('No value found for key ' . $key);
        }

        $form = $this->createForm(new KeyValueType(), $model);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($model);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Saved.');

                return $this->redirect($this->generateUrl('elcweb_keyvaluestore_default_index'));
            }
        }

        return array('form' => $form->createView(), 'actionName' => 'Edit');
    }

    /**
     * @Route("/delete/{key}")
     */
    public function deleteAction($key)
    {
        // TODO: soft delete
        $this->get('session')->getFlashBag()->add('error', "Function not implemented. Can't delete {$key}");

        return $this->redirect($this->generateUrl('elcweb_keyvaluestore_default_index'));
    }

}

