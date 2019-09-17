<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Avar Electric 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.21
	@build			17th September, 2019
	@created		20th August, 2019
	@package		IoT
	@subpackage		default.php
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

?>
<?php echo $this->toolbar->render(); ?>
	<?php
        $getApp = JFactory::getApplication();
	$dataArr = $getApp->input->get->getArray();
	$dataObj = new stdClass();
	$aliasArr = array();
	$mac_address='';
	$board='';
	$keyapi='';
	$view='';
	$callback='';
	$token='';

	foreach($dataArr as $key=>$value){
		if($key=='board'){
			 $board= strval($value);
			 var_dump('board: ',$board);
			 continue;
		}
		if($key=='key'){
			 $keyapi = strval($value);
			 var_dump('keyapi: ',$keyapi );
			 continue;
		}
		if($key=='mac_address'){
			 $mac_address = strval($value);
			 var_dump('mcadress: ',$mac_address );
			 continue;
		}
		if($key=='com'){
			 $com = strval($value);
			 var_dump('com: ',$com );
			 continue;
		}
		if($key=='view'){
			 $view = strval($value);
			 var_dump('view: ',$view );
			 continue;
		}
		if($key=='callback'){
			 $callback = strval($value);
			 continue;
		}
		if($key=='token'){
			 $token = strval($value);
			 continue;
		}
		$dataObj->$key = strval($value);
		$aliasArr[]=$key;
	}
	$dataObj->created = date("Y-m-d H:i:s");
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select(array('id','unique_code','mac_address'));
	$query->from($db->quoteName('#__iot_board'));
	$query->where($db->quoteName('alias')." = ".$db->quote($board));

	$db->setQuery($query);
	$boards = $db->loadObject();
	
	$dbmac_address = strval($boards->mac_address);
	$dbunique_code = strval($boards->unique_code);


	if(empty($dbmac_address) && empty($mac_address) ){
		
		if($dbmac_address == $mac_address ){
			if($dbunique_code == $keyapi ){
				$result = JFactory::getDbo()->insertObject('#__iot_data_output', $dataObj);
				iotHelper::updateAlarmList($dataObj,$aliasArr);
                                iotHelper::insertEventLog($dataObj,$aliasArr);
				
				if ($db->getErrorNum()){
					JLog::add($db->getErrorMsg(), JLog::ERROR, 'Get Data Error');
				}
			}else{
				JLog::add('Error key code', JLog::ERROR, 'Get Data Error');
			}
		}else{
			JLog::add('Error mac address code', JLog::ERROR, 'Get Data Error');
		}
	}else{
		JLog::add('Error mac address code', JLog::ERROR, 'Get Data Error');
	}
?>
