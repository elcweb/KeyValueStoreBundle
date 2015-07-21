<?php

namespace Elcweb\KeyValueStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineEncrypt\Configuration\Encrypted;
use Elcweb\CommonBundle\Entity\BaseEntity;
use JMS\Serializer\Annotation as Serializer;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * KeyValue
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @Serializer\ExclusionPolicy("all")
 * @Gedmo\Loggable
 */
class KeyValue extends BaseEntity
{
    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "The key name should be at least 2 characters long"
     * )
     * @ORM\Column(name="key_name", type="string")
     * @ORM\Id
     *
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Encrypted
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Expose
     * @Gedmo\Versioned
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
