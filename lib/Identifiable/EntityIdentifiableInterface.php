<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Identifiable;

use SR\Doctrine\Exception\OrmException;

interface EntityIdentifiableInterface
{
    /**
     * @param bool $qualified
     *
     * @return string
     */
    public function getIdentityName(bool $qualified = false): string;

    /**
     * @param mixed $identity
     *
     * @throws OrmException
     *
     * @return $this
     */
    public function setIdentity($identity);

    /**
     * @throws OrmException
     *
     * @return mixed
     */
    public function getIdentity();

    /**
     * @return bool
     */
    public function hasIdentity(): bool;

    /**
     * @return string
     */
    public function getIdentityType(): string;

    /**
     * @return bool
     */
    public function hasIdentityType(): bool;
}
