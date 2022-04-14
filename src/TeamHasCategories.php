<?php

namespace StarfolkSoftware\Pigeonhole;

trait TeamHasCategories
{
    /**
     * Get the categories associated with the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(Pigeonhole::$categoryModel, 'team_id');
    }
}
