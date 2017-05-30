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
use SR\Reflection\Inspector\MethodInspector;

final class ReflectionMethodSearch extends ReflectionSearch
{
    /**
     * @param mixed ...$parameters
     *
     * @return mixed[]
     */
    public function invoke(...$parameters): array
    {
        return array_map(function (MethodInspector $m) use ($parameters) {
            return $m->invokeArgs($this->entity, $parameters);
        }, $this->find());
    }

    /**
     * @return MethodInspector[]
     */
    public function find(): array
    {
        return Inspect::useInstance($this->entity)->filterMethods(function (MethodInspector $method) {
            return $this->isMatch($method) || null === $this->search;
        }, null);
    }

    /**
     * @return null|MethodInspector
     */
    public function findOne(): ?MethodInspector
    {
        return Inspect::useInstance($this->entity)->filterOneMethod(function (MethodInspector $method) {
            return $this->isMatch($method);
        }, null);
    }
}
