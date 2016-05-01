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

/**
 * Class EntityFixtureTrait.
 */
trait EntityFixtureTrait
{
    protected $propertyOne;

    protected $propertyTwo = ['will', 'be', 'overwrote'];

    protected $propertyThree = 'will-not-be-overwrote';

    protected function __initializePropertyOne()
    {
        $this->propertyOne = 'initial-property-one-value';
    }

    protected function __initializePropertyTwo()
    {
        $this->propertyTwo = ['an', 'initial', 'value'];
    }

    protected function badInitializeMethodNameForPropertyThree()
    {
        $this->propertyThree = 500;
    }

    public function getPropertyOne()
    {
        return $this->propertyOne;
    }

    public function getPropertyTwo()
    {
        return $this->propertyTwo;
    }

    public function getPropertyThree()
    {
        return $this->propertyThree;
    }
}

/* EOF */
