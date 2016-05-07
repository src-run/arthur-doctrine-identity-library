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

use SR\Doctrine\ORM\Mapping\Entity;
use SR\Reflection\Inspect;
use SR\Reflection\Introspection\MethodIntrospection;
use SR\Reflection\Introspection\PropertyIntrospection;
use SR\Utility\StringInspect;

/**
 * Trait EntityReflectableTrait.
 */
trait EntityReflectableTrait
{
    /**
     * @param string       $search
     * @param bool         $regex
     * @param null|Entity  $entity
     * @param mixed        ...$parameters
     *
     * @return mixed[]
     */
    final protected function invokeMethodSet($search, $regex = false, Entity $entity = null, ...$parameters)
    {
        $entity = $entity ?: $this;
        $return = [];

        foreach ($this->findMethodSet($search, $regex, $entity) as $method) {
            $return[] = $method->invokeArgs($entity, $parameters);
        }

        return $return;
    }

    /**
     * @param string      $search
     * @param null|Entity $entity
     * @param mixed       ...$parameters
     *
     * @return mixed|null
     */
    final protected function invokeMethod($search, Entity $entity = null, ...$parameters)
    {
        $entity = $entity ?: $this;

        if (null === ($method = $this->findMethod($search, $entity))) {
            return null;
        }

        return $method->invokeArgs($entity, $parameters);
    }

    /**
     * @param null|string $search
     * @param bool        $regex
     * @param null|Entity $entity
     *
     * @return MethodIntrospection[]
     */
    final protected function findMethodSet($search = null, $regex = false, Entity $entity = null)
    {
        $_ = function (MethodIntrospection $m, $index) use ($search, $regex) {
            if ($regex === true) {
                return 1 === preg_match($search, $m->nameUnQualified());
            }

            return null === $search || null !== StringInspect::searchPosition($m->nameUnQualified(), $search);
        };

        return Inspect::thisInstance($entity ?: $this)->filterMethods($_, null);
    }

    /**
     * @param string      $search
     * @param null|Entity $entity
     *
     * @return null|MethodIntrospection
     */
    final protected function findMethod($search, Entity $entity = null)
    {
        $_ = function (MethodIntrospection $m, $index) use ($search) {
            return $m->nameUnQualified() === $search;
        };

        return Inspect::thisInstance($entity ?: $this)->filterOneMethod($_, null);
    }

    /**
     * @param null|string $search
     * @param bool        $regex
     * @param null|Entity $entity
     *
     * @return PropertyIntrospection[]
     */
    final protected function findPropertySet($search = null, $regex = false, Entity $entity = null)
    {
        $_ = function (PropertyIntrospection $p, $index) use ($search, $regex) {
            if ($regex === true) {
                return 1 === preg_match($search, $p->nameUnQualified());
            }

            return null === $search || null !== StringInspect::searchPosition($p->nameUnQualified(), $search);
        };

        return Inspect::thisInstance($entity ?: $this)->filterProperties($_, null);
    }

    /**
     * @param string      $search
     * @param null|Entity $entity
     *
     * @return null|PropertyIntrospection
     */
    final protected function findProperty($search, Entity $entity = null)
    {
        $_ = function (PropertyIntrospection $p, $index) use ($search) {
            return $p->nameUnQualified() === $search;
        };

        return Inspect::thisInstance($entity ?: $this)->filterOneProperty($_, null);
    }
}

/* EOF */
