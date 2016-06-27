<?php

namespace Elcweb\KeyValueStoreBundle\Controller;

use Elcweb\KeyValueStoreBundle\Entity\KeyValue;
use Elcweb\KeyValueStoreBundle\Form\KeyValueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class DefaultController
 * @package Elcweb\KeyValueStoreBundle\Controller
 *
 * @Route("/admin/keyvalue")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Show soft deleted users
        $filters = $em->getFilters();
        $filters->disable('softdeleteable');

        $items = $em->getRepository('ElcwebKeyValueStoreBundle:KeyValue')->findAll();

        return ['items' => $items];
    }

    /**
     * @Route("/create")
     * @Template()
     *
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $keyValue = new KeyValue();

        $form = $this->createForm(
            KeyValueType::class,
            $keyValue,
            ['action' => $this->generateUrl('elcweb_keyvaluestore_default_create')]
        );
        $result = $this->processForm($form, $request);

        if ($result) {
            return $this->redirectToRoute('elcweb_keyvaluestore_default_index');
        }

        return ['form' => $form->createView(), 'actionName' => 'Create'];
    }

    /**
     * @Route("/edit/{key}")
     * @Template("ElcwebKeyValueStoreBundle:Default:create.html.twig")
     *
     * @param Request  $request
     * @param KeyValue $keyValue
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, KeyValue $keyValue)
    {
        $form = $this->createForm(
            KeyValueType::class,
            $keyValue,
            ['action' => $this->generateUrl('elcweb_keyvaluestore_default_edit', ['key' => $keyValue->getKey()])]
        );
        $result = $this->processForm($form, $request);

        if ($result) {
            return $this->redirectToRoute('elcweb_keyvaluestore_default_index');
        }

        return ['form' => $form->createView(), 'actionName' => 'Edit'];
    }

    /**
     * @param Form    $form
     * @param Request $request
     *
     * @return bool
     */
    private function processForm(Form $form, Request $request)
    {
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $keyValue = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($keyValue);
                $entityManager->flush();

                $this->addFlash('success', 'Saved.');

                return true;
            }
        }

        return false;
    }

    /**
     * @Route("/delete/{key}")
     *
     * @param KeyValue $key
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(KeyValue $key)
    {
        $this->addFlash('success', "Key {$key->getKey()} was removed");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($key);
        $entityManager->flush();

        return $this->redirectToRoute('elcweb_keyvaluestore_default_index');
    }

}

