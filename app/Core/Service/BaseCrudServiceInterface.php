<?php

namespace App\Core\Service;

use App\Core\DTO\BaseDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseCrudServiceInterface
{
    public function getAll(): Collection;

    public function getPaginated(int $perPage = 15): LengthAwarePaginator;

    public function getById(int|string $id): ?Model;

    public function createFromDTO(BaseDTO $dto): Model;

    public function updateFromDTO(int|string $id, BaseDTO $dto): bool;

    public function deleteById(int|string $id): bool;
}
