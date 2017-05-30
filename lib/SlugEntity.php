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

use SR\Doctrine\ORM\Mapping\Introspectable\EntityIntrospectableTrait;

class SlugEntity extends Entity
{
    use EntityIntrospectableTrait;

    /**
     * @var null|string
     */
    protected $slug;

    /**
     * @param string|null $slug
     *
     * @return $this
     */
    public function setSlug($slug = null)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return bool
     */
    public function hasSlug()
    {
        return (bool) ($this->getSlug() !== null);
    }

    /**
     * @return $this
     */
    public function clearSlug()
    {
        $this->slug = null;

        return $this;
    }
}
