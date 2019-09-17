<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Avar Electric 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.21
	@build			17th September, 2019
	@created		20th August, 2019
	@package		IoT
	@subpackage		default_panel.php
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
<?php $io_lists = iothelper::get_IO_list($this->item->id); ?>

  <?php $i=0; ?>
  <h5 class="card-header"><?php echo $this->item->name; ?></h5>
    
    <?php 
	foreach($io_lists as $io_list){ var_dump($i % 3)?>
	  
		<?php if ( $i % 3 == 0) { ?>
		<div class="row">
		<?php } ?>
	<?php
	//0|Output,1|Input
		if($io_list['io'] == 1){
			?><div class="span4"><div class="well">
			<h3 class="page-header"><?php echo $io_list['name'] ?></h3>
			<?php
			//0|Integer,1|Float,2|String,3|Boolean
			if($io_list['datatype']==0 || $io_list['datatype']==1 ){ ?>
				<input type="range" class="form-control-range" name=" <?php echo 'iotinprng_'.$io_list['id'] ?>" min="<?php echo $io_list['min']?>" max="<?php echo $io_list['max']?>" id="formControlRange" attrid="<? php echo $io_list['id'] ?>">
				<input type="text" class="form-control" name="<?php echo 'iotinp_'.$io_list['id'] ?>" attrid="<? php echo $io_list['id'] ?>">
				<button type="button" class="btn btn-primary" name="<?php echo 'iotinpbtn_'.$io_list['id'] ?>" attrid="<? php echo $io_list['id'] ?>">Submit</button>
		
			<?php }	
			
			if($io_list['datatype']==2){ ?>
				<input type="text" class="form-control" name="<?php echo 'iotinp_'.$io_list['id'] ?>" attrid="<? php echo $io_list['id'] ?>">
				<button type="button" class="btn btn-primary" name=" <?php echo 'iotinpbtn_'.$io_list['id'] ?>" attrid="<? php echo $io_list['id'] ?>">Submit</button>
			<?php }	
			
			if($io_list['datatype']==3){ ?>
				<button type="button" class="btn btn-primary" name=" <?php echo 'iotbtn_'.$io_list['id'] ?>" attrid="<? php echo $io_list['id'] ?>">ON</button>
			<?php }	
			?></div></div><?php
		}
		
		
		
		if($io_list['io'] == 0){
			?><div class="span4"><div class="well">
			<h3 class="page-header"><?php echo $io_list['name'] ?></h3>
			<?php
			$value = iothelper::get_last_value($io_list['alias']);
		
		$value = iothelper::convDT($io_list['datatype'], $value);
			
			//$percent = ($value+0)/($io_list['max'] - $io_list['min']);
			$percent = ($value+0)/100;
			
			if($io_list['datatype']==0 || $io_list['datatype']==1){ ?>
				<h4 class="card-title"><?php echo $value ?></h4>

			<?php }
			
			if($io_list['datatype']==2){ ?>
				<h4 class="card-title"><?php echo $value ?></h4>	
			<?php }
			
			if($io_list['datatype']==3){ ?>
				<?php if($value == 1){ ?>
					<button type="button" class="btn btn-success" disabled="">On</button>
				<?php }?>
				<?php if($value == o){ ?>
					<button type="button" class="btn btn-dark" disabled="">Off</button>
				<?php }?>
			<?php 
		    }
			?></div></div><?php
	    }
		
		?> 
		<?php if ( $i % 3 == 2){ ?> </div> <?php }
		$i++;
		?>
<?php }	?>
   <p class="card-text"><?php echo $this->item->description; ?></p>

