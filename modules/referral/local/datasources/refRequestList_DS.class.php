<?php

require_once CELINI_ROOT . '/includes/Datasource_sql.class.php';

/**
 * Serves as quick means of getting a full list of request objects
 */
class refRequestList_DS extends Datasource_sql
{
	/**#@+
	 * {@inheritdoc}
	 */
	var $_internalName = 'refRequestList_DS';
	var $_type = 'html';
	var $hideExportLink = true;
	/**#@-*/
	
	
	
	/**
	 * Handle initialization of DS
	 */
	function refRequestList_DS() {
		$this->setup(Celini::dbInstance(), 
			array(
				'cols' => 'refRequest_id,
				           date_format(`date`, "%M %d, %Y") AS `formatted_date`,
						   refStatus,
				           reason,
				           refSpecialty',
				'from' => 'refRequest AS r'
			),
			array(
				'formatted_date' => 'Referral Request',
				'refStatus' => 'Status',
				'reason' => 'Reason', 
				'refSpecialty' => 'Specialty'
			)
		);
		$this->registerFilter('formatted_date', array($this, '_addLinkToList'));
		
		$enumCallback = array(&$this, '_enumValue');
		$this->registerFilter('refStatus', $enumCallback, 'refStatus');
		$this->registerFilter('refSpecialty', $enumCallback, 'refSpecialty');
		
		$this->orderHints['formatted_date'] = 'date';
		$this->addDefaultOrderRule('formatted_date', 'DESC');
	}
	
	function _addLinkToList($value, $rowValues) {
		$passAlong = '';
		if (isset($_GET['u'])) {
			$passAlong = "u=$_GET[u]";
		}
		return '<a href="'.Celini::link('view/' . $rowValues['refRequest_id'],'Referral', 'main').$passAlong.'">' . $value . '</a>';
	}
	
	function _enumValue($value, $rowValues, $fieldName) {
		static $enumManager;
		$enumManager =& EnumManager::getInstance();
		return $enumManager->lookup($fieldName, $value);
	}
}

