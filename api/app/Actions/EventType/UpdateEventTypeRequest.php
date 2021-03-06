<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class UpdateEventTypeRequest
{
    private int $id;
    private string $name;
    private ?string $description;
    private string $slug;
    private string $color;
    private int $duration;
    private string $timezone;
    private bool $disabled;
    private array $availabilities;
    private string $locationType;
    private ?array $coordinates;
    private ?string $address;
    private ?string $chatitoWorkspace;
    private ?array $tags;

    public function __construct(
        int $id,
        string $name,
        ?string $description,
        string $slug,
        string $color,
        int $duration,
        string $timezone,
        bool $disabled,
        array $availabilities,
        string $locationType,
        ?array $coordinates,
        ?string $address,
        ?string $chatitoWorkspace,
        ?array $tags
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->slug = $slug;
        $this->color = $color;
        $this->duration = $duration;
        $this->timezone = $timezone;
        $this->disabled = $disabled;
        $this->availabilities = $availabilities;
        $this->locationType = $locationType;
        $this->coordinates = $coordinates;
        $this->address = $address;
        $this->chatitoWorkspace = $chatitoWorkspace;
        $this->tags = $tags;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function getDisabled(): bool
    {
        return $this->disabled;
    }

    public function getAvailabilities(): array
    {
        return $this->availabilities;
    }

    public function getLocationType(): string
    {
        return $this->locationType;
    }

    public function getCoordinates(): ?array
    {
        return $this->coordinates;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getChatitoWorkspace(): ?string
    {
        return $this->chatitoWorkspace;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }
}
