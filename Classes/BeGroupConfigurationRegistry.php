<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-extension "permission-sets" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace B13\PermissionSets;

use B13\PermissionSets\Discovery\BeGroupConfigurationLoader;

class BeGroupConfigurationRegistry
{
    private array $beGroupConfigurations = [];

    public function __construct(BeGroupConfigurationLoader $beGroupConfigurationLoader)
    {
        // @todo: should be moved to DI
        $beGroupConfigurationLoader->load($this);
    }

    public function add(string $identifier, BeGroupConfiguration $beGroupConfiguration): void
    {
        $this->beGroupConfigurations[$identifier] = $beGroupConfiguration;
    }

    public function has(string $identifier): bool
    {
        return isset($this->beGroupConfigurations[$identifier]) && $this->beGroupConfigurations[$identifier] instanceof BeGroupConfiguration;
    }

    public function get(string $identifier): BeGroupConfiguration
    {
        return $this->beGroupConfigurations[$identifier];
    }

    /**
     * @return array<string>
     */
    public function getAllIdentifier(): array
    {
        return array_keys($this->beGroupConfigurations);
    }
}
