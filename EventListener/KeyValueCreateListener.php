<?php

namespace Elcweb\KeyValueStoreBundle\EventListener;

use Symfony\Component\EventDispatcher\GenericEvent;
use Doctrine\ORM\EntityManager;

class KeyValueCreateListener
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function onEvent(GenericEvent $event)
    {
        $model = $event->getArgument('keyValue');

        $this->em->persist($model);
        $this->em->flush();
    }
}
