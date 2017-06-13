<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
	<INCLUDE_TYPOSCRIPT: source="FILE:EXT:nn_address/Configuration/TSconfig/default.txt">
');

/*
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'nn_address',
    'Configuration/TSconfig/exmaple.txt',
    'EXT:NN Address:: Example'
);
*/
