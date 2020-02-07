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
 * Trait CanReport.
 */
trait CanReport
{
    /**
     * Report an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @throws \Exception
     *
     * @return array
     */
    public function report($targets, $class = __CLASS__)
    {
        return Follow::attachRelations($this, 'reports', $targets, $class);
    }

    /**
     * Unlike an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @return array
     */
    public function unreport($targets, $class = __CLASS__)
    {
        return Follow::detachRelations($this, 'reports', $targets, $class);
    }

    /**
     * Toggle report an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @throws \Exception
     *
     * @return array
     */
    public function toggleReport($targets, $class = __CLASS__)
    {
        return Follow::toggleRelations($this, 'reports', $targets, $class);
    }

    /**
     * Check if user has reported given item.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $target
     * @param string                                        $class
     *
     * @return bool
     */
    public function hasReported($target, $class = __CLASS__)
    {
        return Follow::isRelationExists($this, 'reports', $target, $class);
    }

    /**
     * Return item reports.
     *
     * @param string $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reports($class = __CLASS__)
    {
        return $this->morphedByMany($class, config('follow.morph_prefix'), config('follow.followable_table'))
            ->wherePivot('relation', '=', Follow::RELATION_REPORT)
            ->withPivot('followable_type', 'relation', 'created_at');
    }
}
