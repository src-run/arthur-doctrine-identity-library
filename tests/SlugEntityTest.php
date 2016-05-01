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

/**
 * Class SlugEntityTest.
 */
class SlugEntityTest extends AbstractEntityType
{
    public function testAccessors()
    {
        $this->assertNull(self::$entityInitEnabled->getSlug());
        $this->assertFalse(self::$entityInitEnabled->hasSlug());
        self::$entityInitEnabled->setSlug('a-slug-string');
        $this->assertSame('a-slug-string', self::$entityInitEnabled->getSlug());
        $this->assertTrue(self::$entityInitEnabled->hasSlug());
        self::$entityInitEnabled->clearSlug();
        $this->assertNull(self::$entityInitEnabled->getSlug());
        $this->assertFalse(self::$entityInitEnabled->hasSlug());
    }
}

/* EOF */
