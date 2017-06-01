<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Reflectable;

use SR\Reflection\Inspect;
use SR\Reflection\Inspector\PropertyInspector;

final class ReflectionPropertySearch extends AbstractReflectionSearch
{
    /**
     * @return PropertyInspector[]
     */
    public function find(): array
    {
        return Inspect::useInstance($this->entity)->filterProperties(function (PropertyInspector $property) {
            return $this->isMatch($property) || null === $this->search;
        }, null);
    }

    /**
     * @return null|PropertyInspector
     */
    public function findOne(): ?PropertyInspector
    {
        return Inspect::using($this->entity)->filterOneProperty(function (PropertyInspector $property) {
            return $this->isMatch($property);
        }, null);
    }
}
