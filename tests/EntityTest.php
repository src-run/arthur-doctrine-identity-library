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
        $class = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\EntityA';
        $instanceA = new $class();

        $serialized = $instanceA->serialize();
        $instanceA->unserialize($serialized);

        $this->assertContains('property-one', $instanceA->__toArray()['properties']);
    }

    public function testInvokeMethod()
    {
        $class = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\EntityA';
        $instance = new $class();
        $invokeMethodMethod = Inspect::thisInstance($instance)->getMethod('invokeMethod');

        $this->assertGreaterThan(1, count($instance->getPropertyThree()));
        $invokeMethodMethod->invoke($instance, 'resetPropertyThree');
        $this->assertLessThan(1, count($instance->getPropertyThree()));

        $this->assertNull($invokeMethodMethod->invoke($instance, 'abcdefg012345'));
    }

    public function testFindProperty()
    {
        $class = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\EntityA';
        $instance = new $class();
        $findPropertyMethod = Inspect::thisInstance($instance)->getMethod('findProperty');
        $property = $findPropertyMethod->invoke($instance, 'propertyThree');

        $this->assertGreaterThan(1, count($property->value($instance)));
        $property->setValue($instance, [1, 2, 3]);
        $this->assertSame([1, 2, 3], $property->value($instance));
        $this->assertSame([1, 2, 3], $instance->getPropertyThree());

        $this->assertNull($findPropertyMethod->invoke($instance, 'abcdefg012345'));
    }

    public function testFindPropertySet()
    {
        $class = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\EntityA';
        $instance = new $class();
        $findPropertySetMethod = Inspect::thisInstance($instance)->getMethod('findPropertySet');
        $properties = $findPropertySetMethod->invoke($instance, '{^property}', true);

        $this->assertCount(3, $properties);
    }
}

/* EOF */
