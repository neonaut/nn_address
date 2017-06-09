<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// register icons
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

// bitmap image
$iconRegistry->registerIcon('address-icon', \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class, ['source' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_nnaddress_domain_model_address.gif'] );
$iconRegistry->registerIcon('group-icon'  , \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class, ['source' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_nnaddress_domain_model_group.gif'] );
$iconRegistry->registerIcon('mail-icon'   , \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class, ['source' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_nnaddress_domain_model_mail.gif'] );
$iconRegistry->registerIcon('person-icon' , \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class, ['source' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_nnaddress_domain_model_person.gif'] );
$iconRegistry->registerIcon('phone-icon'  , \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class, ['source' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_nnaddress_domain_model_phone.gif'] );

// SVG image 
$iconRegistry->registerIcon('gridelements-default', \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class, array( 'source' => 'EXT:gridelements/Resources/Public/Icons/gridelements.svg'));

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Single',
	'Address - Single'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'List',
	'Address - List'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'AbcList',
	'Address - ABC List'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Default', 'NN Address');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/ContentDesigner', 'CD: Address in Page properties');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
	<INCLUDE_TYPOSCRIPT: source="FILE:EXT:nn_address/Configuration/TSconfig/default.txt">
');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nnaddress_domain_model_person', 'EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_person.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nnaddress_domain_model_person');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    $_EXTKEY,
    'tx_nnaddress_domain_model_person'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nnaddress_domain_model_address', 'EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_address.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nnaddress_domain_model_address');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nnaddress_domain_model_phone', 'EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_phone.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nnaddress_domain_model_phone');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nnaddress_domain_model_mail', 'EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_mail.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nnaddress_domain_model_mail');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nnaddress_domain_model_group', 'EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_group.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nnaddress_domain_model_group');


// Flexform autloader
\NN\NnAddress\Utility\Flexform::flexFormAutoLoader();

?>