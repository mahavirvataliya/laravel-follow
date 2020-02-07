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
 * Trait CanBeReported.
 */
trait CanBeReported
{
    /**
     * Check if user is bookmarked by given user.
     *
     * @param int $user
     *
     * @return bool
     */
    public function isReportedBy($user)
    {
        return Follow::isRelationExists($this, 'reporters', $user);
    }

    /**
     * Return reporters.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reporters()
    {
        return $this->morphToMany(config('follow.user_model'), config('follow.morph_prefix'), config('follow.followable_table'))
            ->wherePivot('relation', '=', Follow::RELATION_REPORT)
            ->withPivot('followable_type', 'relation', 'created_at');
    }
}
