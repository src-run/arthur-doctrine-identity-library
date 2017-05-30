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

use SR\Doctrine\ORM\Mapping\Reflectable\ReflectionMethodSearch;
use SR\Doctrine\ORM\Mapping\Reflectable\ReflectionPropertySearch;

trait EntityCastableTrait
{
    /**
     * @return string
     */
    final public function __toString(): string
    {
        return vsprintf('%s [%s:%s]', [
            $this->getCalledClassName(),
            $this->getIdentityType(),
            $this->hasIdentity() ? $this->getIdentity() : 'null',
        ]);
    }

    /**
     * @return array
     */
    final public function __debugInfo(): array
    {
        return array_merge([
            'classRoot' => $this->getRootClassName(),
            'classParent' => $this->getParentClassName(),
            'classCalled' => $this->getCalledClassName(),
            'identityType' => $this->getIdentityType(),
            'identityValue' => $this->getIdentity(),
        ], $this->__toArray());
    }

    /**
     * @return array[]
     */
    final public function __toArray(): array
    {
        return [
            'properties' => $this->searchProperties()->find(),
            'methods' => $this->searchMethods()->find(),
        ];
    }

    /**
     * @param null|string $search
     *
     * @return ReflectionMethodSearch
     */
    abstract public function searchMethods(string $search = null);

    /**
     * @param string|null $search
     *
     * @return ReflectionPropertySearch
     */
    abstract public function searchProperties(string $search = null);
}
