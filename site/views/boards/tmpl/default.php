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
<form action="<?php echo JRoute::_('index.php?option=com_iot'); ?>" method="post" name="adminForm" id="adminForm">
<?php echo $this->toolbar->render(); ?><?php foreach ($this->items as $item): ?>
 <?php echo $item->id; ?> <?php echo $item->asset_id; ?>
 <?php echo $item->website; ?> 
<?php echo $item->mac_address; ?> 
<?php echo $item->unique_code; ?>
 <?php echo $item->latitude; ?> 
<?php echo $item->longitude; ?>
 <?php echo $item->description; ?> 

<a href="<?php echo  IotHelperRoute::getBoardRoute($item->id); ?>" >

<?php echo $item->name; ?>

</a> 
<?php echo $item->alias; ?> 
<?php echo $item->published; ?>
 <?php echo $item->created_by; ?>
 <?php echo $item->modified_by; ?> 
<?php echo $item->created; ?>
 <?php echo $item->modified; ?>
 <?php echo $item->version; ?>
 <?php echo $item->hits; ?> 
<?php echo $item->ordering; ?> 
</br>
<?php endforeach; ?>




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
