<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="<?= $assets ?>styles/jquery.mCustomScrollbar.css" rel="stylesheet"/>
<script src="<?= $assets ?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<p class="pdf_s"><a href="<?= admin_url('register/pdf_view_register/'.$result->id.''); ?>" class="pull-right"><i class="fa fa-2x fa-file-pdf-o" aria-hidden="true"></i>Pdf</a></p>
<style>
	.pdf_s{position: absolute;right: 2%;top: 10px;}
	.pdf_s a{color: red;text-decoration: none;}
	.pdf_s .fa{color: red;}
	/*.kidszon_content ul p{position: relative;float: left;padding-left: 30px;}	
.kidszon_content ul p::before {
    content: '';
    position: absolute;
    width: 5px;
    height: 5px;
    background-color: darkblue;
    left: 10px;
    top: 10px;
}*/
	
</style>


<?php

//echo '<pre>';
//print_r($outlet);
//print_r($result);
?>

<?php if($result->lang_sel=="en") { ?>

	<div class="box">
		<div class="box-content">
			<div class="row">
			<div class="col-lg-6  col-md-6 col-xs-12 kidszoona">
				<?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
						echo admin_form_open_multipart("farmer/edit_farmer/".$id, $attrib);
						?>
								<div class="col-md-12 text-center" style="text-align: center;">
									<img src="<?=base_url()?>assets/uploads/logos/logo.png" alt="kidszoona">
								</div>
								<div class="col-md-12 kidszon_content">
								<p>Regulation apply for get in Kidzooona Zone</p><br>
									<h3>Dear all customers</h3>
									<p>Here is a place did not have to control the behavior of children.</p>
									<p><b>For the safety of your child, we must comply with the follow wing our message.</b></p>

									<?php 
									$i =1;
									$obj = json_decode($sm->sm1);
//print_r($obj);

									//print_r($obj);die;
									foreach($obj as $safety) { ?>
									<div class="col-md-12 kids_zon_c">
										<h4><span><?php echo $safety->title;echo $safety->sm; ?></span> </h4>
										<div class="show_hidden<?= $i;?>">
											<strong>More Details <span>[-]</span></strong>
										</div>
										<ul class="hidden_content<?= $i;?>" xstyle="display: none;">
											<?php echo $safety->desc_msg; ?>
										</ul>
									</div>
									<?php $i++;} ?>

								</div>
								<div class="col-md-12 col-xs-12">
									<h3><?= lang("General information", "General information"); ?></h3>
									<h4 class="text-left">Parent name: (Age over 18 years old)</h4>

										<div class="form-group col-md-12">
											<label class="label_green">Customer Name </label>
											<input type="text" class="form-control" name="customer_name" id="customer_name" value="<?= $result->customer_name ?>" required readonly>
										</div>

										<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Male
												<input type="radio" name="gender" id="gender" <?= $result->gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Female
												<input type="radio" name="gender" id="gender" <?= $result->gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
										</div>

										<div class="form-group col-md-12">
											<label class="label_green">Nationality </label>
											<input type="text" class="form-control" name="nationality" id="nationality" value="<?= $nationality->name ?>" required readonly>
										</div>

										<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Father
												<input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==1 ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Mother
												<input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==2 ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Teacher
												<input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==4 ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" >
												<label class="container-checkbox">Others
												<input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==3 ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
										</div>

											<div class="form-group col-md-12">
												<label class="label_green">Others </label>
												<input type="text" class="form-control" name="others" id="others" value="<?= $others->name ?>" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">Mobile Number</label>
												<input type="text" class="form-control" name="phone" value="<?= $result->phone_number ?>" id="phone" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">Outlet</label>
												<input type="text" class="form-control" name="outlet" value="<?= $outlet->name ?>" id="outlet" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">Email</label>
												<input type="text" class="form-control" name="email" id="email"   value="<?= $result->email ?>" required readonly>
											</div>
										<h3><?= lang("Information of Chlidrens", "Information of Chlidrens"); ?></h3>
											<div class="form-group col-md-12">
												<label class="label_green">Kid Name 1</label>
												<input type="text" class="form-control"  value="<?= $result->kid_name1 ?>" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">Age</label>
												<input type="text" class="form-control"  value="<?= $kid1_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Male
												<input type="radio" name="gender1" id="gender1" <?= $result->kid1_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Female
												<input type="radio" name="gender1" id="gender1" <?= $result->kid1_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
										</div>

											<div class="form-group col-md-12">
												<label class="label_green">Kid Name 2</label>
												<input type="text" class="form-control" value="<?= $result->kid_name2 ?>" readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">Age</label>
												<input type="text" class="form-control"  value="<?= $kid2_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Male
												<input type="radio" name="gender2" id="gender2" <?= $result->kid2_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Female
												<input type="radio" name="gender2" id="gender2" <?= $result->kid2_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>


											<div class="form-group col-md-12">
												<label class="label_green">Kid Name 3</label>
												<input type="text" class="form-control" value="<?= $result->kid_name3 ?>" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">Age</label>
												<input type="text" class="form-control"  value="<?= $kid3_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Male
												<input type="radio" name="gender3" id="gender3" <?= $result->kid3_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Female
												<input type="radio" name="gender3" id="gender3" <?= $result->kid3_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											
											<div class="form-group col-md-12">
												<label class="label_green">Kid Name 4</label>
												<input type="text" class="form-control" value="<?= $result->kid_name4 ?>" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">Age</label>
												<input type="text" class="form-control"  value="<?= $kid4_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Male
												<input type="radio" name="gender4" id="gender4" <?= $result->kid4_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Female
												<input type="radio" name="gender4" id="gender4" <?= $result->kid4_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>

											<div class="form-group col-md-12">
												<label class="label_green">Kid Name 5</label>
												<input type="text" class="form-control" value="<?= $result->kid_name5 ?>" readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">Age</label>
												<input type="text" class="form-control"  value="<?= $kid5_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Male
												<input type="radio" name="gender5" id="gender5" <?= $result->kid5_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Female
												<input type="radio" name="gender4" id="gender5" <?= $result->kid5_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											
											<div class="form-group col-md-12">
												<label class="label_green">Kid Name 6</label>
												<input type="text" class="form-control" value="<?= $result->kid_name6 ?>" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">Age</label>
												<input type="text" class="form-control"  value="<?= $kid6_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Male
												<input type="radio" name="gender6" id="gender6" <?= $result->kid6_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">Female
												<input type="radio" name="gender6" id="gender6" <?= $result->kid6_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>

											<div class="form-group col-md-12">
												<label class="label_green">No of kids</label>
												<input type="text" class="form-control" value="<?= $result->no_of_kids ?>" readonly>
											</div>

											<h3>Information of Students</h3>

											<div class="form-group col-md-12">
												<label class="label_green">School Name</label>
												<input type="text" class="form-control" value="<?= $result->school_name ?>" readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">No of Students</label>
												<input type="text" class="form-control" value="<?= $result->no_of_students ?>" readonly>
											</div>

											<div class="form-group col-md-12">
												<label class="label_green">No of Boys</label>
												<input type="text" class="form-control" value="<?= $result->no_of_boys ?>" readonly>
											</div>

											<div class="form-group col-md-12">
												<label class="label_green">No of Girls</label>
												<input type="text" class="form-control" value="<?= $result->no_of_girls ?>" readonly>
											</div>
									<h3>Image</h3>
										<div class="form-group col-md-6">
											<label class="label_green">Photo</label>
											<div class="clear"></div>			
											<img  src="<?=base_url()?>assets/uploads/<?= !empty($result->photo) ? $result->photo : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
										</div>
										<div class="form-group col-md-6">
											<label class="label_green">Signature</label>
											<div class="clear"></div>			
											<img src="<?=base_url()?>assets/uploads/<?= !empty($result->signature) ? $result->signature : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
										</div>

									<h3>Attachement List of Students</h3>
										<div class="form-group col-md-6">
										<a href="<?= admin_url('register/download_view_register/'.$result->id.''); ?>" class="pull-right">Click to download</a>
										</div>

									<h3>Date</h3>
									<div class="form-group col-md-12">
										<label class="label_green"></label>
										<div class="clear"></div>
										<input type="text" class="form-control" value="<?= date('d/m/Y H:i:s', strtotime($result->created_on)) ?>" required readonly>
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

<?php }?>



<?php if($result->lang_sel=="km") { ?>

	<div class="box">
		<div class="box-content">
			<div class="row">
			<div class="col-lg-6  col-md-6 col-xs-12 kidszoona">
				<?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
						echo admin_form_open_multipart("farmer/edit_farmer/".$id, $attrib);
						?>
								<div class="col-md-12 text-center" style="text-align: center;">
									<img src="<?=base_url()?>assets/uploads/logos/logo.png" alt="kidszoona">
								</div>
								<div class="col-md-12 kidszon_content">
								<p> បទបញ្ជានានាដែលពាក់ព័ន្ធទៅនឹងការចូលទៅក្នុងបរិវេណkidzooona</p><br>
									<h3>អតិថិជនទាំងអស់ជាទីគោរព </h3>
									<p>Kidzooona មិនមែនជាទីកន្លែង សំរាប់គ្រប់គ្រងនូវការប្រព្រឹត្តរបស់កុមារនោះទេ</p>
									<p><b>ដើម្បីធានានូវសុវត្តិភាពរបស់កូនលោកអ្នក, យើងខ្ញុំត្រូវតែអនុវត្តតាមសាររបស់យើង។</b></p>

									<?php 
									$i =1;
									$obj = json_decode($sm->sm1);
									foreach($obj as $safety) { ?>
									<div class="col-md-12 kids_zon_c">
										<h4><span><?php echo $safety->title;echo $safety->sm; ?></span> </h4>
										<div class="show_hidden<?= $i;?>">
											<strong>More Details <span>[-]</span></strong>
										</div>
										<ul class="hidden_content<?= $i;?>" xstyle="display: none;">
											<?php echo $safety->desc_msg; ?>
										</ul>
									</div>
									<?php $i++;} ?>

								</div>
								<div class="col-md-12 col-xs-12">
							<h3>ពត៌មានទូទៅ</h3>
							<h4 class="text-left">ឈ្មោះឪពុក ម្ដាយ  : (អាយុចាប់ពី១៨ឆ្នាំឡើងទៅ)</h4>
							<div class="form-group col-md-12">
											<label class="label_green">ឈ្មោះអតិថិជន*:</label>
											<input type="text" class="form-control" name="customer_name" id="customer_name" value="<?= $result->customer_name ?>" required readonly>
										</div>

										<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ប្រុស
												<input type="radio" name="gender" id="gender" <?= $result->gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ស្រី
												<input type="radio" name="gender" id="gender" <?= $result->gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
										</div>

										<div class="form-group col-md-12">
											<label class="label_green">សញ្ជាតិ </label>
											<input type="text" class="form-control" name="nationality" id="nationality" value="<?= $nationality->name ?>" required readonly>
										</div>

										<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ឪពុក
												<input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==1 ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ម្តាយ
												<input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==2 ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">គ្រូ
												<input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==4 ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" >
												<label class="container-checkbox">ផ្សេងទៀត
												<input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==3 ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
										</div>

											<div class="form-group col-md-12">
												<label class="label_green">ផ្សេងទៀត </label>
												<input type="text" class="form-control" name="others" id="others" value="<?= $others->name ?>" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">លេខទូរស័ព្ទ*</label>
												<input type="text" class="form-control" name="phone" value="<?= $result->phone_number ?>" id="phone" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">សាខា</label>
												<input type="text" class="form-control" name="outlet" value="<?= $outlet->name ?>" id="outlet" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">អ៊ីម៉ែល</label>
												<input type="text" class="form-control" name="email" id="email"   value="<?= $result->email ?>" required readonly>
											</div>
										<h3>* ពត៌មានអំពីក្មេងចូលលេង៖ អតិប្បរមា ក្មេង ៦ នាក់</h3>
											<div class="form-group col-md-12">
												<label class="label_green">ឈ្មោះក្មេងទី ១ </label>
												<input type="text" class="form-control"  value="<?= $result->kid_name1 ?>" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">អាយុ</label>
												<input type="text" class="form-control"  value="<?= $kid1_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ប្រុស
												<input type="radio" name="gender1" id="gender1" <?= $result->kid1_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ស្រី
												<input type="radio" name="gender1" id="gender1" <?= $result->kid1_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
										</div>

											<div class="form-group col-md-12">
												<label class="label_green">ឈ្មោះក្មេងទី ២ </label>
												<input type="text" class="form-control" value="<?= $result->kid_name2 ?>" readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">អាយុ</label>
												<input type="text" class="form-control"  value="<?= $kid2_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ប្រុស
												<input type="radio" name="gender2" id="gender2" <?= $result->kid2_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ស្រី
												<input type="radio" name="gender2" id="gender2" <?= $result->kid2_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>


											<div class="form-group col-md-12">
												<label class="label_green">ឈ្មោះក្មេងទី 3</label>
												<input type="text" class="form-control" value="<?= $result->kid_name3 ?>" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">អាយុ</label>
												<input type="text" class="form-control"  value="<?= $kid3_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ប្រុស
												<input type="radio" name="gender3" id="gender3" <?= $result->kid3_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ស្រី
												<input type="radio" name="gender3" id="gender3" <?= $result->kid3_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											
											<div class="form-group col-md-12">
												<label class="label_green">ឈ្មោះក្មេងទី 4</label>
												<input type="text" class="form-control" value="<?= $result->kid_name4 ?>" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">អាយុ</label>
												<input type="text" class="form-control"  value="<?= $kid4_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ប្រុស
												<input type="radio" name="gender4" id="gender4" <?= $result->kid4_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ស្រី
												<input type="radio" name="gender4" id="gender4" <?= $result->kid4_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>

											<div class="form-group col-md-12">
												<label class="label_green">ឈ្មោះក្មេងទី 5</label>
												<input type="text" class="form-control" value="<?= $result->kid_name5 ?>" readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">អាយុ</label>
												<input type="text" class="form-control"  value="<?= $kid5_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ប្រុស
												<input type="radio" name="gender5" id="gender5" <?= $result->kid5_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ស្រី
												<input type="radio" name="gender4" id="gender5" <?= $result->kid5_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											
											<div class="form-group col-md-12">
												<label class="label_green">ឈ្មោះក្មេងទី 6</label>
												<input type="text" class="form-control" value="<?= $result->kid_name6 ?>" required readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">អាយុ</label>
												<input type="text" class="form-control"  value="<?= $kid6_age->name ?>" required readonly>
											</div>

											<div class="form-group col-md-12">
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ប្រុស
												<input type="radio" name="gender6" id="gender6" <?= $result->kid6_gender=='M' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>
											<div class="col-md-3" style="padding: 0px;">
												<label class="container-checkbox">ស្រី
												<input type="radio" name="gender6" id="gender6" <?= $result->kid6_gender=='F' ? 'checked': FALSE; ?> disabled>
												</label>
											</div>

											<div class="form-group col-md-12">
												<label class="label_green">* ចំនួនក្មេងសរុប </label>
												<input type="text" class="form-control" value="<?= $result->no_of_kids ?>" readonly>នាក់
											</div>

											<h3>* ពត៌មានអំពីសិស្ស៖</h3>

											<div class="form-group col-md-12">
												<label class="label_green">ឈ្មោះសាលារៀន</label>
												<input type="text" class="form-control" value="<?= $result->school_name ?>" readonly>
											</div>
											<div class="form-group col-md-12">
												<label class="label_green">ចំនួនសិស្សសរុប</label>
												<input type="text" class="form-control" value="<?= $result->no_of_students ?>" readonly>
											</div>

											<div class="form-group col-md-12">
												<label class="label_green">ចំនួនសិស្សប្រុស</label>
												<input type="text" class="form-control" value="<?= $result->no_of_boys ?>" readonly>
											</div>

											<div class="form-group col-md-12">
												<label class="label_green">ចំនួនសិស្សស្រី</label>
												<input type="text" class="form-control" value="<?= $result->no_of_girls ?>" readonly>
											</div>
									<h3>រូបភាព</h3>
										<div class="form-group col-md-6">
											<label class="label_green">រូបអតិថិជន</label>
											<div class="clear"></div>			
											<img  src="<?=base_url()?>assets/uploads/<?= !empty($result->photo) ? $result->photo : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
										</div>
										<div class="form-group col-md-6">
											<label class="label_green">ហត្ថលេខា</label>
											<div class="clear"></div>			
											<img src="<?=base_url()?>assets/uploads/<?= !empty($result->signature) ? $result->signature : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
										</div>

									<h3>Attachement List of Students</h3>
										<div class="form-group col-md-6">
										<a href="<?= admin_url('register/download_view_register/'.$result->id.''); ?>" class="pull-right">Click to download</a>
										</div>

									<h3>កាលបរិច្ឆទ</h3>
									<div class="form-group col-md-12">
										<label class="label_green"></label>
										<div class="clear"></div>
										<input type="text" class="form-control" value="<?= date('d/m/Y H:i:s', strtotime($result->created_on)) ?>" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green"></label>
										<div class="clear"></div>			
										<input type="checkbox" name="accept" id="accept" <?= $result->accept==1 ? 'checked': FALSE; ?> disabled> &nbsp;<b>ខ្ញុំបានយល់ព្រមធ្វើតាមលក្ខន្តិកៈរបស់ ឃីតហ្ស៊ូណា</b>
									</div>
					</div>
				<div class="col-sm-12 last_sa_se"><?php //echo form_submit('edit_farmer', lang('submit'), 'class="btn btn-primary"'); ?></div>
				<?php echo form_close(); ?> </div>
			</div>
		</div>
	</div>

<?php }?>

<script>
$(document).ready(function() {
  $('.show_hidden1').click(function() {
    $('.hidden_content1').slideToggle("500");
    this.toggle = !this.toggle;
   $(this).find("span").text(this.toggle ? "[+]" : "[-]");
   return false;
  });
});
	$(document).ready(function() {
  $('.show_hidden2').click(function() {
    $('.hidden_content2').slideToggle("500");
    this.toggle = !this.toggle;
   $(this).find("span").text(this.toggle ? "[+]" : "[-]");
   return false;
  });
});
	$(document).ready(function() {
  $('.show_hidden3').click(function() {
    $('.hidden_content3').slideToggle("500");
    this.toggle = !this.toggle;
   $(this).find("span").text(this.toggle ? "[+]" : "[-]");
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