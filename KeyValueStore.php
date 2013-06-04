<?php

namespace Elcweb\KeyValueStoreBundle;

use Doctrine\ORM\EntityManager;
use Elcweb\KeyValueStoreBundle\Entity\KeyValue;

class KeyValueStore
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function get($key)
    {
        $value = $this->em->getRepository('ElcwebKeyValueStoreBundle:KeyValue')->findOneByKey($key);

        if (!$value) {
            return false;
        }

        return $value->getValue();
    }

    public function set($key, $value)
    {
        $keyvalue = $this->em->getRepository('ElcwebKeyValueStoreBundle:KeyValue')->findOneByKey($key);

        if (!$keyvalue) {
            $keyvalue = new KeyValue;
            $keyvalue->setKey($key);
        }

        $keyvalue->setValue($value);

        $this->em->persist($keyvalue);
        $this->em->flush();
    }
}
