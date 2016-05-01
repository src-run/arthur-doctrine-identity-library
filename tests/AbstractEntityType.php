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

use SR\Doctrine\ORM\Mapping\Tests\Fixture\IdEntityFixture;
use SR\Doctrine\ORM\Mapping\Tests\Fixture\SlugEntityFixture;
use SR\Doctrine\ORM\Mapping\Tests\Fixture\UuidEntityFixture;

/**
 * Class AbstractEntityType.
 */
class AbstractEntityType extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected static $testClassName;

    /**
     * @var string
     */
    protected static $className;

    /**
     * @var string
     */
    protected static $classType;

    /**
     * @var string
     */
    protected static $identityMethodGetter;

    /**
     * @var string
     */
    protected static $identityMethodSetter;

    /**
     * @var string
     */
    protected static $identityMethodExists;

    /**
     * @var string
     */
    protected static $identityMethodRemove;

    /**
     * @var IdEntityFixture|SlugEntityFixture|UuidEntityFixture
     */
    protected static $entityInitEnabled;

    /**
     * @var IdEntityFixture|SlugEntityFixture|UuidEntityFixture
     */
    protected static $entityInitDisabled;

    public function setUpGetEntityTypeFromTestClassName()
    {
        self::$testClassName = get_class($this);
        self::$classType = preg_replace(
            '{.+\\\}',
            '',
            substr(self::$testClassName, 0, strlen(self::$testClassName) - 10)
        );
        self::$className = sprintf('SR\Doctrine\ORM\Mapping\%sEntity', self::$classType);

        return [self::$className, self::$classType];
    }

    public function setUpEntityInstances($name)
    {
        static::$entityInitEnabled = new $name();
        static::$entityInitDisabled = new $name(false);

        return [static::$entityInitEnabled, static::$entityInitDisabled];
    }

    public function setUpEntityAccessorMethods()
    {
        static::$identityMethodGetter = 'get'.ucfirst(static::$classType);
        static::$identityMethodSetter = 'set'.ucfirst(static::$classType);
        static::$identityMethodExists = 'has'.ucfirst(static::$classType);
        static::$identityMethodRemove = 'clear'.ucfirst(static::$classType);
    }

    /**
     * @param string $type
     * @param array ...$methods
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getMockEntity($type = 'id', ...$methods)
    {
        $className = sprintf('SR\Doctrine\ORM\Mapping\%sEntity', ucfirst(strtolower($type)));

        return $this->getMockBuilder($className)
            ->setMethods($methods)
            ->getMock();
    }

    public function setUp()
    {
        list($name, $type) = $this->setUpGetEntityTypeFromTestClassName();
        $this->setUpEntityInstances($name);
        $this->setUpEntityAccessorMethods();
    }

    public function testEntityIdentityType()
    {
        return;
        $this->assertTrue(static::$entityInitEnabled->hasIdentityType());
        $this->assertEquals(static::$classType, static::$entityInitEnabled->getIdentityType());
    }

    public function testEntityIdentityGetterSetter()
    {
        return;
        $this->assertFalse(static::$entityInitEnabled->hasIdentity());
        $this->assertFalse(call_user_func([static::$entityInitEnabled, static::$identityMethodExists]));
        $this->assertNull(static::$entityInitEnabled->getIdentity());
        $this->assertNull(call_user_func([static::$entityInitEnabled, static::$identityMethodGetter]));
        $this->assertInstanceOf(static::$className, static::$entityInitEnabled->setIdentity('anything'));
        $this->assertNotNull(static::$entityInitEnabled->getIdentity());
        $this->assertNotNull(call_user_func([static::$entityInitEnabled, static::$identityMethodGetter]));
        $this->assertEquals('anything', static::$entityInitEnabled->getIdentity());
        $this->assertEquals('anything', call_user_func([static::$entityInitEnabled, static::$identityMethodGetter]));
        $this->assertInstanceOf(static::$className, call_user_func([static::$entityInitEnabled, static::$identityMethodSetter], 'something-else'));
        $this->assertNotNull(static::$entityInitEnabled->getIdentity());
        $this->assertNotNull(call_user_func([static::$entityInitEnabled, static::$identityMethodGetter]));
        $this->assertEquals('something-else', static::$entityInitEnabled->getIdentity());
        $this->assertEquals('something-else', call_user_func([static::$entityInitEnabled, static::$identityMethodGetter]));
        $this->assertTrue(static::$entityInitEnabled->hasIdentity());
        $this->assertTrue(call_user_func([static::$entityInitEnabled, static::$identityMethodExists]));
        $this->assertInstanceOf(static::$className, call_user_func([static::$entityInitEnabled, static::$identityMethodRemove], 'something-else'));
        $this->assertFalse(static::$entityInitEnabled->hasIdentity());
        $this->assertFalse(call_user_func([static::$entityInitEnabled, static::$identityMethodExists]));
        $this->assertNull(static::$entityInitEnabled->getIdentity());
        $this->assertNull(call_user_func([static::$entityInitEnabled, static::$identityMethodGetter]));
    }
}

/* EOF */
