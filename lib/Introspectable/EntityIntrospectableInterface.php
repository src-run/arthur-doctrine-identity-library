<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Introspectable;

/**
 * Interface EntityIntrospectableInterface.
 */
interface EntityIntrospectableInterface
{
    /**
     * @param bool $qualified
     * @param bool $static
     *
     * @return string
     */
    public function getObjectName($qualified = false, $static = false);

    /**
     * @param bool        $qualified
     * @param null|object $instance
     *
     * @return string
     */
    public function getParentName($qualified = false, $instance = null);
}

/* EOF */
