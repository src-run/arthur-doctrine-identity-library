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

use SR\Doctrine\ORM\Mapping\Reflectable\ReflectionMethodSearch;

trait EntityInitializeableTrait
{
    /**
     * @var bool
     */
    private $isInitialized = false;

    /**
     * @param bool $forceInitialization
     */
    final protected function doInitialization(bool $forceInitialization = false)
    {
        if ($this->isInitialized === false || $forceInitialization === true) {
            $this->isInitialized = true;
            $this->searchMethods('initialize')->invoke();
        }
    }

    /**
     * @param null|string $search
     *
     * @return ReflectionMethodSearch
     */
    abstract public function searchMethods(string $search = null);
}
