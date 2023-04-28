<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "permission-sets" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace B13\PermissionSets;

use TYPO3\CMS\Core\Authentication\Event\AfterGroupsResolvedEvent;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Dashboard\WidgetRegistry;

/**
 * Event listener to enrich a be_group with permissions
 */
final class AttachPermissionsSetsToGroups
{
    private BeGroupConfigurationRegistry $registry;

    public function __construct(BeGroupConfigurationRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function __invoke(AfterGroupsResolvedEvent $event)
    {
        $existingGroups = $event->getGroups();
        $finalGroups = [];

        foreach ($existingGroups as $group) {
            $existingPermissionSetIdentifiers = [];
            if (!empty($group['permission_sets'])) {
                $existingPermissionSetIdentifiers = explode(',', $group['permission_sets']);
            }

            if ($this->registry->has($group['identifier'] ?? '')) {
                $additionalPermissionSetIdentifiers = $this->registry->get($group['identifier'] ?? '');
                $resultingPermissionSets = array_filter(array_merge($existingPermissionSetIdentifiers, $additionalPermissionSetIdentifiers->getPermissionSets()));

                $group['permission_sets'] = implode(',', $resultingPermissionSets);
            }

            $finalGroups[] = $group;
        }

        $event->setGroups($finalGroups);
    }
}
