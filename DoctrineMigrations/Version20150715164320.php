<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Version20150715164320
 * @package Application\Migrations
 */
class Version20150715164320 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * Symfony Container
     * @var ContainerInterface
     */
    private $_container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->_container = $container;
    }

    /**
     * @param \Doctrine\DBAL\Schema\Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema)
    {
        $secretLength = strlen($this->_container->getParameter('secret'));
        $this->abortIf(($secretLength != 32), 'The parameter "secret" should have 32 characters.');

        $encryptor = $this->_container->get('elcweb_doctrine_encrypt.encryptor');

        foreach ($this->findAll() as $key => $value) {
            $encryptedValue = $encryptor->encrypt($value);
            $this->addSql("UPDATE KeyValue SET `value` = '$encryptedValue' WHERE `key_name` = '$key' LIMIT 1;");
        }
    }

    /**
     * @param \Doctrine\DBAL\Schema\Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema)
    {
        $encryptor = $this->_container->get('elcweb_doctrine_encrypt.encryptor');

        foreach ($this->findAll() as $key => $value) {
            $decryptedValue = $encryptor->decrypt($value);
            $this->addSql("UPDATE KeyValue SET `value` = '$decryptedValue' WHERE `key_name` = '$key' LIMIT 1;");
        }
    }

    /**
     * @return array
     */
    private function findAll()
    {
        $sql = 'SELECT key_name,value FROM `KeyValue`;';
        $data = [];
        foreach ($this->connection->fetchAll($sql) as $row) {
            $data[$row['key_name']] = $row['value'];
        }

        return $data;
    }
}