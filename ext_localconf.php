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
