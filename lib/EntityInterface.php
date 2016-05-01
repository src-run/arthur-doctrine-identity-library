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

use SR\Doctrine\ORM\Mapping\Castable\EntityCastableInterface;
use SR\Doctrine\ORM\Mapping\Copyable\EntityCopyableInterface;
use SR\Doctrine\ORM\Mapping\Introspectable\EntityIntrospectableInterface;
use SR\Doctrine\ORM\Mapping\Equatable\EntityEquatableInterface;
use SR\Doctrine\ORM\Mapping\Initializeable\EntityInitializeableInterface;
use SR\Doctrine\ORM\Mapping\Cognizant\EntityCognizantInterface;
use SR\Doctrine\ORM\Mapping\Serializable\EntitySerializableInterface;

/**
 * Interface EntityInterface.
 */
interface EntityInterface extends EntityCastableInterface, EntityCopyableInterface, EntityIntrospectableInterface,
                                  EntityEquatableInterface, EntityInitializeableInterface, EntityCognizantInterface,
                                  EntitySerializableInterface
{
    /**
     * @return string
     */
    public function getIdentityType();

    /**
     * @return bool
     */
    public function hasIdentityType();

    /**
     * @param bool $qualified
     *
     * @return string
     */
    public function getIdentityName($qualified = false);

    /**
     * @param mixed $identity
     *
     * @return $this
     */
    public function setIdentity($identity);

    /**
     * @return mixed
     */
    public function getIdentity();

    /**
     * @return bool
     */
    public function hasIdentity();
}

/* EOF */
