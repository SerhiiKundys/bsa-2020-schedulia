<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class GetEventTypeCollectionRequest
{
    private ?string $searchString;
    private ?int $page;
    private ?int $perPage;
    private ?string $sorting;
    private ?string $direction;
    private ?bool $all;

    public function __construct(
        ?string $searchString,
        ?int $page,
        ?int $perPage,
        ?string $sorting,
        ?string $direction,
        ?bool $all
    ) {
        $this->searchString = $searchString;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->sorting = $sorting;
        $this->direction = $direction;
        $this->all = $all;
    }

    public function getSearchString(): ?string
    {
        return $this->searchString;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function getSorting(): ?string
    {
        return $this->sorting;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function getAll(): ?bool
    {
        return $this->all;
    }
}
