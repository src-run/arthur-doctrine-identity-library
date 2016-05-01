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

/**
 * Interface EntityEventInterface.
 */
interface EntityEventInterface
{
    /**
     * @var string
     */
    const INTERFACE_NAME = __CLASS__;

    /**
     * @var string
     */
    const PRE_PERSIST = 'PrePersist';

    /**
     * @var string
     */
    const POST_PERSIST = 'PostPersist';

    /**
     * @var string
     */
    const PRE_REMOVE = 'PreRemove';

    /**
     * @var string
     */
    const POST_REMOVE = 'PostRemove';

    /**
     * @var string
     */
    const PRE_UPDATE = 'PreUpdate';

    /**
     * @var string
     */
    const POST_UPDATE = 'PostUpdate';

    /**
     * @var string
     */
    const POST_LOAD = 'PostLoad';
}

/* EOF */
