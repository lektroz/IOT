<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Avar Electric 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.21
	@build			17th September, 2019
	@created		20th August, 2019
	@package		IoT
	@subpackage		script.php
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

JHTML::_('behavior.modal');

/**
 * Script File of Iot Component
 */
class com_iotInstallerScript
{
	/**
	 * Constructor
	 *
	 * @param   JAdapterInstance  $parent  The object responsible for running this script
	 */
	public function __construct(JAdapterInstance $parent) {}

	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function install(JAdapterInstance $parent) {}

	/**
	 * Called on uninstallation
	 *
	 * @param   JAdapterInstance  $parent  The object responsible for running this script
	 */
	public function uninstall(JAdapterInstance $parent)
	{
		// Get Application object
		$app = JFactory::getApplication();

		// Get The Database object
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Board alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.board') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$board_found = $db->getNumRows();
		// Now check if there were any rows
		if ($board_found)
		{
			// Since there are load the needed  board type ids
			$board_ids = $db->loadColumn();
			// Remove Board from the content type table
			$board_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.board') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($board_condition);
			$db->setQuery($query);
			// Execute the query to remove Board items
			$board_done = $db->execute();
			if ($board_done)
			{
				// If succesfully remove Board add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.board) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Board items from the contentitem tag map table
			$board_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.board') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($board_condition);
			$db->setQuery($query);
			// Execute the query to remove Board items
			$board_done = $db->execute();
			if ($board_done)
			{
				// If succesfully remove Board add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.board) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Board items from the ucm content table
			$board_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_iot.board') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($board_condition);
			$db->setQuery($query);
			// Execute the query to remove Board items
			$board_done = $db->execute();
			if ($board_done)
			{
				// If succesfully remove Board add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.board) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Board items are cleared from DB
			foreach ($board_ids as $board_id)
			{
				// Remove Board items from the ucm base table
				$board_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $board_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($board_condition);
				$db->setQuery($query);
				// Execute the query to remove Board items
				$db->execute();

				// Remove Board items from the ucm history table
				$board_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $board_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($board_condition);
				$db->setQuery($query);
				// Execute the query to remove Board items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Io_list alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.io_list') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$io_list_found = $db->getNumRows();
		// Now check if there were any rows
		if ($io_list_found)
		{
			// Since there are load the needed  io_list type ids
			$io_list_ids = $db->loadColumn();
			// Remove Io_list from the content type table
			$io_list_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.io_list') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($io_list_condition);
			$db->setQuery($query);
			// Execute the query to remove Io_list items
			$io_list_done = $db->execute();
			if ($io_list_done)
			{
				// If succesfully remove Io_list add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.io_list) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Io_list items from the contentitem tag map table
			$io_list_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.io_list') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($io_list_condition);
			$db->setQuery($query);
			// Execute the query to remove Io_list items
			$io_list_done = $db->execute();
			if ($io_list_done)
			{
				// If succesfully remove Io_list add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.io_list) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Io_list items from the ucm content table
			$io_list_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_iot.io_list') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($io_list_condition);
			$db->setQuery($query);
			// Execute the query to remove Io_list items
			$io_list_done = $db->execute();
			if ($io_list_done)
			{
				// If succesfully remove Io_list add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.io_list) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Io_list items are cleared from DB
			foreach ($io_list_ids as $io_list_id)
			{
				// Remove Io_list items from the ucm base table
				$io_list_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $io_list_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($io_list_condition);
				$db->setQuery($query);
				// Execute the query to remove Io_list items
				$db->execute();

				// Remove Io_list items from the ucm history table
				$io_list_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $io_list_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($io_list_condition);
				$db->setQuery($query);
				// Execute the query to remove Io_list items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Engineering_unit_list alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.engineering_unit_list') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$engineering_unit_list_found = $db->getNumRows();
		// Now check if there were any rows
		if ($engineering_unit_list_found)
		{
			// Since there are load the needed  engineering_unit_list type ids
			$engineering_unit_list_ids = $db->loadColumn();
			// Remove Engineering_unit_list from the content type table
			$engineering_unit_list_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.engineering_unit_list') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($engineering_unit_list_condition);
			$db->setQuery($query);
			// Execute the query to remove Engineering_unit_list items
			$engineering_unit_list_done = $db->execute();
			if ($engineering_unit_list_done)
			{
				// If succesfully remove Engineering_unit_list add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.engineering_unit_list) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Engineering_unit_list items from the contentitem tag map table
			$engineering_unit_list_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.engineering_unit_list') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($engineering_unit_list_condition);
			$db->setQuery($query);
			// Execute the query to remove Engineering_unit_list items
			$engineering_unit_list_done = $db->execute();
			if ($engineering_unit_list_done)
			{
				// If succesfully remove Engineering_unit_list add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.engineering_unit_list) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Engineering_unit_list items from the ucm content table
			$engineering_unit_list_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_iot.engineering_unit_list') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($engineering_unit_list_condition);
			$db->setQuery($query);
			// Execute the query to remove Engineering_unit_list items
			$engineering_unit_list_done = $db->execute();
			if ($engineering_unit_list_done)
			{
				// If succesfully remove Engineering_unit_list add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.engineering_unit_list) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Engineering_unit_list items are cleared from DB
			foreach ($engineering_unit_list_ids as $engineering_unit_list_id)
			{
				// Remove Engineering_unit_list items from the ucm base table
				$engineering_unit_list_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $engineering_unit_list_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($engineering_unit_list_condition);
				$db->setQuery($query);
				// Execute the query to remove Engineering_unit_list items
				$db->execute();

				// Remove Engineering_unit_list items from the ucm history table
				$engineering_unit_list_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $engineering_unit_list_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($engineering_unit_list_condition);
				$db->setQuery($query);
				// Execute the query to remove Engineering_unit_list items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Alarm_tag alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.alarm_tag') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$alarm_tag_found = $db->getNumRows();
		// Now check if there were any rows
		if ($alarm_tag_found)
		{
			// Since there are load the needed  alarm_tag type ids
			$alarm_tag_ids = $db->loadColumn();
			// Remove Alarm_tag from the content type table
			$alarm_tag_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.alarm_tag') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($alarm_tag_condition);
			$db->setQuery($query);
			// Execute the query to remove Alarm_tag items
			$alarm_tag_done = $db->execute();
			if ($alarm_tag_done)
			{
				// If succesfully remove Alarm_tag add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.alarm_tag) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Alarm_tag items from the contentitem tag map table
			$alarm_tag_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.alarm_tag') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($alarm_tag_condition);
			$db->setQuery($query);
			// Execute the query to remove Alarm_tag items
			$alarm_tag_done = $db->execute();
			if ($alarm_tag_done)
			{
				// If succesfully remove Alarm_tag add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.alarm_tag) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Alarm_tag items from the ucm content table
			$alarm_tag_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_iot.alarm_tag') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($alarm_tag_condition);
			$db->setQuery($query);
			// Execute the query to remove Alarm_tag items
			$alarm_tag_done = $db->execute();
			if ($alarm_tag_done)
			{
				// If succesfully remove Alarm_tag add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.alarm_tag) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Alarm_tag items are cleared from DB
			foreach ($alarm_tag_ids as $alarm_tag_id)
			{
				// Remove Alarm_tag items from the ucm base table
				$alarm_tag_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $alarm_tag_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($alarm_tag_condition);
				$db->setQuery($query);
				// Execute the query to remove Alarm_tag items
				$db->execute();

				// Remove Alarm_tag items from the ucm history table
				$alarm_tag_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $alarm_tag_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($alarm_tag_condition);
				$db->setQuery($query);
				// Execute the query to remove Alarm_tag items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Event_tag alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.event_tag') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$event_tag_found = $db->getNumRows();
		// Now check if there were any rows
		if ($event_tag_found)
		{
			// Since there are load the needed  event_tag type ids
			$event_tag_ids = $db->loadColumn();
			// Remove Event_tag from the content type table
			$event_tag_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.event_tag') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($event_tag_condition);
			$db->setQuery($query);
			// Execute the query to remove Event_tag items
			$event_tag_done = $db->execute();
			if ($event_tag_done)
			{
				// If succesfully remove Event_tag add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.event_tag) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Event_tag items from the contentitem tag map table
			$event_tag_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.event_tag') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($event_tag_condition);
			$db->setQuery($query);
			// Execute the query to remove Event_tag items
			$event_tag_done = $db->execute();
			if ($event_tag_done)
			{
				// If succesfully remove Event_tag add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.event_tag) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Event_tag items from the ucm content table
			$event_tag_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_iot.event_tag') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($event_tag_condition);
			$db->setQuery($query);
			// Execute the query to remove Event_tag items
			$event_tag_done = $db->execute();
			if ($event_tag_done)
			{
				// If succesfully remove Event_tag add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.event_tag) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Event_tag items are cleared from DB
			foreach ($event_tag_ids as $event_tag_id)
			{
				// Remove Event_tag items from the ucm base table
				$event_tag_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $event_tag_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($event_tag_condition);
				$db->setQuery($query);
				// Execute the query to remove Event_tag items
				$db->execute();

				// Remove Event_tag items from the ucm history table
				$event_tag_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $event_tag_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($event_tag_condition);
				$db->setQuery($query);
				// Execute the query to remove Event_tag items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Data_input alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.data_input') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$data_input_found = $db->getNumRows();
		// Now check if there were any rows
		if ($data_input_found)
		{
			// Since there are load the needed  data_input type ids
			$data_input_ids = $db->loadColumn();
			// Remove Data_input from the content type table
			$data_input_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.data_input') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($data_input_condition);
			$db->setQuery($query);
			// Execute the query to remove Data_input items
			$data_input_done = $db->execute();
			if ($data_input_done)
			{
				// If succesfully remove Data_input add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.data_input) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Data_input items from the contentitem tag map table
			$data_input_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.data_input') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($data_input_condition);
			$db->setQuery($query);
			// Execute the query to remove Data_input items
			$data_input_done = $db->execute();
			if ($data_input_done)
			{
				// If succesfully remove Data_input add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.data_input) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Data_input items from the ucm content table
			$data_input_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_iot.data_input') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($data_input_condition);
			$db->setQuery($query);
			// Execute the query to remove Data_input items
			$data_input_done = $db->execute();
			if ($data_input_done)
			{
				// If succesfully remove Data_input add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.data_input) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Data_input items are cleared from DB
			foreach ($data_input_ids as $data_input_id)
			{
				// Remove Data_input items from the ucm base table
				$data_input_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $data_input_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($data_input_condition);
				$db->setQuery($query);
				// Execute the query to remove Data_input items
				$db->execute();

				// Remove Data_input items from the ucm history table
				$data_input_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $data_input_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($data_input_condition);
				$db->setQuery($query);
				// Execute the query to remove Data_input items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Data_output alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.data_output') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$data_output_found = $db->getNumRows();
		// Now check if there were any rows
		if ($data_output_found)
		{
			// Since there are load the needed  data_output type ids
			$data_output_ids = $db->loadColumn();
			// Remove Data_output from the content type table
			$data_output_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.data_output') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($data_output_condition);
			$db->setQuery($query);
			// Execute the query to remove Data_output items
			$data_output_done = $db->execute();
			if ($data_output_done)
			{
				// If succesfully remove Data_output add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.data_output) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Data_output items from the contentitem tag map table
			$data_output_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.data_output') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($data_output_condition);
			$db->setQuery($query);
			// Execute the query to remove Data_output items
			$data_output_done = $db->execute();
			if ($data_output_done)
			{
				// If succesfully remove Data_output add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.data_output) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Data_output items from the ucm content table
			$data_output_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_iot.data_output') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($data_output_condition);
			$db->setQuery($query);
			// Execute the query to remove Data_output items
			$data_output_done = $db->execute();
			if ($data_output_done)
			{
				// If succesfully remove Data_output add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.data_output) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Data_output items are cleared from DB
			foreach ($data_output_ids as $data_output_id)
			{
				// Remove Data_output items from the ucm base table
				$data_output_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $data_output_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($data_output_condition);
				$db->setQuery($query);
				// Execute the query to remove Data_output items
				$db->execute();

				// Remove Data_output items from the ucm history table
				$data_output_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $data_output_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($data_output_condition);
				$db->setQuery($query);
				// Execute the query to remove Data_output items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Data_alarm alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.data_alarm') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$data_alarm_found = $db->getNumRows();
		// Now check if there were any rows
		if ($data_alarm_found)
		{
			// Since there are load the needed  data_alarm type ids
			$data_alarm_ids = $db->loadColumn();
			// Remove Data_alarm from the content type table
			$data_alarm_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.data_alarm') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($data_alarm_condition);
			$db->setQuery($query);
			// Execute the query to remove Data_alarm items
			$data_alarm_done = $db->execute();
			if ($data_alarm_done)
			{
				// If succesfully remove Data_alarm add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.data_alarm) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Data_alarm items from the contentitem tag map table
			$data_alarm_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_iot.data_alarm') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($data_alarm_condition);
			$db->setQuery($query);
			// Execute the query to remove Data_alarm items
			$data_alarm_done = $db->execute();
			if ($data_alarm_done)
			{
				// If succesfully remove Data_alarm add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.data_alarm) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Data_alarm items from the ucm content table
			$data_alarm_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_iot.data_alarm') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($data_alarm_condition);
			$db->setQuery($query);
			// Execute the query to remove Data_alarm items
			$data_alarm_done = $db->execute();
			if ($data_alarm_done)
			{
				// If succesfully remove Data_alarm add queued success message.
				$app->enqueueMessage(JText::_('The (com_iot.data_alarm) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Data_alarm items are cleared from DB
			foreach ($data_alarm_ids as $data_alarm_id)
			{
				// Remove Data_alarm items from the ucm base table
				$data_alarm_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $data_alarm_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($data_alarm_condition);
				$db->setQuery($query);
				// Execute the query to remove Data_alarm items
				$db->execute();

				// Remove Data_alarm items from the ucm history table
				$data_alarm_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $data_alarm_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($data_alarm_condition);
				$db->setQuery($query);
				// Execute the query to remove Data_alarm items
				$db->execute();
			}
		}

		// If All related items was removed queued success message.
		$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_base</b> table'));
		$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_history</b> table'));

		// Remove iot assets from the assets table
		$iot_condition = array( $db->quoteName('name') . ' LIKE ' . $db->quote('com_iot%') );

		// Create a new query object.
		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__assets'));
		$query->where($iot_condition);
		$db->setQuery($query);
		$data_alarm_done = $db->execute();
		if ($data_alarm_done)
		{
			// If succesfully remove iot add queued success message.
			$app->enqueueMessage(JText::_('All related items was removed from the <b>#__assets</b> table'));
		}

		// little notice as after service, in case of bad experience with component.
		echo '<h2>Did something go wrong? Are you disappointed?</h2>
		<p>Please let me know at <a href="mailto:Lucas@instrumentasi.id">Lucas@instrumentasi.id</a>.
		<br />We at Avar Electric are committed to building extensions that performs proficiently! You can help us, really!
		<br />Send me your thoughts on improvements that is needed, trust me, I will be very grateful!
		<br />Visit us at <a href="https://instrumentasi.id" target="_blank">https://instrumentasi.id</a> today!</p>';
	}

	/**
	 * Called on update
	 *
	 * @param   JAdapterInstance  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function update(JAdapterInstance $parent){}

	/**
	 * Called before any type of action
	 *
	 * @param   string  $type  Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function preflight($type, JAdapterInstance $parent)
	{
		// get application
		$app = JFactory::getApplication();
		// is redundant or so it seems ...hmmm let me know if it works again
		if ($type === 'uninstall')
		{
			return true;
		}
		// the default for both install and update
		$jversion = new JVersion();
		if (!$jversion->isCompatible('3.8.0'))
		{
			$app->enqueueMessage('Please upgrade to at least Joomla! 3.8.0 before continuing!', 'error');
			return false;
		}
		// do any updates needed
		if ($type === 'update')
		{
		}
		// do any install needed
		if ($type === 'install')
		{
		}
		return true;
	}

	/**
	 * Called after any type of action
	 *
	 * @param   string  $type  Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($type, JAdapterInstance $parent)
	{
		// get application
		$app = JFactory::getApplication();
		// set the default component settings
		if ($type === 'install')
		{

			// Get The Database object
			$db = JFactory::getDbo();

			// Create the board content type object.
			$board = new stdClass();
			$board->type_title = 'Iot Board';
			$board->type_alias = 'com_iot.board';
			$board->table = '{"special": {"dbtable": "#__iot_board","key": "id","type": "Board","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$board->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "metadata","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "metakey","core_metadesc": "metadesc","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"alias":"alias","name":"name","website":"website","mac_address":"mac_address","unique_code":"unique_code","description":"description","latitude":"latitude","longitude":"longitude"}}';
			$board->router = 'IotHelperRoute::getBoardRoute';
			$board->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/board.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$board_Inserted = $db->insertObject('#__content_types', $board);

			// Create the io_list content type object.
			$io_list = new stdClass();
			$io_list->type_title = 'Iot Io_list';
			$io_list->type_alias = 'com_iot.io_list';
			$io_list->table = '{"special": {"dbtable": "#__iot_io_list","key": "id","type": "Io_list","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$io_list->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "metadata","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "metakey","core_metadesc": "metadesc","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","boardname":"boardname","engineering_unit":"engineering_unit","scaling":"scaling","datatype":"datatype","description":"description","alias":"alias","io":"io","offset":"offset","gain":"gain","pointtwo":"pointtwo","pointone":"pointone","max":"max","min":"min"}}';
			$io_list->router = 'IotHelperRoute::getIo_listRoute';
			$io_list->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/io_list.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","boardname","engineering_unit","scaling","datatype","io"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "boardname","targetTable": "#__iot_board","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "engineering_unit","targetTable": "#__iot_engineering_unit_list","targetColumn": "id","displayColumn": "symbol"}]}';

			// Set the object into the content types table.
			$io_list_Inserted = $db->insertObject('#__content_types', $io_list);

			// Create the engineering_unit_list content type object.
			$engineering_unit_list = new stdClass();
			$engineering_unit_list->type_title = 'Iot Engineering_unit_list';
			$engineering_unit_list->type_alias = 'com_iot.engineering_unit_list';
			$engineering_unit_list->table = '{"special": {"dbtable": "#__iot_engineering_unit_list","key": "id","type": "Engineering_unit_list","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$engineering_unit_list->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "symbol","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","engunit":"engunit","symbol":"symbol"}}';
			$engineering_unit_list->router = 'IotHelperRoute::getEngineering_unit_listRoute';
			$engineering_unit_list->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/engineering_unit_list.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$engineering_unit_list_Inserted = $db->insertObject('#__content_types', $engineering_unit_list);

			// Create the alarm_tag content type object.
			$alarm_tag = new stdClass();
			$alarm_tag->type_title = 'Iot Alarm_tag';
			$alarm_tag->type_alias = 'com_iot.alarm_tag';
			$alarm_tag->table = '{"special": {"dbtable": "#__iot_alarm_tag","key": "id","type": "Alarm_tag","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$alarm_tag->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"ionameid":"ionameid","name":"name","alias":"alias","ll_limit_setpoint":"ll_limit_setpoint","state_text_message":"state_text_message","hh_limit_setpoint":"hh_limit_setpoint","hh_text_message":"hh_text_message","h_text_message":"h_text_message","hh_limit_enable":"hh_limit_enable","h_limit_enable":"h_limit_enable","h_limit_setpoint":"h_limit_setpoint","s_limit_setpoint":"s_limit_setpoint","ll_limit_enable":"ll_limit_enable","state_limit_enable":"state_limit_enable","low_text_message":"low_text_message","l_limit_setpoint":"l_limit_setpoint","l_limit_enable":"l_limit_enable","ll_text_message":"ll_text_message"}}';
			$alarm_tag->router = 'IotHelperRoute::getAlarm_tagRoute';
			$alarm_tag->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/alarm_tag.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","ionameid","hh_limit_enable","h_limit_enable","s_limit_setpoint","ll_limit_enable","state_limit_enable","l_limit_enable"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "ionameid","targetTable": "#__iot_io_list","targetColumn": "id","displayColumn": "symbol"}]}';

			// Set the object into the content types table.
			$alarm_tag_Inserted = $db->insertObject('#__content_types', $alarm_tag);

			// Create the event_tag content type object.
			$event_tag = new stdClass();
			$event_tag->type_title = 'Iot Event_tag';
			$event_tag->type_alias = 'com_iot.event_tag';
			$event_tag->table = '{"special": {"dbtable": "#__iot_event_tag","key": "id","type": "Event_tag","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$event_tag->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"alias":"alias","h_text_message":"h_text_message","name":"name","h_limit_enable":"h_limit_enable","h_limit_setpoint":"h_limit_setpoint","s_limit_setpoint":"s_limit_setpoint","state_text_message":"state_text_message","state_limit_enable":"state_limit_enable","low_text_message":"low_text_message","l_limit_setpoint":"l_limit_setpoint","l_limit_enable":"l_limit_enable","ionameid":"ionameid"}}';
			$event_tag->router = 'IotHelperRoute::getEvent_tagRoute';
			$event_tag->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/event_tag.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","h_limit_enable","s_limit_setpoint","state_limit_enable","l_limit_enable","ionameid"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "ionameid","targetTable": "#__iot_io_list","targetColumn": "id","displayColumn": "symbol"}]}';

			// Set the object into the content types table.
			$event_tag_Inserted = $db->insertObject('#__content_types', $event_tag);

			// Create the data_input content type object.
			$data_input = new stdClass();
			$data_input->type_title = 'Iot Data_input';
			$data_input->type_alias = 'com_iot.data_input';
			$data_input->table = '{"special": {"dbtable": "#__iot_data_input","key": "id","type": "Data_input","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$data_input->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"io_id":"io_id"}}';
			$data_input->router = 'IotHelperRoute::getData_inputRoute';
			$data_input->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/data_input.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","io_id"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$data_input_Inserted = $db->insertObject('#__content_types', $data_input);

			// Create the data_output content type object.
			$data_output = new stdClass();
			$data_output->type_title = 'Iot Data_output';
			$data_output->type_alias = 'com_iot.data_output';
			$data_output->table = '{"special": {"dbtable": "#__iot_data_output","key": "id","type": "Data_output","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$data_output->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"io_id":"io_id"}}';
			$data_output->router = 'IotHelperRoute::getData_outputRoute';
			$data_output->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/data_output.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","io_id"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$data_output_Inserted = $db->insertObject('#__content_types', $data_output);

			// Create the data_alarm content type object.
			$data_alarm = new stdClass();
			$data_alarm->type_title = 'Iot Data_alarm';
			$data_alarm->type_alias = 'com_iot.data_alarm';
			$data_alarm->table = '{"special": {"dbtable": "#__iot_data_alarm","key": "id","type": "Data_alarm","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$data_alarm->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"alarmtagid":"alarmtagid","text_value":"text_value","status_tag":"status_tag","inactive_timedate":"inactive_timedate","status_ack":"status_ack","acknowledge_timedate":"acknowledge_timedate","alarm_type":"alarm_type"}}';
			$data_alarm->router = 'IotHelperRoute::getData_alarmRoute';
			$data_alarm->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/data_alarm.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","alarmtagid","status_tag","status_ack","alarm_type"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "alarmtagid","targetTable": "#__iot_alarm_tag","targetColumn": "id","displayColumn": "symbol"}]}';

			// Set the object into the content types table.
			$data_alarm_Inserted = $db->insertObject('#__content_types', $data_alarm);


			// Install the global extenstion assets permission.
			$query = $db->getQuery(true);
			// Field to update.
			$fields = array(
				$db->quoteName('rules') . ' = ' . $db->quote('{"site.boards.access":{"1":1},"site.board.access":{"1":1}}'),
			);
			// Condition.
			$conditions = array(
				$db->quoteName('name') . ' = ' . $db->quote('com_iot')
			);
			$query->update($db->quoteName('#__assets'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$allDone = $db->execute();

			// Install the global extenstion params.
			$query = $db->getQuery(true);
			// Field to update.
			$fields = array(
				$db->quoteName('params') . ' = ' . $db->quote('{"autorName":"Lucas Manurung","autorEmail":"Lucas@instrumentasi.id","uikit_select":"1","uikit_css":"https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.9/css/uikit.min.css","uikit_js":"https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.9/js/uikit.min.js","uikit_js_icon":"https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.9/js/uikit-icons.min.js","bootstrap_select":"0","bootstrap_css":"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css","bootstrap_js":"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js","chartjs_select":"1","chart_css":"https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css","chart_js":"https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js","fonticon_select":"1","check_in":"-1 day","save_history":"1","history_limit":"10"}'),
			);
			// Condition.
			$conditions = array(
				$db->quoteName('element') . ' = ' . $db->quote('com_iot')
			);
			$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$allDone = $db->execute();

			echo '<a target="_blank" href="https://instrumentasi.id" title="IoT">
				<img src="components/com_iot/assets/images/vdm-component.jpg"/>
				</a>';
		}
		// do any updates needed
		if ($type === 'update')
		{

			// Get The Database object
			$db = JFactory::getDbo();

			// Create the board content type object.
			$board = new stdClass();
			$board->type_title = 'Iot Board';
			$board->type_alias = 'com_iot.board';
			$board->table = '{"special": {"dbtable": "#__iot_board","key": "id","type": "Board","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$board->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "metadata","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "metakey","core_metadesc": "metadesc","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"alias":"alias","name":"name","website":"website","mac_address":"mac_address","unique_code":"unique_code","description":"description","latitude":"latitude","longitude":"longitude"}}';
			$board->router = 'IotHelperRoute::getBoardRoute';
			$board->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/board.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if board type is already in content_type DB.
			$board_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($board->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$board->type_id = $db->loadResult();
				$board_Updated = $db->updateObject('#__content_types', $board, 'type_id');
			}
			else
			{
				$board_Inserted = $db->insertObject('#__content_types', $board);
			}

			// Create the io_list content type object.
			$io_list = new stdClass();
			$io_list->type_title = 'Iot Io_list';
			$io_list->type_alias = 'com_iot.io_list';
			$io_list->table = '{"special": {"dbtable": "#__iot_io_list","key": "id","type": "Io_list","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$io_list->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "metadata","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "metakey","core_metadesc": "metadesc","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","boardname":"boardname","engineering_unit":"engineering_unit","scaling":"scaling","datatype":"datatype","description":"description","alias":"alias","io":"io","offset":"offset","gain":"gain","pointtwo":"pointtwo","pointone":"pointone","max":"max","min":"min"}}';
			$io_list->router = 'IotHelperRoute::getIo_listRoute';
			$io_list->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/io_list.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","boardname","engineering_unit","scaling","datatype","io"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "boardname","targetTable": "#__iot_board","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "engineering_unit","targetTable": "#__iot_engineering_unit_list","targetColumn": "id","displayColumn": "symbol"}]}';

			// Check if io_list type is already in content_type DB.
			$io_list_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($io_list->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$io_list->type_id = $db->loadResult();
				$io_list_Updated = $db->updateObject('#__content_types', $io_list, 'type_id');
			}
			else
			{
				$io_list_Inserted = $db->insertObject('#__content_types', $io_list);
			}

			// Create the engineering_unit_list content type object.
			$engineering_unit_list = new stdClass();
			$engineering_unit_list->type_title = 'Iot Engineering_unit_list';
			$engineering_unit_list->type_alias = 'com_iot.engineering_unit_list';
			$engineering_unit_list->table = '{"special": {"dbtable": "#__iot_engineering_unit_list","key": "id","type": "Engineering_unit_list","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$engineering_unit_list->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "symbol","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","engunit":"engunit","symbol":"symbol"}}';
			$engineering_unit_list->router = 'IotHelperRoute::getEngineering_unit_listRoute';
			$engineering_unit_list->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/engineering_unit_list.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if engineering_unit_list type is already in content_type DB.
			$engineering_unit_list_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($engineering_unit_list->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$engineering_unit_list->type_id = $db->loadResult();
				$engineering_unit_list_Updated = $db->updateObject('#__content_types', $engineering_unit_list, 'type_id');
			}
			else
			{
				$engineering_unit_list_Inserted = $db->insertObject('#__content_types', $engineering_unit_list);
			}

			// Create the alarm_tag content type object.
			$alarm_tag = new stdClass();
			$alarm_tag->type_title = 'Iot Alarm_tag';
			$alarm_tag->type_alias = 'com_iot.alarm_tag';
			$alarm_tag->table = '{"special": {"dbtable": "#__iot_alarm_tag","key": "id","type": "Alarm_tag","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$alarm_tag->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"ionameid":"ionameid","name":"name","alias":"alias","ll_limit_setpoint":"ll_limit_setpoint","state_text_message":"state_text_message","hh_limit_setpoint":"hh_limit_setpoint","hh_text_message":"hh_text_message","h_text_message":"h_text_message","hh_limit_enable":"hh_limit_enable","h_limit_enable":"h_limit_enable","h_limit_setpoint":"h_limit_setpoint","s_limit_setpoint":"s_limit_setpoint","ll_limit_enable":"ll_limit_enable","state_limit_enable":"state_limit_enable","low_text_message":"low_text_message","l_limit_setpoint":"l_limit_setpoint","l_limit_enable":"l_limit_enable","ll_text_message":"ll_text_message"}}';
			$alarm_tag->router = 'IotHelperRoute::getAlarm_tagRoute';
			$alarm_tag->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/alarm_tag.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","ionameid","hh_limit_enable","h_limit_enable","s_limit_setpoint","ll_limit_enable","state_limit_enable","l_limit_enable"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "ionameid","targetTable": "#__iot_io_list","targetColumn": "id","displayColumn": "symbol"}]}';

			// Check if alarm_tag type is already in content_type DB.
			$alarm_tag_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($alarm_tag->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$alarm_tag->type_id = $db->loadResult();
				$alarm_tag_Updated = $db->updateObject('#__content_types', $alarm_tag, 'type_id');
			}
			else
			{
				$alarm_tag_Inserted = $db->insertObject('#__content_types', $alarm_tag);
			}

			// Create the event_tag content type object.
			$event_tag = new stdClass();
			$event_tag->type_title = 'Iot Event_tag';
			$event_tag->type_alias = 'com_iot.event_tag';
			$event_tag->table = '{"special": {"dbtable": "#__iot_event_tag","key": "id","type": "Event_tag","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$event_tag->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"alias":"alias","h_text_message":"h_text_message","name":"name","h_limit_enable":"h_limit_enable","h_limit_setpoint":"h_limit_setpoint","s_limit_setpoint":"s_limit_setpoint","state_text_message":"state_text_message","state_limit_enable":"state_limit_enable","low_text_message":"low_text_message","l_limit_setpoint":"l_limit_setpoint","l_limit_enable":"l_limit_enable","ionameid":"ionameid"}}';
			$event_tag->router = 'IotHelperRoute::getEvent_tagRoute';
			$event_tag->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/event_tag.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","h_limit_enable","s_limit_setpoint","state_limit_enable","l_limit_enable","ionameid"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "ionameid","targetTable": "#__iot_io_list","targetColumn": "id","displayColumn": "symbol"}]}';

			// Check if event_tag type is already in content_type DB.
			$event_tag_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($event_tag->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$event_tag->type_id = $db->loadResult();
				$event_tag_Updated = $db->updateObject('#__content_types', $event_tag, 'type_id');
			}
			else
			{
				$event_tag_Inserted = $db->insertObject('#__content_types', $event_tag);
			}

			// Create the data_input content type object.
			$data_input = new stdClass();
			$data_input->type_title = 'Iot Data_input';
			$data_input->type_alias = 'com_iot.data_input';
			$data_input->table = '{"special": {"dbtable": "#__iot_data_input","key": "id","type": "Data_input","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$data_input->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"io_id":"io_id"}}';
			$data_input->router = 'IotHelperRoute::getData_inputRoute';
			$data_input->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/data_input.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","io_id"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if data_input type is already in content_type DB.
			$data_input_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($data_input->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$data_input->type_id = $db->loadResult();
				$data_input_Updated = $db->updateObject('#__content_types', $data_input, 'type_id');
			}
			else
			{
				$data_input_Inserted = $db->insertObject('#__content_types', $data_input);
			}

			// Create the data_output content type object.
			$data_output = new stdClass();
			$data_output->type_title = 'Iot Data_output';
			$data_output->type_alias = 'com_iot.data_output';
			$data_output->table = '{"special": {"dbtable": "#__iot_data_output","key": "id","type": "Data_output","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$data_output->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"io_id":"io_id"}}';
			$data_output->router = 'IotHelperRoute::getData_outputRoute';
			$data_output->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/data_output.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","io_id"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if data_output type is already in content_type DB.
			$data_output_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($data_output->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$data_output->type_id = $db->loadResult();
				$data_output_Updated = $db->updateObject('#__content_types', $data_output, 'type_id');
			}
			else
			{
				$data_output_Inserted = $db->insertObject('#__content_types', $data_output);
			}

			// Create the data_alarm content type object.
			$data_alarm = new stdClass();
			$data_alarm->type_title = 'Iot Data_alarm';
			$data_alarm->type_alias = 'com_iot.data_alarm';
			$data_alarm->table = '{"special": {"dbtable": "#__iot_data_alarm","key": "id","type": "Data_alarm","prefix": "iotTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$data_alarm->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"alarmtagid":"alarmtagid","text_value":"text_value","status_tag":"status_tag","inactive_timedate":"inactive_timedate","status_ack":"status_ack","acknowledge_timedate":"acknowledge_timedate","alarm_type":"alarm_type"}}';
			$data_alarm->router = 'IotHelperRoute::getData_alarmRoute';
			$data_alarm->content_history_options = '{"formFile": "administrator/components/com_iot/models/forms/data_alarm.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","alarmtagid","status_tag","status_ack","alarm_type"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "alarmtagid","targetTable": "#__iot_alarm_tag","targetColumn": "id","displayColumn": "symbol"}]}';

			// Check if data_alarm type is already in content_type DB.
			$data_alarm_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($data_alarm->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$data_alarm->type_id = $db->loadResult();
				$data_alarm_Updated = $db->updateObject('#__content_types', $data_alarm, 'type_id');
			}
			else
			{
				$data_alarm_Inserted = $db->insertObject('#__content_types', $data_alarm);
			}


			echo '<a target="_blank" href="https://instrumentasi.id" title="IoT">
				<img src="components/com_iot/assets/images/vdm-component.jpg"/>
				</a>
				<h3>Upgrade to Version 1.0.21 Was Successful! Let us know if anything is not working as expected.</h3>';
		}
		return true;
	}
}
