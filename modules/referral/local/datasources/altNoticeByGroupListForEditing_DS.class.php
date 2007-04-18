<?php
$loader->requireOnce('/includes/Datasource_sql.class.php');

/**
 * Retrieves a Celini Datasource of {@link altNotice}s that are linked to a
 * particular ACL group
 *
 * @todo update docs
 * @todo consider renaming class to better reflect current generic status
 */
class altNoticeByGroupListForEditing_DS extends Datasource_sql
{
	/**#@+
	 * {@inheritdoc}
	 */
	var $_internalName = 'altNoticeByGroupList_DS';
	var $_type = 'html';
	var $hideExportLink = true;
	/**#@-*/
	
	
	/**
	 * Sets the target of the links generated by this code.
	 *
	 * @var boolean
	 */
	var $target = '_top';
	
	
	function altNoticeByGroupListForEditing_DS($type, $id) {
		$db =& new clniDB();
		$this->setup(
			Celini::dbInstance(),
			array(
				'cols'  => 'altnotice_id, 
					CONCAT(LEFT(note, 80), IF(LENGTH(note) > 70, "...", "")) AS note,
					DATE_FORMAT(creation_date, "%m/%d/%Y") AS formatted_creation_date,
					"Edit" as "edit_action",
					"Delete" AS "delete_action"
					',
				'from'  => 'altnotice',
				'where' => 'owner_type = "' . $db->escape($type) . '" AND owner_id = "' . $db->escape($id) . '" AND deleted = 0',
			),
			array('note' => 'Note', 'edit_action' => '', 'delete_action' => '')
		);
		
		$this->registerFilter('edit_action', array(&$this, '_addEditLink'));
		$this->registerFilter('delete_action', array(&$this, '_addDeleteLink'));
		
		$this->orderHints['formatted_creation_date'] = 'creation_date';
		$this->addDefaultOrderRule('formatted_creation_date', 'DESC');
	}
	
	
	/**
	 * Adds edit link
	 */
	function _addEditLink($value, $rowValues) {
		$url = Celini::link('edit', 'altnotice') . 'altnotice_id=' . $rowValues['altnotice_id'];
		$get =& Celini::filteredGet();
		if ($get->exists('embedded')) {
			$url = str_replace('/main/', '/minimal/', $url);
			foreach ($get->keys() as $key) {
				$url .= '&' . $key . '=' . $get->getTyped($key, 'htmlsafe');
			}
		}
		
		return '<a target="' . $this->target . '" href="' . $url . '">' . $value . '</a>';
		//return '<a href="'.Celini::link('view/' . $rowValues['altnotice_id'],'altnotice').$passAlong.'">' . $value . '</a>';
	}
	
	function _addDeleteLink($value, $rowValues) {
		$url = Celini::link('delete', 'altnotice') . 'alert_id=' . $rowValues['altnotice_id'] . '&process=true';
		$get =& Celini::filteredGet();
		if ($get->exists('embedded')) {
			$url = str_replace('/main/', '/minimal/', $url);
		}
		
		return '<a target="' . $this->target . '" href="' . $url . '">' . $value . '</a>'; 
	}
}

