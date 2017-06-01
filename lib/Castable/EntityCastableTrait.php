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
use SR\Reflection\Inspector\MethodInspector;
use SR\Reflection\Inspector\PropertyInspector;

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
            'called_class' => $this->getCalledClassName(),
            'parent_class' => $this->getParentClassName(),
            'root_class' => $this->getRootClassName(),
            'identity_typed' => $this->getIdentityType(),
            'identity_value' => $this->getIdentity(),
        ], $this->__toArray());
    }

    /**
     * @return array[]
     */
    final public function __toArray(): array
    {
        return [
            'properties' => array_map(function (PropertyInspector $property) {
                return [
                    'name' => $property->name(),
                    'value' => $property->value($this),
                    'visibility' => $property->visibility(),
                    'inspector' => $property,
                ];
            }, $this->searchProperties()->find()),
            'methods' => array_map(function (MethodInspector $method) {
                return [
                    'name' => $method->name(),
                    'visibility' => $method->visibility(),
                    'inspector' => $method,
                ];
            }, $this->searchMethods()->find()),
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
