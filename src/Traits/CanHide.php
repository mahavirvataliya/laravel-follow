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
 * Trait CanHide.
 */
trait CanHide
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
    public function hide($targets, $class = __CLASS__)
    {
        return Follow::attachRelations($this, 'hides', $targets, $class);
    }

    /**
     * Unhide an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @return array
     */
    public function unhide($targets, $class = __CLASS__)
    {
        return Follow::detachRelations($this, 'hides', $targets, $class);
    }

    /**
     * Toggle hide an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @throws \Exception
     *
     * @return array
     */
    public function toggleHide($targets, $class = __CLASS__)
    {
        return Follow::toggleRelations($this, 'hides', $targets, $class);
    }

    /**
     * Check if user has hidden given item.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $target
     * @param string                                        $class
     *
     * @return bool
     */
    public function hasHidden($target, $class = __CLASS__)
    {
        return Follow::isRelationExists($this, 'hides', $target, $class);
    }

    /**
     * Return item hides.
     *
     * @param string $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hides($class = __CLASS__)
    {
        return $this->morphedByMany($class, config('follow.morph_prefix'), config('follow.followable_table'))
            ->wherePivot('relation', '=', Follow::RELATION_HIDE)
            ->withPivot('followable_type', 'relation', 'created_at');
    }
}
