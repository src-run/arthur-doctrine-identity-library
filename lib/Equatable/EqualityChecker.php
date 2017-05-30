<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Equatable;

use SR\Doctrine\ORM\Mapping\EntityInterface;
use SR\Reflection\Inspect;

final class EqualityChecker
{
    /**
     * @var EntityInterface
     */
    private $entityOne;

    /**
     * @var EntityInterface
     */
    private $entityTwo;

    /**
     * @param EntityInterface $entityOne
     * @param EntityInterface $entityTwo
     */
    public function __construct(EntityInterface $entityOne, EntityInterface $entityTwo)
    {
        $this->entityOne = $entityOne;
        $this->entityTwo = $entityTwo;
    }

    /**
     * @return bool
     */
    public function isEqual(): bool
    {
        return $this->getPropertiesNormalized($this->entityOne) === $this->getPropertiesNormalized($this->entityTwo);
    }

    /**
     * @return bool
     */
    public function isIdentityEqual(): bool
    {
        return $this->entityOne->hasIdentity() && $this->entityTwo->hasIdentity() &&
            $this->entityOne->getIdentity() === $this->entityTwo->getIdentity();
    }

    /**
     * @param EntityInterface $entity
     *
     * @return mixed[]
     */
    private function getPropertiesNormalized(EntityInterface $entity): array
    {
        $normalized = [];

        foreach (Inspect::using($entity)->properties() as $p) {
            $normalized[$p->name()] = $p->value($entity);
        }

        ksort($normalized);

        return $normalized;
    }
}
