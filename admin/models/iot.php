<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Avar Electric 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.21
	@build			17th September, 2019
	@created		20th August, 2019
	@package		IoT
	@subpackage		iot.php
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
 * Iot Model
 */
class IotModelIot extends JModelList
{
	public function getIcons()
	{
		// load user for access menus
		$user = JFactory::getUser();
		// reset icon array
		$icons  = array();
		// view groups array
		$viewGroups = array(
			'main' => array('png.boards', 'png.io_lists', 'png.engineering_unit_lists', 'png.alarm_tags', 'png.event_tags', 'png.data_inputs', 'png.data_outputs')
		);
		// view access array
		$viewAccess = array(
			'boards.access' => 'board.access',
			'board.access' => 'board.access',
			'boards.submenu' => 'board.submenu',
			'boards.dashboard_list' => 'board.dashboard_list',
			'io_lists.access' => 'io_list.access',
			'io_list.access' => 'io_list.access',
			'io_lists.submenu' => 'io_list.submenu',
			'io_lists.dashboard_list' => 'io_list.dashboard_list',
			'engineering_unit_lists.access' => 'engineering_unit_list.access',
			'engineering_unit_list.access' => 'engineering_unit_list.access',
			'engineering_unit_lists.submenu' => 'engineering_unit_list.submenu',
			'engineering_unit_lists.dashboard_list' => 'engineering_unit_list.dashboard_list',
			'alarm_tags.access' => 'alarm_tag.access',
			'alarm_tag.access' => 'alarm_tag.access',
			'alarm_tags.submenu' => 'alarm_tag.submenu',
			'alarm_tags.dashboard_list' => 'alarm_tag.dashboard_list',
			'event_tags.access' => 'event_tag.access',
			'event_tag.access' => 'event_tag.access',
			'event_tags.submenu' => 'event_tag.submenu',
			'event_tags.dashboard_list' => 'event_tag.dashboard_list',
			'data_inputs.access' => 'data_input.access',
			'data_input.access' => 'data_input.access',
			'data_inputs.submenu' => 'data_input.submenu',
			'data_inputs.dashboard_list' => 'data_input.dashboard_list',
			'data_outputs.access' => 'data_output.access',
			'data_output.access' => 'data_output.access',
			'data_outputs.submenu' => 'data_output.submenu',
			'data_outputs.dashboard_list' => 'data_output.dashboard_list',
			'data_alarms.access' => 'data_alarm.access',
			'data_alarm.access' => 'data_alarm.access',
			'data_alarms.submenu' => 'data_alarm.submenu');
		// loop over the $views
		foreach($viewGroups as $group => $views)
		{
			$i = 0;
			if (IotHelper::checkArray($views))
			{
				foreach($views as $view)
				{
					$add = false;
					// external views (links)
					if (strpos($view,'||') !== false)
					{
						$dwd = explode('||', $view);
						if (count($dwd) == 3)
						{
							list($type, $name, $url) = $dwd;
							$viewName 	= $name;
							$alt 		= $name;
							$url 		= $url;
							$image 		= $name.'.'.$type;
							$name 		= 'COM_IOT_DASHBOARD_'.IotHelper::safeString($name,'U');
						}
					}
					// internal views
					elseif (strpos($view,'.') !== false)
					{
						$dwd = explode('.', $view);
						if (count($dwd) == 3)
						{
							list($type, $name, $action) = $dwd;
						}
						elseif (count($dwd) == 2)
						{
							list($type, $name) = $dwd;
							$action = false;
						}
						if ($action)
						{
							$viewName = $name;
							switch($action)
							{
								case 'add':
									$url 	= 'index.php?option=com_iot&view='.$name.'&layout=edit';
									$image 	= $name.'_'.$action.'.'.$type;
									$alt 	= $name.'&nbsp;'.$action;
									$name	= 'COM_IOT_DASHBOARD_'.IotHelper::safeString($name,'U').'_ADD';
									$add	= true;
								break;
								default:
									$url 	= 'index.php?option=com_categories&view=categories&extension=com_iot.'.$name;
									$image 	= $name.'_'.$action.'.'.$type;
									$alt 	= $name.'&nbsp;'.$action;
									$name	= 'COM_IOT_DASHBOARD_'.IotHelper::safeString($name,'U').'_'.IotHelper::safeString($action,'U');
								break;
							}
						}
						else
						{
							$viewName 	= $name;
							$alt 		= $name;
							$url 		= 'index.php?option=com_iot&view='.$name;
							$image 		= $name.'.'.$type;
							$name 		= 'COM_IOT_DASHBOARD_'.IotHelper::safeString($name,'U');
							$hover		= false;
						}
					}
					else
					{
						$viewName 	= $view;
						$alt 		= $view;
						$url 		= 'index.php?option=com_iot&view='.$view;
						$image 		= $view.'.png';
						$name 		= ucwords($view).'<br /><br />';
						$hover		= false;
					}
					// first make sure the view access is set
					if (IotHelper::checkArray($viewAccess))
					{
						// setup some defaults
						$dashboard_add = false;
						$dashboard_list = false;
						$accessTo = '';
						$accessAdd = '';
						// acces checking start
						$accessCreate = (isset($viewAccess[$viewName.'.create'])) ? IotHelper::checkString($viewAccess[$viewName.'.create']):false;
						$accessAccess = (isset($viewAccess[$viewName.'.access'])) ? IotHelper::checkString($viewAccess[$viewName.'.access']):false;
						// set main controllers
						$accessDashboard_add = (isset($viewAccess[$viewName.'.dashboard_add'])) ? IotHelper::checkString($viewAccess[$viewName.'.dashboard_add']):false;
						$accessDashboard_list = (isset($viewAccess[$viewName.'.dashboard_list'])) ? IotHelper::checkString($viewAccess[$viewName.'.dashboard_list']):false;
						// check for adding access
						if ($add && $accessCreate)
						{
							$accessAdd = $viewAccess[$viewName.'.create'];
						}
						elseif ($add)
						{
							$accessAdd = 'core.create';
						}
						// check if acces to view is set
						if ($accessAccess)
						{
							$accessTo = $viewAccess[$viewName.'.access'];
						}
						// set main access controllers
						if ($accessDashboard_add)
						{
							$dashboard_add	= $user->authorise($viewAccess[$viewName.'.dashboard_add'], 'com_iot');
						}
						if ($accessDashboard_list)
						{
							$dashboard_list = $user->authorise($viewAccess[$viewName.'.dashboard_list'], 'com_iot');
						}
						if (IotHelper::checkString($accessAdd) && IotHelper::checkString($accessTo))
						{
							// check access
							if($user->authorise($accessAdd, 'com_iot') && $user->authorise($accessTo, 'com_iot') && $dashboard_add)
							{
								$icons[$group][$i]			= new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						elseif (IotHelper::checkString($accessTo))
						{
							// check access
							if($user->authorise($accessTo, 'com_iot') && $dashboard_list)
							{
								$icons[$group][$i]			= new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						elseif (IotHelper::checkString($accessAdd))
						{
							// check access
							if($user->authorise($accessAdd, 'com_iot') && $dashboard_add)
							{
								$icons[$group][$i]			= new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						else
						{
							$icons[$group][$i]			= new StdClass;
							$icons[$group][$i]->url 	= $url;
							$icons[$group][$i]->name 	= $name;
							$icons[$group][$i]->image 	= $image;
							$icons[$group][$i]->alt 	= $alt;
						}
					}
					else
					{
						$icons[$group][$i]			= new StdClass;
						$icons[$group][$i]->url 	= $url;
						$icons[$group][$i]->name 	= $name;
						$icons[$group][$i]->image 	= $image;
						$icons[$group][$i]->alt 	= $alt;
					}
					$i++;
				}
			}
			else
			{
					$icons[$group][$i] = false;
			}
		}
		return $icons;
	}
}
