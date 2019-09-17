<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Avar Electric 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.21
	@build			17th September, 2019
	@created		20th August, 2019
	@package		IoT
	@subpackage		edit.php
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

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$componentParams = $this->params; // will be removed just use $this->params instead
?>
<script type="text/javascript">
	// waiting spinner
	var outerDiv = jQuery('body');
	jQuery('<div id="loading"></div>')
		.css("background", "rgba(255, 255, 255, .8) url('components/com_iot/assets/images/import.gif') 50% 15% no-repeat")
		.css("top", outerDiv.position().top - jQuery(window).scrollTop())
		.css("left", outerDiv.position().left - jQuery(window).scrollLeft())
		.css("width", outerDiv.width())
		.css("height", outerDiv.height())
		.css("position", "fixed")
		.css("opacity", "0.80")
		.css("-ms-filter", "progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)")
		.css("filter", "alpha(opacity = 80)")
		.css("display", "none")
		.appendTo(outerDiv);
	jQuery('#loading').show();
	// when page is ready remove and show
	jQuery(window).load(function() {
		jQuery('#iot_loader').fadeIn('fast');
		jQuery('#loading').hide();
	});
</script>
<div id="iot_loader" style="display: none;">
<form action="<?php echo JRoute::_('index.php?option=com_iot&layout=edit&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

	<?php echo JLayoutHelper::render('io_list.main_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'io_listTab', array('active' => 'main')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'io_listTab', 'main', JText::_('COM_IOT_IO_LIST_MAIN', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('io_list.main_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('io_list.main_right', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'io_listTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.state') || $this->canDo->get('core.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'io_listTab', 'publishing', JText::_('COM_IOT_IO_LIST_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('io_list.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('io_list.metadata', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'io_listTab', 'permissions', JText::_('COM_IOT_IO_LIST_PERMISSION', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<fieldset class="adminform">
					<div class="adminformlist">
					<?php foreach ($this->form->getFieldset('accesscontrol') as $field): ?>
						<div>
							<?php echo $field->label; echo $field->input;?>
						</div>
						<div class="clearfix"></div>
					<?php endforeach; ?>
					</div>
				</fieldset>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	<div>
		<input type="hidden" name="task" value="io_list.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>
</form>
</div>

<script type="text/javascript">
/*jQuery('.control-wrapper-pointone').hide();jQuery('.control-wrapper-pointtwo').hide();jQuery('.control-wrapper-gain').hide();jQuery('.control-wrapper-offset').hide();jQuery('#jform_scaling').change(function(){if(jQuery(this).val()==0){jQuery('.control-wrapper-pointone').hide();jQuery('.control-wrapper-pointtwo').hide();jQuery('.control-wrapper-gain').hide();jQuery('.control-wrapper-offset').hide()}
if(jQuery(this).val()==1){jQuery('.control-wrapper-pointone').show();jQuery('.control-wrapper-pointtwo').show();jQuery('.control-wrapper-gain').hide();jQuery('.control-wrapper-offset').hide()}
if(jQuery(this).val()==2){jQuery('.control-wrapper-pointone').hide();jQuery('.control-wrapper-pointtwo').hide();jQuery('.control-wrapper-gain').show();jQuery('.control-wrapper-offset').show()}});*./
</script>
