<?php
defined('TYPO3_MODE') or die();

/***************
 * Plugin
 */

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['extensioninfo_pi1']='layout, select_key, pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['extensioninfo_pi1']='pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'extensioninfo_pi1',
    'FILE:EXT:extension_info/Configuration/FlexForms/flexform_extensionInfo.xml'
);

/***************
 * TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'extension_info',
    'Configuration/TypoScript',
    'Extension Info'
);
