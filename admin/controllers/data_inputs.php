<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Avar Electric 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.21
	@build			17th September, 2019
	@created		20th August, 2019
	@package		IoT
	@subpackage		data_inputs.php
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

/**
 * Data_inputs Controller
 */
class IotControllerData_inputs extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_IOT_DATA_INPUTS';

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Data_input', $prefix = 'IotModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('data_input.export', 'com_iot') && $user->authorise('core.export', 'com_iot'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			JArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Data_inputs');
			// get the data to export
			$data = $model->getExportData($pks);
			if (IotHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				IotHelper::xls($data,'Data_inputs_'.$date->format('jS_F_Y'),'Data inputs exported ('.$date->format('jS F, Y').')','data inputs');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_IOT_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_iot&view=data_inputs', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('data_input.import', 'com_iot') && $user->authorise('core.import', 'com_iot'))
		{
			// Get the import model
			$model = $this->getModel('Data_inputs');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (IotHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('data_input_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'data_inputs');
				$session->set('dataType_VDM_IMPORTINTO', 'data_input');
				// Redirect to import view.
				$message = JText::_('COM_IOT_IMPORT_SELECT_FILE_FOR_DATA_INPUTS');
				$this->setRedirect(JRoute::_('index.php?option=com_iot&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_IOT_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_iot&view=data_inputs', false), $message, 'error');
		return;
	}
}
