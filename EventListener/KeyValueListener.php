<?php

namespace Elcweb\KeyValueStoreBundle\EventListener;

use Symfony\Component\EventDispatcher\GenericEvent;
use Doctrine\ORM\EntityManager;
use Elcweb\KeyValueStoreBundle\KeyValueStore;

class KeyValueListener
{

    public function __construct(KeyValueStore $kv)
    {
        $this->kv = $kv;
    }


    public function onEvent(GenericEvent $event)
    {
        $model = $event->getArgument('keyValue');

        $this->kv->set($model->getKey(), $model->getValue(), $model->getDescription());
    }
}
