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

//custom view script

?>
<form action="<?php echo JRoute::_('index.php?option=com_iot'); ?>" method="post" name="adminForm" id="adminForm">
<?php echo $this->toolbar->render(); ?><?php

$app = JFactory::getApplication();
 $menuitem   = $app->getMenu()->getActive(); // get the active item
 //$menuitem   = $app->getMenu()->getItem($theid); // or get item by ID
 $params = $menuitem->params; // get the params
var_dump($params); // print all params as overview
?>
<?php echo $this->item->id; ?> 
<?php echo $this->item->asset_id; ?> 
<?php echo $this->item->website; ?> 
<?php echo $this->item->mac_address; ?>
 <?php echo $this->item->unique_code; ?>
 <?php echo $this->item->latitude; ?>
<?php echo $this->item->longitude; ?>
 <?php echo $this->item->description; ?> 
<?php echo $this->item->name; ?> 
<?php echo $this->item->alias; ?> 
<?php echo $this->item->published; ?>
 <?php echo $this->item->created_by; ?>
 <?php echo $this->item->modified_by; ?> 
<?php echo $this->item->created; ?> 
<?php echo $this->item->modified; ?> 
<?php echo $this->item->version; ?>
 <?php echo $this->item->hits; ?> 
<?php echo $this->item->ordering; ?>

<?php echo $this->loadTemplate('panel'); ?>



<?php if (isset($this->items) && isset($this->pagination) && isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1): ?>
	<div class="pagination">
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> <?php echo $this->pagination->getLimitBox(); ?></p>
		<?php endif; ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
<?php endif; ?>
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>
