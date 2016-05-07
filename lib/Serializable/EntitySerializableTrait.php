<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Serializable;

use SR\Doctrine\ORM\Mapping\Entity;
use SR\Reflection\Inspect;
use SR\Reflection\Introspection\PropertyIntrospection;
use SR\Serializer\Serializer;

/**
 * Trait EntitySerializableTrait.
 */
trait EntitySerializableTrait
{
    /**
     * @return string
     */
    public function serialize()
    {
        $properties = [];

        foreach ($this->findPropertySet() as $property) {
            if (!in_array($property->name(), $this->getSerializableProperties())) {
                $property->setValue($this, null);
                continue;
            }

            $properties[$property->name()] = $property->value($this);
        }

        return Serializer::create(Serializer::TYPE_IGBINARY)->serialize($properties);
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $properties = (array) Serializer::create(Serializer::TYPE_IGBINARY)->unserialize($data);

        foreach ($properties as $name => $value) {
            Inspect::this($this)->getProperty($name)->setValue($this, $value);
        }
    }

    /**
     * @return string[]
     */
    protected function getSerializableProperties()
    {
        return $this->hasIdentityType() ? [$this->getIdentityType()] : [];
    }

    /**
     * @return string
     */
    abstract public function getIdentityType();

    /**
     * @return bool
     */
    abstract public function hasIdentityType();

    /**
     * @param null|string $search
     * @param bool        $regex
     * @param null|Entity $entity
     *
     * @return PropertyIntrospection[]
     */
    abstract protected function findPropertySet($search = null, $regex = false, Entity $entity = null);
}

/* EOF */
