<?php

namespace App\Core\Service;

use App\Core\DTO\BaseDTO;
use App\Core\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseCrudService implements BaseCrudServiceInterface
{
    protected BaseRepositoryInterface $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function getById(int|string $id): ?Model
    {
        return $this->repository->findById($id);
    }

    public function createFromDTO(BaseDTO $dto): Model
    {
        return $this->repository->create($dto->toFilteredArray());
    }

    public function updateFromDTO(int|string $id, BaseDTO $dto): bool
    {
        return $this->repository->update($id, $dto->toFilteredArray());
    }

    public function deleteById(int|string $id): bool
    {
        return $this->repository->delete($id);
    }
}
