<?php
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3_MODE') or die;

//// add content element type
call_user_func(function () {

    $_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['nn_address']);

    // Register plugins
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'nn_address',
        'Single',
        'Address - Single'
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'nn_address',
        'List',
        'Address - List'
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'nn_address',
        'AbcList',
        'Address - ABC List'
    );

    // Add Typoscript
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('nn_address', 'Configuration/TypoScript/Default',
        'NN Address');

    // Add flexform for plugins
    $_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['nn_address']);

    // Add flexform for plugin AbcList
    $flexFormFile = $_extConfig['flexFormPlugin'] . 'AbcList.xml';
    if (file_exists(GeneralUtility::getFileAbsFileName($flexFormFile))) {
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['nnaddress_abclist'] = 'recursive,select_key,pages, ';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['nnaddress_abclist'] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('nnaddress_abclist',
            'FILE:' . $flexFormFile);
    }

    // Add flexform for plugin List
    $flexFormFile = $_extConfig['flexFormPlugin'] . 'List.xml';
    if (file_exists(GeneralUtility::getFileAbsFileName($flexFormFile))) {
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['nnaddress_list'] = 'recursive,select_key,pages, ';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['nnaddress_list'] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('nnaddress_list',
            'FILE:' . $flexFormFile);
    }

    // Add flexform for plugin Single
    $flexFormFile = $_extConfig['flexFormPlugin'] . 'Single.xml';
    if (file_exists(GeneralUtility::getFileAbsFileName($flexFormFile))) {
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['nnaddress_single'] = 'recursive,select_key,pages,  ';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['nnaddress_single'] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('nnaddress_single',
            'FILE:' . $flexFormFile);
    }

/*



*/
    //$contentElementType = 'nn_phaeno_base_stage_item';
    //$contentElementTitle = 'Bühneneintrag';
    //
    //$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    //  $contentElementTitle,
    //  $contentElementType,
    //  'EXT:nn_phaeno_base/ext_icon.gif'
    //];
    //
    //$GLOBALS['TCA']['tt_content']['types'][$contentElementType]['showitem'] = '
    //  --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
    //  subheader;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:subheader_formlabel,
    //  header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
    //  header_link;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel,
    //  --linebreak--,
    //  bodytext,
    //  assets,
    //  --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
    //  hidden;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:field.default.hidden,
    //  --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
    //';

    // setup link popup options
    //
    //ArrayUtility::mergeRecursiveWithOverrule(
    //    $GLOBALS['TCA']['tt_content']['columns']['header_link']['config']['fieldControl']['linkPopup']['options'],
    //    [
    //        'blindLinkOptions' => 'folder',
    //        'blindLinkFields' => 'class,params,target,title'
    //    ]
    //);
    //ArrayUtility::mergeRecursiveWithOverrule(
    //    $GLOBALS['TCA']['tt_content']['columns']['bodytext']['config'],
    //    [
    //        'blindLinkOptions' => 'folder',
    //        'blindLinkFields' => 'class,params,target,title'
    //    ]
    //);

    //// Replace sys_language_uid into general palette
    //ExtensionManagementUtility::addToAllTCAtypes('tt_content', '__UNSET' /* random string, no actual API! */, '',
    //    'replace:sys_language_uid');
    //ExtensionManagementUtility::addFieldsToPalette('tt_content', 'general', '--linebreak--, sys_language_uid');

    // Replace sectionIndex into headers palette
    //ExtensionManagementUtility::addToAllTCAtypes('tt_content', '__UNSET' /* random string, no actual API! */, '',
    //    'replace:sectionIndex');
    //ExtensionManagementUtility::addFieldsToPalette('tt_content', 'headers', 'sectionIndex', 'after:header_layout');
});//