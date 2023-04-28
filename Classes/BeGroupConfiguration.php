<?php

declare(strict_types=1);

namespace B13\PermissionSets;

class BeGroupConfiguration
{
    private array $permissionSets = [];

    public function __construct(array $permissionSets)
    {
        $this->permissionSets = $permissionSets;
    }

    public static function createFromInstruction(array $instructions): BeGroupConfiguration
    {
        $permissionSets = $instructions['permissionSets'] ?? [];

        return new self($permissionSets);
    }

    public function getPermissionSets(): array
    {
        return $this->permissionSets;
    }
}
