<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-12">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("farmer/edit_farmer/".$id, $attrib);
                ?>
        <div class="row">
        	
                
        	<fieldset class="scheduler-border">
					<legend class="scheduler-border"> <?= lang("General information", "General information"); ?></legend>

					<div class="form-group col-md-12">
							<div class="col-md-4">
								<label class="container-checkbox">Father Name
								  <input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==1 ? 'checked': FALSE; ?> disabled>
								</label>
							</div>
							<div class="col-md-4">
								<label class="container-checkbox">Mother Name
								  <input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==2 ? 'checked': FALSE; ?> disabled>
								</label>
							</div>
							<div class="col-md-4">
								<label class="container-checkbox">Others
								  <input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==3 ? 'checked': FALSE; ?> disabled>
								</label>
							</div>
					</div>

					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Father Name </label>
								<input type="text" class="form-control" name="father_name" id="father_name" value="<?= $result->father_name ?>" required readonly>
							</div>
							<div class="form-group">
								<label class="label_green">Email</label>
								<input type="text" class="form-control" name="email" id="email"   value="<?= $result->email ?>" required readonly>
							</div>
						</div>
						<div class="col-md-6">

							<div class="form-group">
								<label class="label_green">Mother Name</label>
								<input type="text" class="form-control" name="mother_name" id="mother_name"  value="<?= $result->mother_name ?>" readonly>
							</div>
							<div class="form-group">
								<label class="label_green">Phone Number</label>
								<input type="text" class="form-control" name="phone" value="<?= $result->phone_number ?>" id="phone" required readonly>
							</div>
							<div class="form-group">
								<label class="label_green">Others Name</label>
								<input type="text" class="form-control" name="phone" value="<?= $result->others_name ?>" id="phone" required readonly>
							</div>
							<div class="form-group">
								<label class="label_green">Teacher Name</label>
								<input type="text" class="form-control" name="phone" value="<?= $result->teacher_name ?>" id="phone" required readonly>
							</div>
						</div>
					</div>
				</fieldset>
                
            <fieldset class="scheduler-border">
					<legend class="scheduler-border"> <?= lang("Kids Name", "Kids Name"); ?></legend>
					<div class="col-md-12">
					<div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Kid Name 1</label>
								<input type="text" class="form-control"  value="<?= $result->kid_name1 ?>" required readonly>
							</div>
							<div class="form-group">
								<label class="label_green">Kid Name 3</label>
								<input type="text" class="form-control" value="<?= $result->kid_name3 ?>" required readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Kid Name 2</label>
								<input type="text" class="form-control" value="<?= $result->kid_name2 ?>" readonly>
							</div>
							<div class="form-group">
								<label class="label_green">Kid Name 4</label>
								<input type="text" class="form-control" value="<?= $result->kid_name4 ?>" required readonly>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="label_green">Kid Name 5</label>
								<input type="text" class="form-control" value="<?= $result->kid_name5 ?>" readonly>
							</div>
							<div class="form-group">
								<label class="label_green">No of kids</label>
								<input type="text" class="form-control" value="<?= $result->no_of_kids ?>" readonly>
							</div>
						</div>

						<div class="col-md-6">

							<div class="form-group">
								<label class="label_green">Kid Name 6</label>
								<input type="text" class="form-control" value="<?= $result->kid_name6 ?>" required readonly>
							</div>
						</div>

					</div>
				</fieldset>
                
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Image</legend>
                <div class="col-md-12">
                    <div class="col-md-6">
						<div class="form-group ">
							<label class="label_green">Photo</label>
							<div class="clear"></div>			
							<input type="image" src="<?=base_url()?>assets/uploads/<?= !empty($result->photo) ? $result->photo : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
						</div>
                    </div>
                    <div class="col-md-6">
						<div class="form-group ">
							<label class="label_green">Signature</label>
							<div class="clear"></div>			
							<input type="image" src="<?=base_url()?>assets/uploads/<?= !empty($result->signature) ? $result->signature : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
						</div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Date</legend>
                <div class="col-md-12">
                    <div class="col-md-6">
						<div class="form-group ">
							<label class="label_green"></label>
							<div class="clear"></div>
							<input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($result->reg_date)) ?>" required readonly>
						</div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">I agree to follow the rules</legend>
                <div class="col-md-12">
                    <div class="col-md-6">
						<div class="form-group ">
							<label class="label_green"></label>
							<div class="clear"></div>			
							<input type="checkbox" name="accept" id="accept" <?= $result->accept==1 ? 'checked': FALSE; ?> disabled>
						</div>
                    </div>
                </div>
            </fieldset>
            
            
        </div>
        <div class="col-sm-12 last_sa_se"><?php //echo form_submit('edit_farmer', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>

