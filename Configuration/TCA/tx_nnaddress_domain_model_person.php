<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

return array(

	'ctrl' => array(
		'title'	=> 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person',
		'label' => 'last_name',
		'label_alt' => 'first_name,organisation',
		'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'gender,title,first_name,second_first_name,last_name,organisation,position,birthday,image,street,number,zip,city,phone,fax,email,website,notes,addresses,phones,mails,groups,categories,',
		// 'dynamicConfigFile' => 'EXT:nn_address/Configuration/TCA/Person.php',
		'iconfile' => 'EXT:nn_address/Resources/Public/Icons/tx_nnaddress_domain_model_person.gif'
	),

	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, gender, title, first_name, second_first_name, last_name, organisation, position, image, fal_image, street, number, zip, city, phone, fax, email, website, notes, addresses, phones, mails, groups, categories, flexform',
	),
	'types' => array(
		'1' => array('showitem' => 'l10n_parent, l10n_diffsource, hidden;;1, gender, title, first_name, second_first_name, last_name, organisation, position, birthday, fal_image, website, notes,
									--div--;LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.addresses, addresses, 
									--div--;LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.phones, phones,
									--div--;LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.mails, mails, 
									--div--;LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.assignment, groups, categories,
									--div--;LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.advanced, flexform,
									--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
						-1,
						'flags-multiple'
					],
				],
				'default' => 0,
			]
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_nnaddress_domain_model_person',
				'foreign_table_where' => 'AND tx_nnaddress_domain_model_person.pid=###CURRENT_PID### AND tx_nnaddress_domain_model_person.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'gender' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.gender',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('LLL:EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_person.xlf:gender.0', 0),
					array('LLL:EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_person.xlf:gender.1', 1),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => '',
			),
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'first_name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.first_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'second_first_name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.second_first_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'last_name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.last_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'organisation' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.organisation',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'position' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.position',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'birthday' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.birthday',
			'config' => array(
				'type' => 'input',
				'size' => 7,
				'eval' => 'date',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'image' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.image',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'uploadfolder' => 'uploads/tx_nnaddress',
				'show_thumbs' => 1,
				'size' => 5,
				'maxitems' => 5,
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'disallowed' => '',
			),
		),
		'fal_image' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.image',
			'config' => ExtensionManagementUtility::getFileFieldTCAConfig('image', array(
				'maxitems'	=> 5,
			),$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
		),
		'street' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'number' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.number',
			'config' => array(
				'type' => 'input',
				'size' => 7,
				'eval' => 'trim'
			),
		),
		'zip' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.zip',
			'config' => array(
				'type' => 'input',
				'size' => 7,
				'eval' => 'trim'
			),
		),
		'city' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'phone' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.phone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'fax' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.fax',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'website' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.website',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'notes' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.notes',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'addresses' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.addresses',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_nnaddress_domain_model_address',
				'foreign_field' => 'person',
				'foreign_sortby' => 'sorting',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1,
					'useSortable' => 1
				),
			),
		),
		'phones' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.phones',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_nnaddress_domain_model_phone',
				'foreign_field' => 'person',
				'foreign_sortby' => 'sorting',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1,
					'useSortable' => 1
				),
			),
		),
		'mails' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.mails',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_nnaddress_domain_model_mail',
				'foreign_field' => 'person',
				'foreign_sortby' => 'sorting',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1,
					'useSortable' => 1
				),
			),
		),
		'groups' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_person.groups',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_nnaddress_domain_model_group',
				'foreign_table_where' => ' AND (((\'###PAGE_TSCONFIG_IDLIST###\' <> \'\' OR \'###PAGE_TSCONFIG_IDLIST###\' > 0) AND FIND_IN_SET(tx_nnaddress_domain_model_group.pid,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'\' OR \'###PAGE_TSCONFIG_IDLIST###\' = 0)) AND tx_nnaddress_domain_model_group.sys_language_uid=###REC_FIELD_sys_language_uid### ORDER BY tx_nnaddress_domain_model_group.title ',
				'MM' => 'tx_nnaddress_person_group_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
			),
		),
		'flexform' => array(
			'exclude' => 1,
			'label' => '',
			'config' => array(
				'type' => 'flex',
				'ds_pointerField' => 'uid',
				'ds' => array(
					'default' => 'FILE:EXT:nn_address/Configuration/FlexForms/Model/Person.xml',
				),
			),
		)
	),
);

/* 
// Extension manager configuration
$_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['nn_address']);

if ( $_extConfig['useFal'] == 0 ) {
	$TCA['tx_nnaddress_domain_model_person']['types']['1']['showitem'] = str_replace(array(',fal_image,'), array(','), $TCA['tx_nnaddress_domain_model_person']['types']['1']['showitem'] );
	unset($TCA['tx_nnaddress_domain_model_person']['columns']['fal_image']);
} else if ( $_extConfig['useFal'] == 1 ) {
	$TCA['tx_nnaddress_domain_model_person']['types']['1']['showitem'] = str_replace(array(',image,'), array(','), $TCA['tx_nnaddress_domain_model_person']['types']['1']['showitem'] );
	unset($TCA['tx_nnaddress_domain_model_person']['columns']['image']);
}

unset($_extConfig);

 */

// Add Flexform if in extManager Conf is set or remove the sheet
// \NN\NnAddress\Utility\Flexform::modifyFlexSheet($TCA, 'person');