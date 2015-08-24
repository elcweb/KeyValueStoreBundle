<?php

namespace Elcweb\KeyValueStoreBundle\Tests\Functional\Entity;

use Elcweb\KeyValueStoreBundle\Entity\KeyValue;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KeyValueTest extends WebTestCase
{

    /** @var Symfony\Component\DependencyInjection\Container */
    private $container;

    /** @var  Doctrine\ORM\EntityManager */
    private $entityManager;

    /**
     *
     */
    protected function setUp()
    {
        require_once __DIR__.'/../../AppKernel.php';

        $kernel = new \AppKernel('test', true);
        $kernel->boot();
        $this->container = $kernel->getContainer();
        $this->entityManager = $this->container->get('doctrine.orm.default_entity_manager');
    }

    /**
     *
     */
    public function testSetGetValue()
    {
        $expected = 'foo.bar';
        $keyValue = new KeyValue();
        $keyValue->setValue('foo.bar');

        $this->assertSame($expected, $keyValue->getValue());
    }

    /**
     *
     */
    public function testValueEncryptOnSave()
    {
        $expected = '3WwpzS5nGs/f91DyIHNNQ6BUNgwMKHPPCgBn9yFWr+E=';
        $key = 'foo';
        $value = 'bar';

        $keyValue = new KeyValue();
        $keyValue->setKey($key)->setValue($value);

        $this->entityManager->persist($keyValue);
        $this->entityManager->flush();

        $this->assertSame($expected, $this->sqlFindOne($key)['value']);
        $this->assertSame($value, $keyValue->getValue());
    }

    /**
     *
     */
    public function testValueDecryptOnReadFromDatabase()
    {
        $expected = 'bar';
        $key = 'foo';
        $value = '3WwpzS5nGs/f91DyIHNNQ6BUNgwMKHPPCgBn9yFWr+E=';

        $keyValue = $this->entityManager->getRepository('ElcwebKeyValueStoreBundle:KeyValue')->find($key);

        $this->assertSame($value, $this->sqlFindOne($key)['value']);
        $this->assertSame($expected, $keyValue->getValue());
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    private function sqlFindOne($key)
    {
        $sql = 'SELECT * FROM KeyValue WHERE `key_name` = :key LIMIT 1';
        $stmt = $this->entityManager->getConnection()->prepare($sql);
        $stmt->bindValue(':key', $key);
        $stmt->execute();

        return $stmt->fetchAll()[0];
    }
}
