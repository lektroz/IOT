<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Avar Electric 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.21
	@build			17th September, 2019
	@created		20th August, 2019
	@package		IoT
	@subpackage		ionamelist.php
	@author			Lucas Manurung <https://instrumentasi.id>	
	@copyright		Copyright (C) 2019. All Rights Reserved Lucas Manurung
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Ionamelist Form Field class for the Iot component
 */
class JFormFieldIonamelist extends JFormFieldList
{
	/**
	 * The ionamelist field type.
	 *
	 * @var		string
	 */
	public $type = 'ionamelist';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('a.id','a.name'),array('id','name')));
$query->from($db->quoteName('#__iot_io_list', 'a'));
$query->where($db->quoteName('a.published') . ' = 1');
$query->order('a.name ASC');
$db->setQuery((string)$query);
$items = $db->loadObjectList();
$options = array();
if ($items)
{
	$options[] = JHtml::_('select.option', '', 'Select an Input/Output');
	foreach($items as $item)
	{
		$options[] = JHtml::_('select.option', $item->id, $item->name);
	}
}
return $options;
	}
}
