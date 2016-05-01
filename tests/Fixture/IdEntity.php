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

use SR\Doctrine\ORM\Mapping\Entity;
use SR\Doctrine\ORM\Mapping\Introspectable\EntityIntrospectableTrait;

/**
 * Class IdEntity.
 */
class IdEntity extends Entity
{
    use EntityIntrospectableTrait;

    /**
     * @var string
     */
    protected $aString;

    /**
     * @var int
     */
    protected $anInt;

    /**
     * @var array
     */
    protected $anArray;

    protected function initializeAString()
    {
        $this->aString = 'aString';
    }

    protected function initializeAnInt()
    {
        $this->anInt = 100;
    }

    protected function initializeAnArray()
    {
        $this->anArray = [
            1, 2, 3,
        ];
    }

    public function getAString()
    {
        return $this->aString;
    }

    public function getAnInt()
    {
        return $this->anInt;
    }

    public function getAnArray()
    {
        return $this->anArray;
    }

    protected function doCloneOperationsOne()
    {
        $this->aString = 'a-cloned-string';
    }

    protected function doCloneOperationsTwo()
    {
        $this->anInt = -10;
    }
}

/* EOF */
