<?php

$GLOBALS['TCA']['be_groups']['columns']['permission_sets'] = [
    'label' => 'Permission Sets',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectMultipleSideBySide',
        'itemsProcFunc' => \B13\PermissionSets\AvailablePermissionSets::class . '->backendGroupSelector',
        'items' => []
    ]
];
$GLOBALS['TCA']['be_groups']['columns']['identifier'] = [
    'label' => 'BeGroupIdentifier',
    'config' => [
        'type' => 'uuid',
        'enableCopyToClipboard' => true,
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('be_groups', 'identifier', '', 'after:title');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('be_groups', 'permission_sets', '', 'after:subgroup');
