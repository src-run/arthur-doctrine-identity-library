<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Cognizant;

use Doctrine\Common\EventArgs;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;
use SR\Reflection\Introspection\MethodIntrospection;
use SR\Utility\StringTransform;

/**
 * Trait EntityCognizantTrait.
 */
trait EntityCognizantTrait
{
    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPreRemove(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(EntityEventInterface::PRE_REMOVE, $eventArgs);
    }

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPostRemove(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(EntityEventInterface::POST_REMOVE, $eventArgs);
    }

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPrePersist(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(EntityEventInterface::PRE_PERSIST, $eventArgs);
    }

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPostPersist(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(EntityEventInterface::POST_PERSIST, $eventArgs);
    }

    /**
     * @param null|PreUpdateEventArgs $eventArgs
     */
    final public function eventPreUpdate(PreUpdateEventArgs $eventArgs = null)
    {
        $this->event(EntityEventInterface::PRE_UPDATE, $eventArgs);
    }

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPostUpdate(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(EntityEventInterface::POST_UPDATE, $eventArgs);
    }

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPostLoad(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(EntityEventInterface::POST_LOAD, $eventArgs);
    }

    /**
     * @param string         $type
     * @param EventArgs|null $eventArgs
     *
     * @return $this
     */
    final private function event($type, EventArgs $eventArgs = null)
    {
        $constant = sprintf('%s::%s', EntityEventInterface::INTERFACE_NAME,
            strtoupper(StringTransform::pascalToSnakeCase($type)));

        if (defined($constant)) {
            $eventSearch = sprintf('event%s', ucfirst(constant($constant)));
            $eventMethods = $this->findMethods($eventSearch);

            foreach ($eventMethods as $method) {
                if ($method->name() === $eventSearch) {
                    continue;
                }

                $method->invokeArgs($this, [$eventArgs]);
            }
        }

        return $this;
    }

    /**
     * @param null|string $needle
     * @param bool        $reverse
     *
     * @return MethodIntrospection[]
     */
    abstract protected function findMethods($needle = null, $reverse = false);
}

/* EOF */
