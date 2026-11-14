<?php

namespace App\Core\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    protected function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->newQuery()->with($relations)->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        return $this->newQuery()->with($relations)->latest()->paginate($perPage, $columns);
    }

    public function findById(int|string $id, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->newQuery()->with($relations)->find($id, $columns);
    }

    public function findByField(string $field, mixed $value, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->newQuery()->with($relations)->where($field, $value)->first($columns);
    }

    public function create(array $payload): Model
    {
        return $this->model->create($payload);
    }

    public function update(int|string $id, array $payload): bool
    {
        $item = $this->findById($id);
        if (!$item) {
            return false;
        }
        return $item->update($payload);
    }

    public function delete(int|string $id): bool
    {
        $item = $this->findById($id);
        if (!$item) {
            return false;
        }
        return (bool) $item->delete();
    }
}
