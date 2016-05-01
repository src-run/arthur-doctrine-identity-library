<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Copyable;

use SR\Doctrine\ORM\Mapping\Entity;

/**
 * Trait EntityCopyableTrait.
 */
trait EntityCopyableTrait
{
    public function __clone()
    {
        if ($this->isCloneSafe()) {
            $this->invokeMatching($this, 'doClone');
        }
    }

    /**
     * @return bool
     */
    final public function isCloneSafe()
    {
        return (bool) $this->hasIdentity();
    }

    /**
     * @return mixed
     */
    abstract public function hasIdentity();

    /**
     * @param Entity       $entity
     * @param string       $search
     * @param {...mixed[]} $parameters
     *
     * @return mixed[]
     */
    abstract protected function invokeMatching(Entity $entity, $search, ...$parameters);
}

/* EOF */
