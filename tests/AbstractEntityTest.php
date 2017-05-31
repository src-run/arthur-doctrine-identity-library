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

use SR\Doctrine\ORM\Mapping\Tests\Fixture\IdEntity;
use SR\Doctrine\ORM\Mapping\Tests\Fixture\SlugEntityFixture;
use SR\Doctrine\ORM\Mapping\Tests\Fixture\UuidEntityFixture;

abstract class AbstractEntityTest extends \PHPUnit_Framework_TestCase
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
     * @var IdEntity|SlugEntityFixture|UuidEntityFixture
     */
    protected static $entityInitEnabled;

    /**
     * @var IdEntity|SlugEntityFixture|UuidEntityFixture
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

    /**
     * @param string $name
     *
     * @return array
     */
    public function setUpEntityInstances(string $name)
    {
        static::$entityInitEnabled = new $name();
        static::$entityInitDisabled = new $name(false);

        return [
            static::$entityInitEnabled,
            static::$entityInitDisabled
        ];
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
        $this->assertTrue(static::$entityInitEnabled->hasIdentityType());
        $this->assertEquals(strtolower(static::$classType), static::$entityInitEnabled->getIdentityType());
    }
}

/* EOF */
