<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping;

use SR\Doctrine\Exception\OrmException;
use SR\Doctrine\ORM\Mapping\Castable\EntityCastableTrait;
use SR\Doctrine\ORM\Mapping\Cognizant\EntityCognizantTrait;
use SR\Doctrine\ORM\Mapping\Copyable\EntityCopyableTrait;
use SR\Doctrine\ORM\Mapping\Equatable\EntityEquatableTrait;
use SR\Doctrine\ORM\Mapping\Initializeable\EntityInitializeableTrait;
use SR\Doctrine\ORM\Mapping\Reflectable\EntityReflectableTrait;
use SR\Doctrine\ORM\Mapping\Serializable\EntitySerializableTrait;

/**
 * Class Entity.
 */
abstract class Entity implements EntityInterface
{
    use EntityCastableTrait;
    use EntityCognizantTrait;
    use EntityCopyableTrait;
    use EntityEquatableTrait;
    use EntityInitializeableTrait;
    use EntityReflectableTrait;
    use EntitySerializableTrait;

    /**
     * @param bool $initialize
     */
    public function __construct($initialize = true)
    {
        if ($initialize) {
            $this->invokeMatching($this, 'doInitialize');
        }
    }

    /**
     * @return string
     */
    final public function getIdentityType()
    {
        $type = $this->getIdentityName();

        return strtolower(substr($type, 0, strlen($type) - 6));
    }

    /**
     * @return bool
     */
    final public function hasIdentityType()
    {
        $type = $this->getIdentityType();

        return strlen($type) > 0 && property_exists($this, $type);
    }

    /**
     * @param bool $qualified
     *
     * @return string
     */
    final public function getIdentityName($qualified = false)
    {
        return $this->getObjectName($qualified, false);
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
            throw $this->exception(OrmException::create('ORM identity setter error'));
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
            throw $this->exception(OrmException::create('ORM identity getter error'));
        }

        return $this->{$this->getIdentityType()};
    }

    /**
     * @return bool
     */
    final public function hasIdentity()
    {
        try {
            return $this->getIdentity() !== null;
        } catch (OrmException $exception) {
            return false;
        }
    }

    /**
     * @param OrmException $exception
     *
     * @return OrmException
     */
    final protected function exception(OrmException $exception)
    {
        $type = $this->hasIdentityType() ? $this->getIdentityType() : 'null';
        $identity = $this->hasIdentityType() ? $this->getIdentity() : 'null';

        return OrmException::create()
            ->setMessage('ORM entity "%s[%s:%s]" exception: %s')
            ->with($exception, $this->getObjectName(true), $type, $identity, $exception->getMessage());
    }
}

/* EOF */
