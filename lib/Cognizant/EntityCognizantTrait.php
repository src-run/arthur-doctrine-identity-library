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
use SR\Doctrine\ORM\Mapping\Entity;
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
     * @param null|EventArgs $eventArgs
     */
    final private function event($type, EventArgs $eventArgs = null)
    {
        if (null !== ($search = $this->getEventMethodSearchRegex($type))) {
            $this->invokeMethodSet($search, true, null, $eventArgs);
        }
    }

    /**
     * @param string $type
     *
     * @return null|string
     */
    final private function getEventMethodSearchRegex($type)
    {
        $constant = sprintf(
            '%s::%s',
            EntityEventInterface::INTERFACE_NAME,
            strtoupper(StringTransform::pascalToSnakeCase($type))
        );

        return defined($constant) ? sprintf('{^event%s.+}', ucfirst(constant($constant))) : null;
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
