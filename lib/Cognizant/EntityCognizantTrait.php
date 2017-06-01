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
use SR\Doctrine\ORM\Mapping\Reflectable\ReflectionMethodSearch;

trait EntityCognizantTrait
{
    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPreRemove(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(__FUNCTION__, $eventArgs);
    }

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPostRemove(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(__FUNCTION__, $eventArgs);
    }

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPrePersist(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(__FUNCTION__, $eventArgs);
    }

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPostPersist(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(__FUNCTION__, $eventArgs);
    }

    /**
     * @param null|PreUpdateEventArgs $eventArgs
     */
    final public function eventPreUpdate(PreUpdateEventArgs $eventArgs = null)
    {
        $this->event(__FUNCTION__, $eventArgs);
    }

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPostUpdate(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(__FUNCTION__, $eventArgs);
    }

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    final public function eventPostLoad(LifecycleEventArgs $eventArgs = null)
    {
        $this->event(__FUNCTION__, $eventArgs);
    }

    /**
     * @param string         $type
     * @param null|EventArgs $eventArgs
     */
    final private function event(string $type, EventArgs $eventArgs = null)
    {
        $this->searchMethods(sprintf('^%s[A-Za-z]+', $type))->invoke($eventArgs);
    }

    /**
     * @param null|string $search
     *
     * @return ReflectionMethodSearch
     */
    abstract public function searchMethods(string $search = null);
}
