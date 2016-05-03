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
        $normalized = [];
        $serializable = $this->getSerializableProperties();

        foreach ($this->findProperties() as $p) {
            if (!in_array($p->name(), $serializable)) {
                $p->setValue($this, null);
                continue;
            }

            $normalized[$p->name()] = $p->value($this);
        }

        return Serializer::create(Serializer::TYPE_IGBINARY)->serialize($normalized);
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $properties = Serializer::create(Serializer::TYPE_IGBINARY)->unserialize($data);

        foreach ($properties as $name => $value) {
            $p = Inspect::this($this)->getProperty($name);
            $p->setValue($this, $value);
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
     * @param null|string $needle
     * @param bool        $reverse
     *
     * @return PropertyIntrospection[]
     */
    abstract protected function findProperties($needle = null, $reverse = false);
}

/* EOF */
