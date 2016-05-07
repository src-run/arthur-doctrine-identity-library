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

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;
use SR\Doctrine\ORM\Mapping\IdEntity as BaseIdEntity;

/**
 * Class IdEntityTwo.
 */
class IdEntityTwo extends BaseIdEntity
{
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

    protected function cloneOperationsOne()
    {
        $this->aString = 'a-cloned-string';
    }

    protected function cloneOperationsTwo()
    {
        $this->anInt = -10;
    }

    public function eventPreRemoveIncrement(LifecycleEventArgs $eventArgs = null)
    {
        $this->anInt = 1;
        $this->anArray = ['event', 'post', 'load'];
    }

    public function eventPostRemoveIncrement(LifecycleEventArgs $eventArgs = null)
    {
        ++$this->anInt;
        $this->anArray = ['event', 'post', 'load'];
    }

    public function eventPrePersistIncrement(LifecycleEventArgs $eventArgs = null)
    {
        ++$this->anInt;
        $this->anArray = ['event', 'post', 'load'];
    }

    public function eventPostPersistIncrement(LifecycleEventArgs $eventArgs = null)
    {
        ++$this->anInt;
        $this->anArray = ['event', 'post', 'load'];
    }

    public function eventPreUpdateIncrement(PreUpdateEventArgs $eventArgs = null)
    {
        ++$this->anInt;
        $this->anArray = ['event', 'post', 'load'];
    }

    public function eventPostUpdateIncrement(LifecycleEventArgs $eventArgs = null)
    {
        ++$this->anInt;
        $this->anArray = ['event', 'post', 'load'];
    }

    public function eventPostLoadActionOne(LifecycleEventArgs $eventArgs = null)
    {
        ++$this->anInt;
        $this->anArray = ['event', 'post', 'load'];
    }
}

/* EOF */
