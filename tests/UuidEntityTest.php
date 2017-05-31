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

use Ramsey\Uuid\Uuid;

/**
 * Class UuidEntityTest.
 */
class UuidEntityTest extends AbstractEntityTest
{
    public function testAccessors()
    {
        $this->assertNull(self::$entityInitEnabled->getUuid());
        $this->assertFalse(self::$entityInitEnabled->hasUuid());

        $uuid = Uuid::uuid1();
        self::$entityInitEnabled->setUuid($uuid);
        $this->assertSame($uuid, self::$entityInitEnabled->getUuid());
        $this->assertTrue(self::$entityInitEnabled->hasUuid());

        self::$entityInitEnabled->clearUuid();
        $this->assertNull(self::$entityInitEnabled->getUuid());
        $this->assertFalse(self::$entityInitEnabled->hasUuid());

        $uuidString = Uuid::uuid1()->toString();
        self::$entityInitEnabled->setUuid($uuidString);
        $this->assertEquals($uuidString, self::$entityInitEnabled->getUuidString());
        $this->assertEquals(Uuid::fromString($uuidString), self::$entityInitEnabled->getUuid());
        $this->assertEquals(Uuid::fromString($uuidString)->getBytes(), self::$entityInitEnabled->getUuidBytes());
        $this->assertTrue(self::$entityInitEnabled->hasUuid());

        self::$entityInitEnabled->clearUuid();
        $this->assertNull(self::$entityInitEnabled->getUuid());
        $this->assertFalse(self::$entityInitEnabled->hasUuid());

        $uuidString = 'abcdefghijklmnopqrstuvwxyz0123456789';
        self::$entityInitEnabled->setUuid($uuidString);
        $this->assertNotEquals($uuidString, self::$entityInitEnabled->getUuidString());
    }
}

/* EOF */
