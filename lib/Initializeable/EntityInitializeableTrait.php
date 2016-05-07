<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Initializeable;

use SR\Doctrine\ORM\Mapping\Entity;
use SR\Reflection\Introspection\MethodIntrospection;

/**
 * Trait EntityInitializeableTrait.
 */
trait EntityInitializeableTrait
{
    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * @param bool $forceInitialize
     */
    final protected function doInitialize($forceInitialize = false)
    {
        if ($this->initialized === false || $forceInitialize === true) {
            $this->initialized = true;
            $this->invokeMethodSet('initialize');
        }
    }

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
