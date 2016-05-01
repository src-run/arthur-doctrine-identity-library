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

use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Exception\UnsupportedOperationException;
use Ramsey\Uuid\Uuid;
use SR\Doctrine\ORM\Mapping\Introspectable\EntityIntrospectableTrait;

/**
 * Class UuidEntity.
 */
class UuidEntity extends Entity
{
    use EntityIntrospectableTrait;

    /**
     * @var null|Uuid
     */
    protected $uuid;

    /**
     * @param null|string $uuid
     *
     * @return $this
     */
    public function setUuid($uuid = null)
    {
        try {
            $this->uuid = $uuid instanceof Uuid ?
                $uuid : Uuid::fromString($uuid);
        } catch (\InvalidArgumentException $e) {
            $this->uuid = Uuid::uuid1();
        }

        return $this;
    }

    /**
     * @return null|Uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return null|string
     */
    public function getUuidString()
    {
        return $this->uuid ? $this->uuid->toString() : null;
    }

    /**
     * @return null|int
     */
    public function getUuidBytes()
    {
        return $this->uuid ? $this->uuid->getBytes() : null;
    }

    /**
     * @return bool
     */
    public function hasUuid()
    {
        return $this->uuid instanceof Uuid;
    }

    /**
     * @return $this
     */
    public function clearUuid()
    {
        $this->uuid = null;

        return $this;
    }
}

/* EOF */
