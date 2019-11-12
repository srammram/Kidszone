<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-12">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("groups/edit/".$group_id, $attrib);
                ?>
        <div class="row">

        <fieldset class="scheduler-border">
					<legend class="scheduler-border"> <?= lang("General information", "General information"); ?></legend>
        <?php if(empty($this->data['result'])) { ?>

					<div class="col-md-12">
						<div class="col-md-6">formone</div>
						<div class="col-md-6">
            			<input type="checkbox" name="formone" id="formone"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-6">add_formone</div>
						<div class="col-md-6">
            			<input type="checkbox" name="add_formone" id="add_formone"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-6">formtwo</div>
						<div class="col-md-6">
            			<input type="checkbox" name="formtwo" id="formtwo"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-6">add_formtwo</div>
						<div class="col-md-6">
            			<input type="checkbox" name="add_formtwo" id="add_formtwo"></div>
					</div>

					<div class="col-md-12">
						<div class="col-md-6">formthree</div>
						<div class="col-md-6">
            			<input type="checkbox" name="formthree" id="formthree"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-6">add_formthree</div>
						<div class="col-md-6">
            			<input type="checkbox" name="add_formthree" id="add_formthree"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-6">farmer</div>
						<div class="col-md-6">
            		<input type="checkbox" name="farmer" id="farmer"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-6">add_farmer</div>
						<div class="col-md-6">
            			<input type="checkbox" name="add_farmer" id="add_farmer"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-6">vendor</div>
						<div class="col-md-6">
            			<input type="checkbox" name="vendor" id="vendor"></div>
					</div>
        <?php } else { ?>

          <?php 
          $i = 0;
            foreach($result as $key => $value) {
              if($i>1) {
              ?>
					<div class="col-md-12">
						<div class="col-md-6"><?php echo $key; ?></div>
						<div class="col-md-6">
            			<input type="checkbox" name="<?php echo $key; ?>" id="<?php echo $key; ?>" <?php echo ($value==1) ? 'checked': FALSE; ?>>&nbsp;</div>
					</div>
          <?php }
          $i++;
          } ?>

        <?php } ?>
        </fieldset>
        </div>
        <div class="col-sm-12 last_sa_se"><?php echo form_submit('insert_permission', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>