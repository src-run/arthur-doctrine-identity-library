<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping;

use SR\Doctrine\ORM\Mapping\Castable\EntityCastableTrait;
use SR\Doctrine\ORM\Mapping\Cognizant\EntityCognizantTrait;
use SR\Doctrine\ORM\Mapping\Copyable\EntityCopyableTrait;
use SR\Doctrine\ORM\Mapping\Equatable\EntityEquatableTrait;
use SR\Doctrine\ORM\Mapping\Identifiable\EntityIdentifiableTrait;
use SR\Doctrine\ORM\Mapping\Initializeable\EntityInitializeableTrait;
use SR\Doctrine\ORM\Mapping\Reflectable\EntityReflectableTrait;
use SR\Doctrine\ORM\Mapping\Serializable\EntitySerializableTrait;

abstract class Entity implements EntityInterface
{
    use EntityCastableTrait;
    use EntityCognizantTrait;
    use EntityCopyableTrait;
    use EntityEquatableTrait;
    use EntityIdentifiableTrait;
    use EntityInitializeableTrait;
    use EntityReflectableTrait;
    use EntitySerializableTrait;

    /**
     * @param bool $initialize
     */
    public function __construct($initialize = true)
    {
        if (true === $initialize) {
            $this->doInitialization();
        }
    }
}
