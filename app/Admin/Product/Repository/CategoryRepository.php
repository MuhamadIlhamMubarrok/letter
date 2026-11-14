<?php

namespace App\Admin\Product\Repository;

use App\Core\Repository\BaseRepository;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getAllCategories(): Collection
    {
        return $this->newQuery()->orderBy('name')->get();
    }
}
