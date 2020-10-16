<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="<?= $assets ?>styles/jquery.mCustomScrollbar.css" rel="stylesheet"/>
<link href="<?= $assets ?>styles/helpers/bootstrap.min.css" rel="stylesheet"/>
<script src="<?= $assets ?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<p><a href="<?= admin_url('register/pdf_view_register/'.$result->id.''); ?>" class="pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></p>
<style>
	@media print{
		#header,#footer{display: none;margin: 0px;padding: 0px;}
		*,body{padding: 0px;margin: 0px;}
	}
/*.kidszon_content ul p{position: relative;float: left;padding-left: 30px;}	*/
	*,body{padding: 0px;margin: 0px;}
	.kidszon_content ul p::before {
		content: '';
		position: absolute;
		width: 5px;
		height: 5px;
		background-color: darkblue;
		left: 10px;
		top: 10px;
	}
	.kidszon_content ul{margin: 0px;padding: 0px;}
	.kidszon_content ul p{color: #777}
	.form-control,input{
			display:block;
			width: 100%;
			height: 50px;
			padding:8px 12px;
			font-size: 14px;
			line-height: 34px;
			color: #555;
			background-color: #fff;
			background-image: none;
			border: 1px solid #ccc;
			border-radius: 4px;
			-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
			box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
			-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
			-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
			transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;}
	.show_hidden1,.show_hidden2,.show_hidden3,.show_hidden4,.show_hidden5,.show_hidden6 {display: none;}
	.kids_zon_c h4{color: black;}
	.table-bordered tr td{padding: 8px;font-size: 13px;}
	.table-bordered tr td,.table-bordered{border: none;color: #333;}
	table tbody tr td h3{font-size: 14px;}
	.table-bordered{margin-bottom: 0px;}
/*	.table_dot tr td:first-child::after{position: absolute;right: 0px;content: ':';color: black;top: 0px;}*/
	.table_dot tr td:first-child{font-weight: bold;color: #333;}
	.table_dot tr td:last-child{font-weight: normal;color: #333;}
	.kidszoona h3,.table-bordered tr td h3{font-size: 18px;}
	.container-checkbox{font-weight: bold;font-size: 16px;}
	.kidszon_content ul li,.kidszon_content ol li{font-size: 13px;color: #333;line-height: 20px;}
	.kidszon_content ul,.kidszon_content ol{padding-left: 15px;list-style: decimal;}
	
/*
	.table_dot tr td:first-child{width: 45%;}
	.table_dot tr td:nth-of-type(2){width: 5%;}
	.table_dot tr td:nth-of-type(3){width: 50%;}
*/
	.text_underline label{text-decoration: underline;}
	.kidszoona .kids_reg_form {
		background-color: #4272c5;
		padding: 15px 2px;
		color: #fff;
		text-decoration: underline;
		text-align: center;
	}
	.border_kids{border: 2px solid #333;position: relative;float: left;padding: 5px;}
	@page{margin-top: 20px;}
</style>
<?php if($result->lang_sel=="en") { ?>
<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12 kidszoona">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("farmer/edit_farmer/".$id, $attrib);
                ?>
						<div class="col-md-12 text-center" style="text-align: center;">
							<img src="<?=base_url()?>assets/uploads/logos/logo.png" alt="kidszoona">
						</div>
						<div class="col-md-12 kidszon_content">
							<p>Regulation apply for get in Kidzooona Zone</p>
									<h3>Dear all customers</h3>
									<p>Here is a place did not have to control the behavior of children.</p>
									<p><b>For the safety of your child, we must comply with the follow wing our message.</b></p>
								<div class="border_kids">
							<?php
							$i =1;
							$obj = json_decode($sm->sm1);
							foreach($obj as $safety) { ?>
							<div class="col-md-12 kids_zon_c">
								<h4><?php echo $safety->title;echo $safety->sm; ?> </h4>
								<div class="show_hidden<?= $i;?>">
									<strong>More Details <span>[+]</span></strong>
								</div>
								<ul class="hidden_content<?= $i;?>" xstyle="display: none;">
									<?php echo $safety->desc_msg; ?>
								</ul>
							</div>
							<?php  $i++;} ?>
							</div>
							<div class="form-group col-md-12" style="margin-top: 10px;">
								<img src="<?=base_url()?>assets/uploads/<?= $result->safe_accept==1 ? 'tick.png': 'list.png'; ?>" width="15px"/>
											  &nbsp;<b>I have read the Terms & Conditions</b>
							</div>
						</div>
						<div class="col-md-12 col-xs-12" style="page-break-before: always">
							<h3 class="kids_reg_form">Kidzooona Registration Form</h3>
							<h4 class="text-left text_underline" style="font-size: 18px;color: #000;text-decoration: underline;padding-left: 9px;">* Parents name: (Age over 18 years old)</h4>


							<table class="table table-bordered table_dot print_break" style="width: 70%;table-layout: fixed">
								<tr>
									<td >Customer Name :</td>
									<td><?= $result->customer_name ?></td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> Male
										</label>
										<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> Female
										</label>									
									</td>
								</tr>
							</table>
							
							<table class="table table-bordered table_dot_check" >
							
								<tr>
									<td >Nationality :</td>
									<td><?= $nationality->name ?></td>
									<td><label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->parent_type==1 ? 'tick.png': 'list.png'; ?>" width="15px"/> Father
										</label>
									</td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->parent_type==2 ? 'tick.png': 'list.png'; ?>" width="15px"/> Mother
										</label>
									</td>
									<td>
										<label class="container-checkbox">
										<img src="<?=base_url()?>assets/uploads/<?= $result->parent_type==4 ? 'tick.png': 'list.png'; ?>" width="15px"/> Teacher
										</label>
									</td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->parent_type==3 ? 'tick.png': 'list.png'; ?>" width="15px"/> Others
										</label>
									</td>
									<td><?= $others->name ?></td>
								</tr>
							</table>
							<table class="table table-bordered table_dot print_break" style="width: 50%;">
								
								<tr>
									<td>Phone Number*:</td>
									<td><?= $result->phone_number ?></td>
								</tr>
								<tr>
									<td>Outlet:</td>
									<td><?= $outlet->name ?></td>
								</tr>
								<tr>
									<td>E-mail Address:</td>
									<td><?= $result->email ?></td>
								</tr>
							</table>
							<h4 class="text-left text_underline" style="font-size: 18px;color: #000;text-decoration: underline;padding-left: 9px;"><?= lang("* Information Of Chlidrens (Maximum 6 Kids)", "* Information Of Chlidrens (Maximum 6 Kids)"); ?></h4>
							<table class="table table-bordered table_dot print_break" >
								<tr>
									<td>Kids Name 1:</td>
									<td><?= $result->kid_name1 ?></td>
									<td>Age:</td>
									<td><?= $kid1_age->name ?></td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->kid1_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> Boy
										</label>
										<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid1_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> Girl
										</label>									
									</td>
								</tr>
								
								<tr>
									<td>Kids Name 2:</td>
									<td><?= $result->kid_name2 ?></td>
									<td>Age:</td>
									<td><?= $kid2_age->name ?></td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->kid2_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> Boy
										</label>
										<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid2_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> Girl
										</label>									
									</td>
								</tr>
								<tr>
									<td>Kids Name 3:</td>
									<td><?= $result->kid_name3 ?></td>
									<td>Age:</td>
									<td><?= $kid3_age->name ?></td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->kid3_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> Boy
										</label>
										<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid3_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> Girl
										</label>									
									</td>
								</tr>
								

								<tr>
									<td>Kids Name 4:</td>
									<td><?= $result->kid_name4 ?></td>
									<td>Age:</td>
									<td><?= $kid4_age->name ?></td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->kid4_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> Boy
										</label>
										<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid4_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> Girl
										</label>									
									</td>
								</tr>
								

								<tr>
									<td>Kids Name 5:</td>
									<td><?= $result->kid_name5 ?></td>
									<td>Age:</td>
									<td><?= $kid5_age->name ?></td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->kid5_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> Boy
										</label>
										<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid5_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> Girl
										</label>									
									</td>
								</tr>
								<tr>
									<td>Kids Name 6:</td>
									<td><?= $result->kid_name6 ?></td>
									<td>Age:</td>
									<td><?= $kid6_age->name ?></td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->kid6_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> Boy
										</label>
										<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid6_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> Girl
										</label>									
									</td>
								</tr>
								
								<tr>
									<td>Number of kids</td>
									<td><?= $result->no_of_kids ?></td>
									<td>Kids</td>
								</tr>
							</table>
							<h4 class="text-left text_underline" style="font-size: 18px;color: #000;text-decoration: underline;padding-left: 9px;">* Information of Students</h4>
							<table class="table table-bordered table_dot print_break" >
								
								<tr>
									<td>School Name :</td>
									<td><?= $result->school_name ?></td>
								</tr>
								<tr>
									<td>No of Students :</td>
									<td><?= $result->no_of_students ?></td>
									<td>Number of Boys</td>
									<td><?= $result->no_of_boys ?></td>
									<td>No of Girls</td>
									<td><?= $result->no_of_girls ?></td>
								</tr>
								
								<!--<tr>
									<td>Attachment List of Students: </td>
									<td>

									</td>
								</tr>-->
								</table>
								<table class="table table-bordered">
									<tr>
										<td>
											<img src="<?=base_url()?>assets/uploads/<?= $result->accept==1 ? 'tick.png': 'list.png'; ?>" width="15px"/>
											  &nbsp;<b>I Agree and Follow the Rules of Kidzooona</b>
										</td>
									</tr>
								</table>
								<table class="table table-bordered">
								<tr>
									<td colspan="3"><h3 style="font-size: 18px;color: #000;text-decoration: underline">Image</h3></td>
								</tr>
								<tr>
									<td colspan="2">Photo:</td>
									<td>
										<img src="<?=base_url()?>assets/uploads/<?= !empty($result->photo) ? $result->photo : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
									</td>
								</tr>
								<tr>
									<td colspan="2">
										Signature:
									</td>
									<td>
										<img src="<?=base_url()?>assets/uploads/<?= !empty($result->signature) ? $result->signature : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
									</td>
								</tr>
								<tr>
									<td colspan="3"><h3 style="font-size: 18px;color: #000;text-decoration: underline">Date</h3></td>
								</tr>
								<tr>
									<td colspan="2">Date:</td>
									<td><?= date('d/m/Y H:i:s', strtotime($result->created_on)) ?></td>
								</tr>
								
							</table>
						
					</div>
        <div class="col-sm-12 last_sa_se">
		<?php //echo form_submit('edit_farmer', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>

<?php if($result->lang_sel=="km") { ?>
<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-12 kidszoona">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("farmer/edit_farmer/".$id, $attrib);
                ?>
						<div class="col-md-12 text-center" style="text-align: center;">
							<img src="<?=base_url()?>assets/uploads/logos/logo.png" alt="kidszoona">
						</div>
						<div class="col-md-12 kidszon_content">
							<p> បទបញ្ជានានាដែលពាក់ព័ន្ធទៅនឹងការចូលទៅក្នុងបរិវេណkidzooona</p>
									<h3>អតិថិជនទាំងអស់ជាទីគោរព </h3>
									<p>Kidzooona មិនមែនជាទីកន្លែង សំរាប់គ្រប់គ្រងនូវការប្រព្រឹត្តរបស់កុមារនោះទេ</p>
									<p><b>ដើម្បីធានានូវសុវត្តិភាពរបស់កូនលោកអ្នក, យើងខ្ញុំត្រូវតែអនុវត្តតាមសាររបស់យើង។</b></p>
							<div class="border_kids">
							<?php
							$i =1;
							$obj = json_decode($sm->sm1);
							foreach($obj as $safety) { ?>
							<div class="col-md-12 kids_zon_c">
								<h4><?php echo $safety->title;echo $safety->sm; ?> </h4>
								<div class="show_hidden<?= $i;?>">
									<strong>More Details <span>[+]</span></strong>
								</div>
								<ul class="hidden_content<?= $i;?>" xstyle="display: none;">
									<?php echo $safety->desc_msg; ?>
								</ul>
							</div>
							
							<?php  $i++;} ?>
							</div>
							<div class="form-group col-md-12" style="margin-top: 10px;">
								<img src="<?=base_url()?>assets/uploads/<?= $result->safe_accept==1 ? 'tick.png': 'list.png'; ?>" width="15px"/>
											  &nbsp;<b>ខ្ញុំបានអាន និង យល់ព្រមតាមលក្ខន្តិកៈរបស់ ឃីតហ្ស៊ូណា</b>
							</div>
						</div>
						<div class="col-md-12 col-xs-12">
							<h3 class="kids_reg_form">តារាងបំពេញបែបបទចូលលេង ឃីតហ្ស៊ូណា</h3>
							<h4 class="text-left text_underline" style="font-size: 18px;color: #000;text-decoration: underline;padding-left: 9px;">* ឈ្មោះឪពុក ម្ដាយ  : (អាយុចាប់ពី១៨ឆ្នាំឡើងទៅ)</h4>
							
							
							<table class="table table-bordered table_dot print_break" style="width: 70%;table-layout: fixed">
								<tr>
									<td >ឈ្មោះអតិថិជន*:</td>
									<td><?= $result->customer_name ?></td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> ប្រុស
										</label>
										<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> ស្រី
										</label>									
									</td>
								</tr>
							</table>
							
							<table class="table table-bordered table_dot_check" >
							
								<tr>
									<td>សញ្ជាតិ:</td>
									<td><?= $nationality->khmer_name ?></td>
									<td><label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->parent_type==1 ? 'tick.png': 'list.png'; ?>" width="15px"/> ឪពុក
										</label>
									</td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->parent_type==2 ? 'tick.png': 'list.png'; ?>" width="15px"/> ម្តាយ
										</label>
									</td>
									<td>
										<label class="container-checkbox">
										<img src="<?=base_url()?>assets/uploads/<?= $result->parent_type==4 ? 'tick.png': 'list.png'; ?>" width="15px"/> គ្រូ
										</label>
									</td>
									<td>
										<label class="container-checkbox">
										  <img src="<?=base_url()?>assets/uploads/<?= $result->parent_type==3 ? 'tick.png': 'list.png'; ?>" width="15px"/> ផ្សេងទៀត
										</label>
									</td>
									<td><?= $others->khmer_name ?></td>
								</tr>
							</table>
							
							<table class="table table-bordered table_dot print_break" style="width: 50%;">
								
								<tr>
									<td>លេខទូរស័ព្ទ*:</td>
									<td><?= $result->phone_number ?></td>
								</tr>
								<tr>
									<td>សាខា:</td>
									<td><?= $outlet->name ?></td>
								</tr>
								<tr>
									<td>អ៊ីម៉ែល:</td>
									<td><?= $result->email ?></td>
								</tr>
							</table>
							<h4 class="text-left text_underline" style="font-size: 18px;color: #000;text-decoration: underline;padding-left: 9px;">* ពត៌មានអំពីក្មេងចូលលេង៖ អតិប្បរមា ក្មេង ៦ នាក់</h4>
								
								<table class="table table-bordered table_dot print_break" >
									<tr>
										<td>ឈ្មោះក្មេងទី ១:</td>
										<td><?= $result->kid_name1 ?></td>
										<td>អាយុ:</td>
										<td><?= $kid1_age->khmer_name ?></td>
										<td>
											<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid1_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> ប្រុស
											</label>
											<label class="container-checkbox">
												  <img src="<?=base_url()?>assets/uploads/<?= $result->kid1_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> ស្រី
											</label>									
										</td>
									</tr>
									
									<tr>
										<td>ឈ្មោះក្មេងទី ២:</td>
										<td><?= $result->kid_name2 ?></td>
										<td>អាយុ:</td>
										<td><?= $kid2_age->khmer_name ?></td>
										<td>
											<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid2_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> ប្រុស
											</label>
											<label class="container-checkbox">
												  <img src="<?=base_url()?>assets/uploads/<?= $result->kid2_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> ស្រី
											</label>									
										</td>
									</tr>
									
									<tr>
										<td>ឈ្មោះក្មេងទី 3:</td>
										<td><?= $result->kid_name3 ?></td>
										<td>អាយុ:</td>
										<td><?= $kid3_age->khmer_name ?></td>
										<td>
											<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid3_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> ប្រុស
											</label>
											<label class="container-checkbox">
												  <img src="<?=base_url()?>assets/uploads/<?= $result->kid3_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> ស្រី
											</label>									
										</td>
									</tr>
									<tr>
										<td>ឈ្មោះក្មេងទី 4:</td>
										<td><?= $result->kid_name4 ?></td>
										<td>អាយុ:</td>
										<td><?= $kid4_age->khmer_name ?></td>
										<td>
											<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid4_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> ប្រុស
											</label>
											<label class="container-checkbox">
												  <img src="<?=base_url()?>assets/uploads/<?= $result->kid4_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> ស្រី
											</label>									
										</td>
									</tr>
									
									<tr>
										<td>ឈ្មោះក្មេងទី 5:</td>
										<td><?= $result->kid_name5 ?></td>
										<td>អាយុ:</td>
										<td><?= $kid5_age->khmer_name ?></td>
										<td>
											<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid5_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> ប្រុស
											</label>
											<label class="container-checkbox">
												  <img src="<?=base_url()?>assets/uploads/<?= $result->kid5_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> ស្រី
											</label>									
										</td>
									</tr>
									
									<tr>
										<td>ឈ្មោះក្មេងទី 6:</td>
										<td><?= $result->kid_name6 ?></td>
										<td>អាយុ:</td>
										<td><?= $kid6_age->khmer_name ?></td>
										<td>
											<label class="container-checkbox">
											  <img src="<?=base_url()?>assets/uploads/<?= $result->kid6_gender=='M' ? 'tick.png': 'list.png'; ?>" width="15px"/> ប្រុស
											</label>
											<label class="container-checkbox">
												  <img src="<?=base_url()?>assets/uploads/<?= $result->kid6_gender=='F' ? 'tick.png': 'list.png'; ?>" width="15px"/> ស្រី
											</label>									
										</td>
									</tr>
									<tr >
										<td>* ចំនួនក្មេងសរុប</td>
										<td><?= $result->no_of_kids ?></td>
										<td>នាក់</td>
									</tr>
								</table>
							
							<h4 class="text-left text_underline" style="font-size: 18px;color: #000;text-decoration: underline;padding-left: 9px;">* ពត៌មានអំពីសិស្ស៖</h4>

								<table class="table table-bordered table_dot print_break" >
								
									<tr>
										<td>ឈ្មោះសាលារៀន:</td>
										<td><?= $result->school_name ?></td>
									</tr>
									<tr>
										<td>ចំនួនសិស្សសរុប:</td>
										<td><?= $result->no_of_students ?></td>
										<td>ចំនួនសិស្សប្រុស</td>
										<td><?= $result->no_of_boys ?></td>
										<td>ចំនួនសិស្សស្រី</td>
										<td><?= $result->no_of_girls ?></td>
									</tr>

									<!--<tr>
										<td>បញ្ជីឈ្មោះសិស្ស: </td>
										<td>
												
										</td>
									</tr>-->
								</table>
								<table class="table table-bordered">
									<tr>
										<td>
											<img src="<?=base_url()?>assets/uploads/<?= $result->accept==1 ? 'tick.png': 'list.png'; ?>" width="15px"/>
											  &nbsp;<b>ខ្ញុំយល់ព្រមតាមបទបញ្ចាខាងលើ</b>
										</td>
									</tr>
								</table>
								<table class="table table-bordered">
								<tr>
									<td colspan="3"><h3 style="font-size: 18px;color: #000;text-decoration: underline">រូបភាព</h3></td>
								</tr>
								<tr>
									<td colspan="2">រូបអតិថិជន</td>
									<td>:</td>
									<td>
										<img src="<?=base_url()?>assets/uploads/<?= !empty($result->photo) ? $result->photo : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
									</td>
								</tr>
								<tr>
									<td colspan="2">
									ហត្ថលេខា
									</td>
									<td>:</td>
									<td>
										<img src="<?=base_url()?>assets/uploads/<?= !empty($result->signature) ? $result->signature : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
									</td>
								</tr>
								<tr>
									<td colspan="3"><h3 style="font-size: 18px;color: #000;text-decoration: underline">កាលបរិច្ឆទ</h3></td>
								</tr>
								<tr>
									<td colspan="2">កាលបរិច្ឆទ</td>
									<td>:</td>
									<td><?= date('d/m/Y H:i:s', strtotime($result->created_on)) ?></td>
								</tr>
								
							</table>
					</div>
        <div class="col-sm-12 last_sa_se">
		<?php //echo form_submit('edit_farmer', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<script>
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
	$(document).ready(function() {
  $('.show_hidden3').click(function() {
    $('.hidden_content3').slideToggle("500");
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