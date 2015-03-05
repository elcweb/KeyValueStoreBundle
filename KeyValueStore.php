<?php

namespace Elcweb\KeyValueStoreBundle;

use Doctrine\ORM\EntityManager;
use Elcweb\KeyValueStoreBundle\Entity\KeyValue;

class KeyValueStore
{
    /**
     *
     * @var EntityManager 
     */
    protected $em;

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Gets the value of the exact key
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        $value = $this->em->getRepository('ElcwebKeyValueStoreBundle:KeyValue')->findOneByKey($key);

        if (!$value) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * Adds a new pair of key value
     *
     * @param mixed $key
     * @param mixed $value
     * @param string $description
     */
    public function set($key, $value, $description = '')
    {
        $keyvalue = $this->em->getRepository('ElcwebKeyValueStoreBundle:KeyValue')->findOneByKey($key);

        if (!$keyvalue) {
            $keyvalue = new KeyValue;
            $keyvalue->setKey($key);
        }

        $keyvalue->setValue($value);
        $keyvalue->setDescription($description);

        $this->em->persist($keyvalue);
        $this->em->flush();
    }

    /**
     * Gets all the matching key prefixs Ex. '$key%' and returns array of postfix keys
     *
     * @param $key
     * @return array
     */
    public function getAll($key)
    {
        $qb = $this->em->createQueryBuilder();

        $result = $qb->select('u')
            ->from('ElcwebKeyValueStoreBundle:KeyValue', 'u')
            ->where($qb->expr()->like('u.key', ':key'))
            ->setParameter('key', "{$key}%")
            ->getQuery()
            ->getResult();

        $return = array();

        foreach ($result as $row) {
            $return[substr($row->getKey(), strlen($key))] = $row->getValue();
        }

        return $return;
    }
}
