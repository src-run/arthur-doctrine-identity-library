<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Serializable;

use SR\Doctrine\ORM\Mapping\Reflectable\ReflectionPropertySearch;
use SR\Reflection\Inspect;
use SR\Reflection\Inspector\PropertyInspector;
use SR\Serializer\Serializer;

trait EntitySerializableTrait
{
    /**
     * @return string
     */
    public function serialize(): string
    {
        return Serializer::create(Serializer::TYPE_IGBINARY)->serialize(array_map(function (PropertyInspector $p) {
            return ['n' => $p->nameUnQualified(), 'v' => $p->value($this)];
        }, array_filter($this->searchProperties()->find(), function (PropertyInspector $p) {
            return in_array($p->nameUnQualified(), $this->getSerializableProperties());
        })));
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $inspector = Inspect::useInstance($this);

        foreach ((array) Serializer::create(Serializer::TYPE_IGBINARY)->unserialize($data) as $p) {
            $inspector->getProperty($p['n'])->setValue($this, $p['v']);
        }
    }

    /**
     * @return string[]
     */
    public function getSerializableProperties(): array
    {
        return $this->hasIdentityType() ? [$this->getIdentityType()] : [];
    }

    /**
     * @param null|string $search
     *
     * @return ReflectionPropertySearch
     */
    abstract public function searchProperties(string $search = null);
}
