<?php

declare(strict_types=1);

namespace B13\PermissionSets\Discovery;

use B13\PermissionSets\BeGroupConfiguration;
use B13\PermissionSets\BeGroupConfigurationRegistry;
use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
use TYPO3\CMS\Core\Core\Environment;
use Symfony\Component\Finder\Finder;

final class BeGroupConfigurationLoader
{
    private YamlFileLoader $yamlFileLoader;

    public function __construct(YamlFileLoader $yamlFileLoader)
    {
        $this->yamlFileLoader = $yamlFileLoader;
    }

    public function load(BeGroupConfigurationRegistry $registry)
    {
        // example: config/be-groups-configurations/df0af855-ad0f-436a-b83f-365703cab515.yaml
        // file name is based on uuid field of table be_groups 424bfd6433a4809f39325230cf08aae112c7d662
        if (file_exists(Environment::getConfigPath() . '/be-groups-configurations')) {
            $finder = Finder::create()->files()->sortByName()->depth(0)->name('*.yaml')->in(Environment::getConfigPath() . '/be-groups-configurations');
            foreach ($finder as $file) {
                $instruction = $this->yamlFileLoader->load((string)$file);
                $beGroupConfiguration = BeGroupConfiguration::createFromInstruction($instruction);
                $registry->add($file->getBasename('.yaml'), $beGroupConfiguration);
            }
        }
    }
}
