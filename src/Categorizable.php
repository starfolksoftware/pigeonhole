<?php

namespace StarfolkSoftware\Pigeonhole;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as BaseCollection;

trait Categorizable
{
    /**
     * Define a polymorphic many-to-many relationship.
     *
     * @param string $related
     * @param string $name
     * @param string $table
     * @param string $foreignPivotKey
     * @param string $relatedPivotKey
     * @param string $parentKey
     * @param string $relatedKey
     * @param bool   $inverse
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    abstract public function morphToMany(
        $related,
        $name,
        $table = null,
        $foreignPivotKey = null,
        $relatedPivotKey = null,
        $parentKey = null,
        $relatedKey = null,
        $inverse = false
    );

    /**
     * Get all attached categories to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function categories(): MorphToMany
    {
        return $this->morphToMany(
            Pigeonhole::$categoryModel,
            'categorizable',
            'categorizables',
            'categorizable_id',
            'category_id'
        )->withTimestamps();
    }

    /**
     * Scope query with all the given categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mixed $categories
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAllCategories(Builder $builder, $categories): Builder
    {
        $categories = $this->prepareCategoryIds($categories);

        collect($categories)->each(function ($category) use ($builder) {
            $builder->whereHas('categories', function (Builder $builder) use ($category) {
                return $builder->where('categories.id', $category);
            });
        });

        return $builder;
    }

    /**
     * Scope query with any of the given categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mixed $categories
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAnyCategories(Builder $builder, $categories): Builder
    {
        $categories = $this->prepareCategoryIds($categories);

        return $builder->whereHas('categories', function (Builder $builder) use ($categories) {
            $builder->whereIn('categories.id', $categories);
        });
    }

    /**
     * Scope query without any of the given categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mixed $categories
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutCategories(Builder $builder, $categories): Builder
    {
        $categories = $this->prepareCategoryIds($categories);

        return $builder->whereDoesntHave('categories', function (Builder $builder) use ($categories) {
            $builder->whereIn('categories.id', $categories);
        });
    }

    /**
     * Scope query without any categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutAnyCategories(Builder $builder): Builder
    {
        return $builder->doesntHave('categories');
    }

    /**
     * Determine if the model has any of the given categories.
     *
     * @param mixed $categories
     * @return bool
     */
    public function hasCategories($categories): bool
    {
        $categories = $this->prepareCategoryIds($categories);

        return ! $this->categories->pluck('id')->intersect($categories)->isEmpty();
    }

    /**
     * Determine if the model has all of the given categories.
     *
     * @param mixed $categories
     * @return bool
     */
    public function hasAllCategories($categories): bool
    {
        $categories = $this->prepareCategoryIds($categories);

        return collect($categories)->diff($this->categories->pluck('id'))->isEmpty();
    }

    /**
     * Sync model categories.
     *
     * @param mixed $categories
     * @param bool  $detaching
     * @return $this
     */
    public function syncCategories($categories, bool $detaching = true)
    {
        // Find categories
        $categories = $this->prepareCategoryIds($categories);

        // Sync model categories
        $this->categories()->sync($categories, $detaching);

        return $this;
    }

    /**
     * Attach model categories.
     *
     * @param mixed $categories
     * @return $this
     */
    public function attachCategories($categories)
    {
        return $this->syncCategories($categories, false);
    }

    /**
     * Detach model categories.
     *
     * @param mixed $categories
     * @return $this
     */
    public function detachCategories($categories = null)
    {
        $categories = ! is_null($categories) ? $this->prepareCategoryIds($categories) : null;

        // Sync model categories
        $this->categories()->detach($categories);

        return $this;
    }

    /**
     * Prepare category IDs.
     *
     * @param mixed $categories
     * @return array
     */
    protected function prepareCategoryIds($categories): array
    {
        // Convert collection to plain array
        if ($categories instanceof BaseCollection && is_string($categories->first())) {
            $categories = $categories->toArray();
        }

        // Find categories by their ids
        if (is_numeric($categories) || (is_array($categories) && is_numeric(Arr::first($categories)))) {
            return array_map('intval', (array) $categories);
        }

        if ($categories instanceof Model) {
            return [$categories->getKey()];
        }

        if ($categories instanceof Collection) {
            return $categories->modelKeys();
        }

        if ($categories instanceof BaseCollection) {
            return $categories->toArray();
        }

        return (array) $categories;
    }
}
