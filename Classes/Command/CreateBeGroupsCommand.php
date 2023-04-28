<?php

declare(strict_types=1);

namespace B13\PermissionSets\Command;

use B13\PermissionSets\BeGroupConfigurationRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use B13\PermissionSets\BeGroupsRepository;

final class CreateBeGroupsCommand extends Command
{
    private BeGroupsRepository $beGroupsRepository;
    private BeGroupConfigurationRegistry $registry;

    public function __construct(BeGroupsRepository $beGroupsRepository, BeGroupConfigurationRegistry $registry)
    {
        $this->beGroupsRepository = $beGroupsRepository;
        $this->registry = $registry;
        parent::__construct('CreateBeGroups');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->registry->getAllIdentifier() as $identifier) {
            if (!$this->beGroupsRepository->doesBeGroupExist($identifier)) {
                $this->beGroupsRepository->add($identifier);
            }
        }

        return Command::SUCCESS;
    }
}
