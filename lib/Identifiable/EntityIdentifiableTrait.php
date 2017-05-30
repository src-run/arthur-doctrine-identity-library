<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Identifiable;

use SR\Doctrine\Exception\OrmException;

trait EntityIdentifiableTrait
{
    /**
     * @param bool $qualified
     *
     * @return string
     */
    final public function getIdentityName(bool $qualified = false): string
    {
        return $this->getRootClassName($qualified);
    }

    /**
     * @param mixed $identity
     *
     * @throws OrmException
     *
     * @return $this
     */
    final public function setIdentity($identity)
    {
        if (!$this->hasIdentityType()) {
            throw new OrmException('Cannot set identity when entity has no identity type.');
        }

        $this->{$this->getIdentityType()} = $identity;

        return $this;
    }

    /**
     * @throws OrmException
     *
     * @return mixed
     */
    final public function getIdentity()
    {
        if (!$this->hasIdentityType()) {
            throw new OrmException('Cannot get identity when entity has no identity type.');
        }

        return $this->{$this->getIdentityType()};
    }

    /**
     * @return bool
     */
    final public function hasIdentity(): bool
    {
        try {
            return $this->getIdentity() !== null;
        } catch (OrmException $exception) {
            return false;
        }
    }

    /**
     * @return string
     */
    final public function getIdentityType(): string
    {
        $type = $this->getIdentityName();

        return strtolower(substr($type, 0, strlen($type) - 6));
    }

    /**
     * @return bool
     */
    final public function hasIdentityType(): bool
    {
        $type = $this->getIdentityType();

        return strlen($type) > 0 && property_exists($this, $type);
    }
}
