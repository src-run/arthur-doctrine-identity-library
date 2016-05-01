<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Tests\Fixture;

use SR\Doctrine\ORM\Mapping\IdEntity as BaseIdEntity;

/**
 * Class EntityB.
 */
class EntityB extends BaseIdEntity
{
    /**
     * @var string
     */
    protected $propertyOne = 'property-one';

    /**
     * @var int
     */
    protected $propertyTwo = 1000;

    /**
     * @var array
     */
    protected $propertyThree = ['property', 'three'];
}

/* EOF */
