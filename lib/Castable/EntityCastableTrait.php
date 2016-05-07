<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Castable;

use SR\Doctrine\ORM\Mapping\Entity;
use SR\Reflection\Introspection\MethodIntrospection;
use SR\Reflection\Introspection\PropertyIntrospection;

/**
 * Trait EntityCastableTrait.
 */
trait EntityCastableTrait
{
    /**
     * @return string
     */
    final public function __toString()
    {
        $identity = $this->hasIdentity() ? $this->getIdentity() : 'null';

        return sprintf('%s [%s:%s]', $this->getObjectName(), $this->getIdentityType(), $identity);
    }

    /**
     * @return array
     */
    final public function __debugInfo()
    {
        return array_merge([
            'classNameSelf' => $this->getObjectName(true, true),
            'classNameParent' => $this->getParentName(true, $this),
            'identityType' => $this->getIdentityType(),
            'identityValue' => $this->getIdentity(),
        ], $this->__toArray());
    }

    /**
     * @return array[]
     */
    final public function __toArray()
    {
        $properties = [];
        $methods = [];

        foreach ($this->findPropertySet() as $p) {
            $properties[$p->nameUnQualified()] = $p->value($this);
        }

        foreach ($this->findMethodSet() as $m) {
            $methods[] = $m->nameUnQualified();
        }

        return [
            'properties' => $properties,
            'methods' => $methods,
        ];
    }

    /**
     * @return mixed
     */
    abstract public function getIdentity();

    /**
     * @return bool
     */
    abstract public function hasIdentity();

    /**
     * @return string
     */
    abstract public function getIdentityType();

    /**
     * @param bool $qualified
     * @param bool $static
     *
     * @return string
     */
    abstract public function getObjectName($qualified = false, $static = false);

    /**
     * @param bool        $qualified
     * @param null|object $instance
     *
     * @return string
     */
    abstract public function getParentName($qualified = false, $instance = null);

    /**
     * @param null|string $search
     * @param bool        $regex
     * @param null|Entity $entity
     *
     * @return MethodIntrospection[]
     */
    abstract protected function findMethodSet($search = null, $regex = false, Entity $entity = null);

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
