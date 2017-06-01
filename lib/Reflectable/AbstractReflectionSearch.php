<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Reflectable;

use SR\Doctrine\ORM\Mapping\EntityInterface;
use SR\Reflection\Inspector\Aware\ScopeCore\IdentityNameAwareInterface;

/**
 * @internal
 */
abstract class AbstractReflectionSearch
{
    /**
     * @var EntityInterface
     */
    protected $entity;

    /**
     * @var string
     */
    protected $search;

    /**
     * @param EntityInterface $entity
     * @param string|null     $search
     */
    public function __construct(EntityInterface $entity, string $search = null)
    {
        $this->entity = $entity;
        $this->search = $search;
    }

    /**
     * @param IdentityNameAwareInterface $identityNameAware
     *
     * @return bool
     */
    protected function isMatch(IdentityNameAwareInterface $identityNameAware)
    {
        if (false !== strpos($identityNameAware->name(), $this->search)) {
            return true;
        }

        if (1 === preg_match(sprintf('{%s}', $this->search), $identityNameAware->name())) {
            return true;
        }

        return false;
    }
}
