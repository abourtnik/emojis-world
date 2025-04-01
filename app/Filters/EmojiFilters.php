<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class EmojiFilters extends Filter
{
    /**
     * @param string[] $categories
     * @return Builder
     */
    public function categories(array $categories): Builder
    {
        return $this->builder->whereIn('category_id', $categories);
    }

    /**
     * @param string[] $subCategories
     * @return Builder
     */
    public function subCategories(array $subCategories): Builder
    {
        return $this->builder->whereIn('sub_category_id', $subCategories);
    }

    /**
     * @param string[] $versions
     * @return Builder
     */
    public function versions(array $versions): Builder
    {
        return $this->builder->whereIn('version', $versions);
    }

    public function limit(int $limit): Builder
    {
        return $this->builder->limit($limit);
    }
}
