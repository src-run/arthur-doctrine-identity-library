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

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;

interface EntityCognizantInterface
{
    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function eventPreRemove(LifecycleEventArgs $eventArgs = null);

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function eventPostRemove(LifecycleEventArgs $eventArgs = null);

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function eventPrePersist(LifecycleEventArgs $eventArgs = null);

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function eventPostPersist(LifecycleEventArgs $eventArgs = null);

    /**
     * @param null|PreUpdateEventArgs $eventArgs
     */
    public function eventPreUpdate(PreUpdateEventArgs $eventArgs = null);

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function eventPostUpdate(LifecycleEventArgs $eventArgs = null);

    /**
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function eventPostLoad(LifecycleEventArgs $eventArgs = null);
}
