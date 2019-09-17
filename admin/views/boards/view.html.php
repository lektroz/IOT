<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Avar Electric 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.21
	@build			17th September, 2019
	@created		20th August, 2019
	@package		IoT
	@subpackage		view.html.php
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
 * Iot View class for the Boards
 */
class IotViewBoards extends JViewLegacy
{
	/**
	 * Boards view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			IotHelper::addSubmenu('boards');
		}

		// Assign data to the view
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->user = JFactory::getUser();
		$this->listOrder = $this->escape($this->state->get('list.ordering'));
		$this->listDirn = $this->escape($this->state->get('list.direction'));
		$this->saveOrder = $this->listOrder == 'ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) JUri::getInstance()));
		// get global action permissions
		$this->canDo = IotHelper::getActions('board');
		$this->canEdit = $this->canDo->get('core.edit');
		$this->canState = $this->canDo->get('core.edit.state');
		$this->canCreate = $this->canDo->get('core.create');
		$this->canDelete = $this->canDo->get('core.delete');
		$this->canBatch = $this->canDo->get('core.batch');

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			// load the batch html
			if ($this->canCreate && $this->canEdit && $this->canState)
			{
				$this->batchDisplay = JHtmlBatch_::render();
			}
		}
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_IOT_BOARDS'), 'joomla');
		JHtmlSidebar::setAction('index.php?option=com_iot&view=boards');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('board.add');
		}

		// Only load if there are items
		if (IotHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('board.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('boards.publish');
				JToolBarHelper::unpublishList('boards.unpublish');
				JToolBarHelper::archiveList('boards.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('boards.checkin');
				}
			}

			// Add a batch button
			if ($this->canBatch && $this->canCreate && $this->canEdit && $this->canState)
			{
				// Get the toolbar object instance
				$bar = JToolBar::getInstance('toolbar');
				// set the batch button name
				$title = JText::_('JTOOLBAR_BATCH');
				// Instantiate a new JLayoutFile instance and render the batch button
				$layout = new JLayoutFile('joomla.toolbar.batch');
				// add the button to the page
				$dhtml = $layout->render(array('title' => $title));
				$bar->appendButton('Custom', $dhtml, 'batch');
			}

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				JToolbarHelper::deleteList('', 'boards.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('boards.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('board.export'))
			{
				JToolBarHelper::custom('boards.exportData', 'download', '', 'COM_IOT_EXPORT_DATA', true);
			}
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('board.import'))
		{
			JToolBarHelper::custom('boards.importData', 'upload', '', 'COM_IOT_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = IotHelper::getHelpUrl('boards');
		if (IotHelper::checkString($help_url))
		{
				JToolbarHelper::help('COM_IOT_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_iot');
		}

		if ($this->canState)
		{
			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
			);
			// only load if batch allowed
			if ($this->canBatch)
			{
				JHtmlBatch_::addListSelection(
					JText::_('COM_IOT_KEEP_ORIGINAL_STATE'),
					'batch[published]',
					JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('all' => false)), 'value', 'text', '', true)
				);
			}
		}

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_ACCESS'),
			'filter_access',
			JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
		);

		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			JHtmlBatch_::addListSelection(
				JText::_('COM_IOT_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
		}

		// Set Mac Address Selection
		$this->mac_addressOptions = $this->getTheMac_addressSelections();
		// We do some sanitation for Mac Address filter
		if (IotHelper::checkArray($this->mac_addressOptions) &&
			isset($this->mac_addressOptions[0]->value) &&
			!IotHelper::checkString($this->mac_addressOptions[0]->value))
		{
			unset($this->mac_addressOptions[0]);
		}
		// Only load Mac Address filter if it has values
		if (IotHelper::checkArray($this->mac_addressOptions))
		{
			// Mac Address Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_IOT_BOARD_MAC_ADDRESS_LABEL').' -',
				'filter_mac_address',
				JHtml::_('select.options', $this->mac_addressOptions, 'value', 'text', $this->state->get('filter.mac_address'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Mac Address Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_IOT_BOARD_MAC_ADDRESS_LABEL').' -',
					'batch[mac_address]',
					JHtml::_('select.options', $this->mac_addressOptions, 'value', 'text')
				);
			}
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		if (!isset($this->document))
		{
			$this->document = JFactory::getDocument();
		}
		$this->document->setTitle(JText::_('COM_IOT_BOARDS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_iot/assets/css/boards.css", (IotHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		if(strlen($var) > 50)
		{
			// use the helper htmlEscape method instead and shorten the string
			return IotHelper::htmlEscape($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return IotHelper::htmlEscape($var, $this->_charset);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields()
	{
		return array(
			'a.sorting' => JText::_('JGRID_HEADING_ORDERING'),
			'a.published' => JText::_('JSTATUS'),
			'a.name' => JText::_('COM_IOT_BOARD_NAME_LABEL'),
			'a.mac_address' => JText::_('COM_IOT_BOARD_MAC_ADDRESS_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	protected function getTheMac_addressSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('mac_address'));
		$query->from($db->quoteName('#__iot_board'));
		$query->order($db->quoteName('mac_address') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $mac_address)
			{
				// Now add the mac_address and its text to the options array
				$_filter[] = JHtml::_('select.option', $mac_address, $mac_address);
			}
			return $_filter;
		}
		return false;
	}
}
