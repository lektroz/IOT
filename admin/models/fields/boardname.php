<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Avar Electric 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.21
	@build			17th September, 2019
	@created		20th August, 2019
	@package		IoT
	@subpackage		boardname.php
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
 * Boardname Form Field class for the Iot component
 */
class JFormFieldBoardname extends JFormFieldList
{
	/**
	 * The boardname field type.
	 *
	 * @var		string
	 */
	public $type = 'boardname';

	/**
	 * Override to add new button
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   3.2
	 */
	protected function getInput()
	{
		// see if we should add buttons
		$set_button = $this->getAttribute('button');
		// get html
		$html = parent::getInput();
		// if true set button
		if ($set_button === 'true')
		{
			$button = array();
			$script = array();
			$button_code_name = $this->getAttribute('name');
			// get the input from url
			$app = JFactory::getApplication();
			$jinput = $app->input;
			// get the view name & id
			$values = $jinput->getArray(array(
				'id' => 'int',
				'view' => 'word'
			));
			// check if new item
			$ref = '';
			$refJ = '';
			if (!is_null($values['id']) && strlen($values['view']))
			{
				// only load referral if not new item.
				$ref = '&amp;ref=' . $values['view'] . '&amp;refid=' . $values['id'];
				$refJ = '&ref=' . $values['view'] . '&refid=' . $values['id'];
				// get the return value.
				$_uri = (string) JUri::getInstance();
				$_return = urlencode(base64_encode($_uri));
				// load return value.
				$ref .= '&amp;return=' . $_return;
				$refJ .= '&return=' . $_return;
			}
			// get button label
			$button_label = trim($button_code_name);
			$button_label = preg_replace('/_+/', ' ', $button_label);
			$button_label = preg_replace('/\s+/', ' ', $button_label);
			$button_label = preg_replace("/[^A-Za-z ]/", '', $button_label);
			$button_label = ucfirst(strtolower($button_label));
			// get user object
			$user = JFactory::getUser();
			// only add if user allowed to create subject
			if ($user->authorise('core.create', 'com_iot') && $app->isAdmin()) // TODO for now only in admin area.
			{
				// build Create button
				$button[] = '<a id="'.$button_code_name.'Create" class="btn btn-small btn-success hasTooltip" title="'.JText::sprintf('COM_IOT_CREATE_NEW_S', $button_label).'" style="border-radius: 0px 4px 4px 0px; padding: 4px 4px 4px 7px;"
					href="index.php?option=com_iot&amp;view=subject&amp;layout=edit'.$ref.'" >
					<span class="icon-new icon-white"></span></a>';
			}
			// only add if user allowed to edit subject
			if ($user->authorise('core.edit', 'com_iot') && $app->isAdmin()) // TODO for now only in admin area.
			{
				// build edit button
				$button[] = '<a id="'.$button_code_name.'Edit" class="btn btn-small hasTooltip" title="'.JText::sprintf('COM_IOT_EDIT_S', $button_label).'" style="display: none; padding: 4px 4px 4px 7px;" href="#" >
					<span class="icon-edit"></span></a>';
				// build script
				$script[] = "
					jQuery(document).ready(function() {
						jQuery('#adminForm').on('change', '#jform_".$button_code_name."',function (e) {
							e.preventDefault();
							var ".$button_code_name."Value = jQuery('#jform_".$button_code_name."').val();
							".$button_code_name."Button(".$button_code_name."Value);
						});
						var ".$button_code_name."Value = jQuery('#jform_".$button_code_name."').val();
						".$button_code_name."Button(".$button_code_name."Value);
					});
					function ".$button_code_name."Button(value) {
						if (value > 0) {
							// hide the create button
							jQuery('#".$button_code_name."Create').hide();
							// show edit button
							jQuery('#".$button_code_name."Edit').show();
							var url = 'index.php?option=com_iot&view=subjects&task=subject.edit&id='+value+'".$refJ."';
							jQuery('#".$button_code_name."Edit').attr('href', url);
						} else {
							// show the create button
							jQuery('#".$button_code_name."Create').show();
							// hide edit button
							jQuery('#".$button_code_name."Edit').hide();
						}
					}";
			}
			// check if button was created for subject field.
			if (is_array($button) && count($button) > 0)
			{
				// Load the needed script.
				$document = JFactory::getDocument();
				$document->addScriptDeclaration(implode(' ',$script));
				// return the button attached to input field.
				return '<div class="input-append">' .$html . implode('',$button).'</div>';
			}
		}
		return $html;
	}

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('a.id','a.name'),array('id','board_name')));
$query->from($db->quoteName('#__iot_board', 'a'));
$query->where($db->quoteName('a.published') . ' = 1');
$query->order('a.name ASC');
$db->setQuery((string)$query);
$items = $db->loadObjectList();
$options = array();
if ($items)
{
	$options[] = JHtml::_('select.option', '', 'Select a controller board');
	foreach($items as $item)
	{
		$options[] = JHtml::_('select.option', $item->id, $item->board_name);
	}
}
return $options;
	}
}
