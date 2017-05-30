<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Tests;

use SR\Doctrine\ORM\Mapping\EntityInterface;
use SR\Doctrine\ORM\Mapping\Reflectable\ReflectionMethodSearch;
use SR\Doctrine\ORM\Mapping\Reflectable\ReflectionPropertySearch;
use SR\Doctrine\ORM\Mapping\Tests\Fixture\EntityA;
use SR\Reflection\Inspect;

/**
 * Class EntityTest.
 */
class EntityTest extends AbstractEntityType
{
    public function setUp()
    {
        self::$testClassName = get_class($this);
        self::$classType = 'Id';
        self::$className = sprintf('SR\Doctrine\ORM\Mapping\%sEntity', self::$classType);

        $this->setUpEntityInstances(self::$className);
        $this->setUpEntityAccessorMethods();
    }

    public function testCastableToString()
    {
        $this->assertRegExp('{IdEntity \[id:null\]}', self::$entityInitEnabled->__toString());
        self::$entityInitEnabled->setIdentity($identity = mt_rand(1000, 9999));
        $this->assertRegExp('{IdEntity \[id:'.preg_quote($identity).'\]}', self::$entityInitEnabled->__toString());
        self::$entityInitEnabled->setIdentity(null);
    }

    public function testCastableToArray()
    {
        $array = self::$entityInitEnabled->__toArray();
        $this->assertGreaterThan(0, $array['properties']);
        $this->assertGreaterThan(0, $array['methods']);
    }

    public function testCastableDebugInfo()
    {
        $debug = self::$entityInitEnabled->__debugInfo();
        $identity = mt_rand(1000, 9999);
        $this->assertContains('SR\Doctrine\ORM\Mapping\IdEntity', $debug);
        $this->assertContains('SR\Doctrine\ORM\Mapping\Entity', $debug);
        $this->assertContains('id', $debug);
        $this->assertNotContains($identity, $debug);

        self::$entityInitEnabled->setIdentity($identity);
        $this->assertContains($identity, self::$entityInitEnabled->__debugInfo());
    }

    public function testIdentitySetInvalidType()
    {
        $className = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\IdEntity';
        $instance = new $className();
        $this->assertFalse($instance->hasIdentityType());
        $this->assertFalse($instance->hasIdentity());

        $this->expectException('SR\Doctrine\Exception\OrmException');
        $instance->setIdentity(1);
    }

    public function testIdentityGetInvalidType()
    {
        $className = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\IdEntity';
        $instance = new $className();
        $this->assertFalse($instance->hasIdentityType());
        $this->assertFalse($instance->hasIdentity());

        $this->expectException('SR\Doctrine\Exception\OrmException');
        $instance->getIdentity();
    }

    public function testClonable()
    {
        $className = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\IdEntityTwo';
        $instance = new $className();
        $this->assertFalse($instance->isCloneSafe());
        $instance->setIdentity(1);
        $this->assertTrue($instance->isCloneSafe());

        $this->assertNotSame('a-cloned-string', $instance->getAString());
        $this->assertNotSame(-10, $instance->getAnInt());
        $instanceClone = clone $instance;
        $this->assertSame('a-cloned-string', $instanceClone->getAString());
        $this->assertSame(-10, $instanceClone->getAnInt());
    }

    public function testEvent()
    {
        $className = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\IdEntityTwo';
        $instance = new $className();
        $this->assertNotSame(['event', 'post', 'load'], $instance->getAnArray());

        $envArgs = $this->getMockBuilder('\Doctrine\Common\Persistence\Event\LifecycleEventArgs')
            ->disableOriginalConstructor()
            ->getMock();

        $preUpdateEventArgs = $this->getMockBuilder('Doctrine\Common\Persistence\Event\PreUpdateEventArgs')
            ->disableOriginalConstructor()
            ->getMock();

        $i = 1;
        foreach (['eventPreRemove', 'eventPostRemove', 'eventPrePersist', 'eventPostPersist', 'eventPreUpdate', 'eventPostUpdate', 'eventPostLoad'] as $event) {
            if ($event === 'eventPreUpdate') {
                $instance->{$event}($preUpdateEventArgs);
            } else {
                $instance->{$event}($envArgs);
            }
            $this->assertSame($i++, $instance->getAnInt());
        }

        $this->assertSame(['event', 'post', 'load'], $instance->getAnArray());
    }

    public function testEquitable()
    {
        $classA = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\EntityA';
        $classB = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\EntityB';
        $classC = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\EntityC';

        $instanceA = new $classA();
        $instanceB = new $classB();
        $instanceC = new $classC();

        $this->assertTrue($instanceA->isEqualTo($instanceB));
        $this->assertFalse($instanceA->isEqualTo($instanceC));

        $instanceB->setIdentity(500);

        $this->assertFalse($instanceA->isEqualToIdentity($instanceC));
        $this->assertFalse($instanceA->isEqualToIdentity($instanceB));

        $instanceA->setIdentity(500);

        $this->assertFalse($instanceA->isEqualToIdentity($instanceC));
        $this->assertTrue($instanceA->isEqualToIdentity($instanceB));
    }

    public function testSerializable()
    {
        $instanceA = new EntityA();
        $instanceA->setPropertyOne('a new value for property one');

        $instanceB = new EntityA();
        $instanceB->unserialize($instanceA->serialize());

        $this->assertTrue($instanceA->isEqualTo($instanceB));
    }

    public function testInvokeMethod()
    {
        $instance = new EntityA();

        $this->assertGreaterThan(1, count($instance->getPropertyThree()));
        $this->searchMethodsFor($instance, 'resetPropertyThree')->invoke();
        $this->assertLessThan(1, count($instance->getPropertyThree()));

        $this->assertEmpty($this->searchMethodsFor($instance, 'abcdefg012345')->find());
        $this->assertNull($this->searchMethodsFor($instance, 'abcdefg012345')->findOne());
    }

    /**
     * @param EntityInterface $entity
     * @param string          $search
     *
     * @return ReflectionMethodSearch
     */
    private function searchMethodsFor(EntityInterface $entity, string $search = null)
    {
        return Inspect::useInstance($entity)->getMethod('searchMethods')->invoke($entity, $search);
    }

    public function testFindProperty()
    {
        $instance = new EntityA();
        $property = $this->searchPropertiesFor($instance, 'propertyThree')->findOne();

        $this->assertGreaterThan(1, count($property->value($instance)));
        $property->setValue($instance, [1, 2, 3]);
        $this->assertSame([1, 2, 3], $property->value($instance));
        $this->assertSame([1, 2, 3], $instance->getPropertyThree());
    }

    public function testFindPropertySet()
    {
        $instance = new EntityA();
        $properties = $this->searchPropertiesFor($instance, '{^property}')->find();

        $this->assertCount(3, $properties);
    }

    /**
     * @param EntityInterface $entity
     * @param string          $search
     *
     * @return ReflectionPropertySearch
     */
    private function searchPropertiesFor(EntityInterface $entity, string $search = null)
    {
        return Inspect::useInstance($entity)->getMethod('searchProperties')->invoke($entity, $search);
    }
}

/* EOF */
