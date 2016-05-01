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
        return ['properties' => get_object_vars($this), 'methods' => get_class_methods($this)];
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
}

/* EOF */
