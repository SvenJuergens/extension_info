<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'SvenJuergens.ExtensionInfo',
            'Pi1',
            [
                'ExtensionInfo' => 'list'
            ],
            // non-cacheable actions
            [
                
            ]
        );
    },
    $_EXTKEY
);

// Register cache frontend
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extension_info'] = [
    'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
    'backend' => \TYPO3\CMS\Core\Cache\Backend\FileBackend::class,
    'groups' => [
        'pages',
        'system'
    ],
    'options' => [
        //24h
        'defaultLifetime' => 86400,
    ]
];

require_once(
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) .
    'Resources/Private/Libraries/vendor/autoload.php'
);