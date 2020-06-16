<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off"); echo admin_form_open_multipart("outlet/edit_outlet/".$id, $attrib); ?>

<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-12">

        <div class="row">

		<fieldset class="scheduler-border">
					<legend class="scheduler-border">  <?= lang("General information", "General information"); ?></legend>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green" >Name </label>
								<input type="text" class="form-control" name="name" id="name"  value="<?= $result->name ?>" required readonly>
							</div>

						</div>
					</div>


				</fieldset>

        </div>
         </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>