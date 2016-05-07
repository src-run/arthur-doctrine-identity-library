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
            $this->invokeMethodSet('{^clone}', true);
        }
    }

    /**
     * @return bool
     */
    final public function isCloneSafe()
    {
        return $this->hasIdentity();
    }

    /**
     * @return mixed
     */
    abstract public function hasIdentity();

    /**
     * @param string      $search
     * @param bool        $regex
     * @param null|Entity $entity
     * @param mixed       ...$parameters
     *
     * @return mixed[]
     */
    abstract protected function invokeMethodSet($search, $regex = false, Entity $entity = null, ...$parameters);
}

/* EOF */
