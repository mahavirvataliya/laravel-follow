<?php

/*
 * This file is part of the overtrue/laravel-follow
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\LaravelFollow\Traits;

use Overtrue\LaravelFollow\Follow;

/**
 * Trait CanBlock.
 */
trait CanBlock
{
    /**
     * Follow an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @throws \Exception
     *
     * @return array
     */
    public function block($targets, $class = __CLASS__)
    {
        return Follow::attachRelations($this, 'blocks', $targets, $class);
    }

    /**
     * Unblock an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @return array
     */
    public function unblock($targets, $class = __CLASS__)
    {
        return Follow::detachRelations($this, 'blocks', $targets, $class);
    }

    /**
     * Toggle block an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @throws \Exception
     *
     * @return array
     */
    public function toggleBlock($targets, $class = __CLASS__)
    {
        return Follow::toggleRelations($this, 'blocks', $targets, $class);
    }

    /**
     * Check if user is blocked given item.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $target
     * @param string                                        $class
     *
     * @return bool
     */
    public function hasBlocked($target, $class = __CLASS__)
    {
        return Follow::isRelationExists($this, 'blocks', $target, $class);
    }

    /**
     * Return item blocks.
     *
     * @param string $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blocks($class = __CLASS__)
    {
        return $this->morphedByMany($class, config('follow.morph_prefix'), config('follow.followable_table'))
            ->wherePivot('relation', '=', Follow::RELATION_BLOCK)
            ->withPivot('followable_type', 'relation', 'created_at');
    }
}
