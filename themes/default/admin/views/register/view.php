<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="<?= $assets ?>styles/jquery.mCustomScrollbar.css" rel="stylesheet"/>
<script src="<?= $assets ?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-12 kidszoona">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("farmer/edit_farmer/".$id, $attrib);
                ?>
						<div class="col-md-12 text-center">
							<img src="<?=base_url()?>assets/uploads/logos/logo_inner.png" alt="kidszoona">
						</div>
						<div class="col-md-12 kidszon_content">
							<h3>Dear all customers</h3>
							<p>Here is a place did not have to control the behavior of children.</p>
							<p><b>For the safety of your child, we must comply with the follow wing our message.</b></p>
							<div class="col-md-12 kids_zon_c">
								<h4>Procedure </h4>
								<div class="show_hidden">
									<strong>More Details <span>[+]</span></strong>
								</div>
								<ul class="hidden_content" style="display: none;">
									<li>For the safety of the child parents (from 18 years old) should get in together with child.</li>
									<li>The parents must responsible every action of your child and control, take care of your child.</li>
									<li>Parent must ensure that children follow the rules of the shop.</li>
									<li>Do not run inside Kizooona zone owing to potential dangers of fallsor injuries from a collision with another customer.</li>
									<li>If children play severe action. Be careful not to collide with other children.</li>
									<li>Please remove the jewelry out of the children first enter the store. This may cause injury to the body or clothing to another customer.</li>
									<li>Please use shoes rack to store shoes and be maintained by yourself. If you lost your shoes, store can’t take responsibility.</li>
									<li>Cases are temporary and come again, must be doing as defined.</li>
									<li>When inside, please pay attention and follow our staff advice. The placard and other rules that are listed.</li>
								</ul>
							</div>
							<div class="col-md-12 kids_zon_c">
								<h4>Prohibition</h4>
								<div class="show_hidden1">
									<strong>More Details <span>[+]</span></strong>
								</div>
								<ul class="hidden_content1" style="display: none;">
									<li>This shop not allowed for the children from 11 year old.</li>
									<li>When patient is contagious cough, mucous, skin disease, wound or health condition is good for any reason.</li>
									<li>Please come back to use our service on the next time. This may cause a negative on other customers.</li>
									<li>The parents cannot sleep or other in the Kidzooona zone this is stumbling block to control children.</li>
									<li>Do not eat or drink inside Kidzooona zone except point of specifically defined only.</li>
									<li>Please park baby strollers at the point of service.</li>
									<li>Do not affect the health of an environment (Vomit, hawk, feces, urinate) inside Kidzooona zone, if it happens suddenly please be inform to the staff.</li>
									<li>Do not bring toys or other items in our store.</li>
								</ul>
							</div>
							<div class="col-md-12 kids_zon_c">
								<h4>Other</h4>
								<div class="show_hidden2">
									<strong>More Details <span>[+]</span></strong>
								</div>
								<ul class="hidden_content2" style="display: none;">
									<li>We are not responsible for any accidents trauma or lost items inside the store.</li>
									<li>If not follow up with our staff and rules that staff cannot maintain the security and reliability in store.</li>
									<li>May asked to leave the store.</li>
									<li>We have a policy for children under one year old entry this Kidzooona zone without charge.</li>
								</ul>
							</div>
						</div>
						<div class="col-md-12 col-xs-12">
							<h3><?= lang("General information", "General information"); ?></h3>
							<h4 class="text-left">Parent name: (Age over 18 years old)</h4>
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
									<div class="form-group col-md-12">
										<label class="label_green">Father Name </label>
										<input type="text" class="form-control" name="father_name" id="father_name" value="<?= $result->father_name ?>" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">Email</label>
										<input type="text" class="form-control" name="email" id="email"   value="<?= $result->email ?>" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">Mother Name</label>
										<input type="text" class="form-control" name="mother_name" id="mother_name"  value="<?= $result->mother_name ?>" readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">Phone Number</label>
										<input type="text" class="form-control" name="phone" value="<?= $result->phone_number ?>" id="phone" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">Others Name</label>
										<input type="text" class="form-control" name="phone" value="<?= $result->others_name ?>" id="phone" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">Teacher Name</label>
										<input type="text" class="form-control" name="phone" value="<?= $result->teacher_name ?>" id="phone" required readonly>
									</div>
						
								<h3><?= lang("Kids Name", "Kids Name"); ?></h3>
									<div class="form-group col-md-12">
										<label class="label_green">Kid Name 1</label>
										<input type="text" class="form-control"  value="<?= $result->kid_name1 ?>" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">Kid Name 3</label>
										<input type="text" class="form-control" value="<?= $result->kid_name3 ?>" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">Kid Name 2</label>
										<input type="text" class="form-control" value="<?= $result->kid_name2 ?>" readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">Kid Name 4</label>
										<input type="text" class="form-control" value="<?= $result->kid_name4 ?>" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">Kid Name 5</label>
										<input type="text" class="form-control" value="<?= $result->kid_name5 ?>" readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">No of kids</label>
										<input type="text" class="form-control" value="<?= $result->no_of_kids ?>" readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">Kid Name 6</label>
										<input type="text" class="form-control" value="<?= $result->kid_name6 ?>" required readonly>
									</div>
							<h3>Image</h3>
								<div class="form-group col-md-6">
									<label class="label_green">Photo</label>
									<div class="clear"></div>			
									<input type="image" src="<?=base_url()?>assets/uploads/<?= !empty($result->photo) ? $result->photo : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
								</div>
								<div class="form-group col-md-6">
									<label class="label_green">Signature</label>
									<div class="clear"></div>			
									<input type="image" src="<?=base_url()?>assets/uploads/<?= !empty($result->signature) ? $result->signature : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
								</div>
							<h3>Date</h3>
							<div class="form-group col-md-12">
								<label class="label_green"></label>
								<div class="clear"></div>
								<input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($result->reg_date)) ?>" required readonly>
							</div>
							<div class="form-group col-md-12">
								<label class="label_green"></label>
								<div class="clear"></div>			
								<input type="checkbox" name="accept" id="accept" <?= $result->accept==1 ? 'checked': FALSE; ?> disabled> &nbsp;<b>I agree to follow the rules</b>
							</div>
					</div>
        <div class="col-sm-12 last_sa_se"><?php //echo form_submit('edit_farmer', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  $('.show_hidden').click(function() {
    $('.hidden_content').slideToggle("500");
    this.toggle = !this.toggle;
   $(this).find("span").text(this.toggle ? "[-]" : "[+]");
   return false;
  });
});
	$(document).ready(function() {
  $('.show_hidden1').click(function() {
    $('.hidden_content1').slideToggle("500");
    this.toggle = !this.toggle;
   $(this).find("span").text(this.toggle ? "[-]" : "[+]");
   return false;
  });
});
	$(document).ready(function() {
  $('.show_hidden2').click(function() {
    $('.hidden_content2').slideToggle("500");
    this.toggle = !this.toggle;
   $(this).find("span").text(this.toggle ? "[-]" : "[+]");
   return false;
  });
});
</script>
<script>
$(function() {
    $("#reg_date").datepicker({
		dateFormat: 'dd-mm-yy' 
	});
});
//	 $(document).ready(function(){
//        $(".kidszoona").mCustomScrollbar({
//          theme:"dark",
//           mouseWheelPixels: 170,
//        });
//    });
</script>