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
 * Class IdEntityTest.
 */
class IdEntityTest extends AbstractEntityType
{
    public function testAccessors()
    {
        $this->assertNull(self::$entityInitEnabled->getId());
        $this->assertFalse(self::$entityInitEnabled->hasId());
        self::$entityInitEnabled->setId(1);
        $this->assertSame(1, self::$entityInitEnabled->getId());
        $this->assertTrue(self::$entityInitEnabled->hasId());
        self::$entityInitEnabled->clearId();
        $this->assertNull(self::$entityInitEnabled->getId());
        $this->assertFalse(self::$entityInitEnabled->hasId());
    }

    public function testFindPropertySet()
    {
        $method = Inspect::this(self::$entityInitEnabled)->getMethod('findPropertySet');
        $properties = $method->invoke(self::$entityInitEnabled, 'id');
        $this->assertCount(1, $properties);
        $this->assertSame('id', $properties[0]->name());
    }

    public function testInitializeMethods()
    {
        $className = 'SR\Doctrine\ORM\Mapping\Tests\Fixture\IdEntity';
        $instance = new $className(false);
        $this->assertNull($instance->getAString());
        $this->assertNull($instance->getAnInt());
        $this->assertNull($instance->getAnArray());
        $instance->__construct(true);
        $this->assertNotNull($instance->getAString());
        $this->assertSame('aString', $instance->getAString());
        $this->assertNotNull($instance->getAnInt());
        $this->assertNotNull($instance->getAnArray());

        $aStringProperty = Inspect::thisInstance($instance)->matchOneProperty('aString', 'nameUnQualified');
        $aStringProperty->setValue($instance, 'aStringValueSetViaReflection');

        $instance->__construct();
        $this->assertSame('aStringValueSetViaReflection', $instance->getAString());
    }
}

/* EOF */
