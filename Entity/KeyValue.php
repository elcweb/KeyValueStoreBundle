<?php

namespace Elcweb\KeyValueStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KeyValue
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class KeyValue
{
    /**
     * @var string
     *
     * @ORM\Column(name="key_name", type="string")
     * @ORM\Id
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * Set var
     *
     * @param  string  $key
     * @return KeyValue
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param  string  $value
     * @return KeyValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set description
     *
     * @param  string  $description
     * @return KeyValue
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
