<?php

declare(strict_types=1);

namespace B13\PermissionSets;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class BeGroupsRepository
{
    public function doesBeGroupExist(string $identifier): bool
    {
        $connection = $this->getConnection();

        $rowCount = $connection->count(
            '*',
            'be_groups',
            ['identifier' => (string)$identifier],
            [],
            [],
            1
        );

        if ($rowCount > 0) {
            return true;
        }

        return false;
    }

    public function add(string $identifier)
    {
        if ($this->doesBeGroupExist($identifier)) {
            throw new \RuntimeException('be_groups record with identifier \'' . $identifier . '\' does already exist!');
        }

        $connection = $this->getConnection();

        $connection->insert(
            'be_groups',
            [
                'title' => '[New Group] ' . $identifier,
                'identifier' => $identifier
            ]
        );
    }

    private function getConnection(): Connection
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('be_groups');
    }
}
