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
<div class="box">
  <div class="box-content">
    <div class="row">
      <div class="col-lg-6  col-md-6 col-xs-12 kidszoona">
        <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                echo admin_form_open_multipart("farmer/edit_farmer/".$id, $attrib);
                ?>
						<div class="col-md-12 text-center" style="text-align: center;">
							<img src="<?=base_url()?>assets/uploads/logos/logo.jpg" alt="kidszoona">
						</div>
						<div class="col-md-12 kidszon_content">
							<h3>អតិថិជនទាំងអស់ជាទីគោរព </h3>
							<p> មិនមែនជាទីកន្លែងសំរាប់គ្រប់គ្រងនូវការប្រព្រឹត្ដរបស់កុមារនោះទេការណែនាំ រឺ នីតិវិធី</p>
							<p><b>ដើម្បីធានានូវសុវត្តិភាពរបស់កូនលោកអ្នក, យើងខ្ញុំត្រូវតែអនុវត្តតាមសាររបស់យើង។</b></p>

							<div class="col-md-12 kids_zon_c">
								<h4><span>នីតិវិធី</span> </h4>
								<div class="show_hidden1">
									<strong>More Details <span>[-]</span></strong>
								</div>
								<ul class="hidden_content1" xstyle="display: none;">
									<li>ដើម្បីធានានូវសុវត្តិភាពរបស់កូនលោកអ្នក ឪពុកម្ដាយ រឺ អាណាព្យាបាល(ដែលមានកូនចាប់ពី១៨ឡើងទៅ)គួរចូលរួមជាមួយកូន</li>
									
									<li>ឪពុកម្ដាយត្រូវទទួលខុសត្រូវរាល់សកម្មភាពទាំងអស់របស់កូនលោកអ្នក និងគ្រប់គ្រង ថែរក្សាកូនរបស់លោកអ្នកដោយផ្ទាល់</li>
									<li>ឪពុកម្ដាយត្រូវប្រាកដថាកូនលោកអ្នកតាមបទបញ្ជារបស់ Kidzooona</li>
									<li>សូមកុំរត់មៅក្នុងបរិវេណ Kidzooona ដោយសារអាចបណ្ដាលអោយមានគ្រោះថ្នាក់ជាយថាហេតុ រឺរបួសដែលបណ្ដោយមកពីប៉ះទង្គិចជាមួយក្មេងដទៃទៀត។</li>
									<li>ប្រសិនបើកូនលោកអ្នក ប្រព្រឹត្ដនូវសកម្មភាពដែលខ្លាំងៗ(ដែលបង្កអោយមានគ្រោះថ្នាក់)ត្រូវប្រុងប្រយត្ន័កុំអោយប៉ះទង្គិចជាមួយក្មេងដទៃទៀត។</li>
									<li>សូមដោះគ្រឿងអលង្ការរបស់កូនលោកអ្នក មុនពេលចូលលេងក្នុងបរិវេណហាងពីព្រោះគ្រឿងអលង្ការទាំងអស់ អាចបង្កអោយមានរបួសដល់ រាងកាយនិង សំលៀកបំពាក់ដល់ អតិថិជនដទៃទៀត</li>
									<li>សូមរក្សាស្បែកជើងរបស់អ្នក នៅទូដាកស្បែកជើងរបស់ខ្លួនឯង។ ប្រសិនបើបាត់បង់ហាងមិនទទួលខុសត្រូវឡើយ។</li>
									<li>សូមរក្សាស្បែកជើងរបស់អ្នក នៅទូដាកស្បែកជើងរបស់ខ្លួនឯង។ ប្រសិនបើបាត់បង់ហាងមិនទទួលខុសត្រូវឡើយ។</li>
									<li>នៅពេលនៅក្នុងហាងសូមធ្វើការយកចិត្ដទុកដាក់និងធ្វើការតាមការណែនាំ​របស់​បុគ្គលិក រឺ ធ្វើទៅតាមផ្ទាំងបដាបិទ ដែលបង្ហាញពី ពត៏មានដែលលោកអ្នកត្រូវធ្វើតាមនិងបទបញ្ជាផ្សេងៗ។</li>	
									<li>ខ្ញុំបានអានលក្ខខណ្ឌ</li>						
								</ul>
							</div>
							<div class="col-md-12 kids_zon_c">
								<h4><span>បំរាម</span> </h4>
								<div class="show_hidden2">
									<strong>More Details <span>[-]</span></strong>
								</div>
								<ul class="hidden_content2" xstyle="display: none;">
									 <li>ក្មេងដែលមានអាយុចាប់ពី ១១ឆ្នាំ និងមិនត្រូវបានអនុញ្ញាត អោយចូលលេងនៅក្នុងហាង</li> 
									 <li>អ្នកដែលមានជំងឺអាចឆ្លងរាលដាល ទៅអ្នកដទៃបានដូចជាំ ក្អួត ហៀរសំបោរ ជំងឺសើរស្បែក ដំបៅរឺមានលក្ខខណ្ឌសុខភាពដទៃទៀត រឺមិនមាន​ហេតុផលល្អណាមួយក្នុងការចូលលេងកំសាន្ដនៅក្នុងហាង។</li> 
									 <li>លោកអ្នកអាចត្រលប់មកទទួលយកសេវាកម្មរបស់យើងម្ដងទៀតនៅពេលក្រោយ។ការមកលេងកំសាន្ដនៅពេលលោកអ្នកមានជំងឺអាចបង្កឲមានផលប៉ះពាល់អវិជ្ជមានទៅលើកអតិថិជនដទៃទៀត។</li> 
									 <li>ឪពុកម្ដាយ រឺអាណាព្យាបាលមិនអនុញ្ញាតអោយគេង ក្នុងបរិវេណហាងឡើយដោយហេតុថាវាជាសក្មភាពមួយដែលរារាំងដល់ការគ្រប់គ្រងក្មេង។</li> 
									 <li>មិនអនុញ្ញាតអោយបរិភោគអាហារឬពិសាទឹកនៅបិរវេណ Kidzoona លើកលែងករណីចាំបាច់ជាក់លាក់ណាមួយបានកំណត់តែប៉ុណ្ណោះ។</li> 
									 <li>សូមរក្សាទុករទេះក្មេង នៅកន្លែងទុករទេះ។</li> 
									 <li>មិនត្រូវធ្វើឲប៉ះពាល់ដល់បរិស្ថាននានាដែលពាក់ពន្ធ័ទៅនឹងបញ្ហាសុខភាព នៅក្នុងហាងដូចជាមិនត្រូវ ក្អួត ខាកស្ដោះ បន្ទោបង់លាមក និង បត់ជើងតូច នៅបរិវេណ Kidzooona ប្រសិនបើមានករណី កើតឡើងបន្ទាន់ សូមមេត្តាផ្ដល់ពត៏មាន មកដល់បុគ្គលិករបស់យើង។</li> 
									 <li>សូមកុំនាំយកប្រដាប់ក្មេងលេង និង ឧបករណ៍ផ្សេងៗ</li>
									 <li>ខ្ញុំបានអានលក្ខខណ្ឌ</li>								
								</ul>
							</div>
							<div class="col-md-12 kids_zon_c">
								<h4><span>Others</span> </h4>
								<div class="show_hidden3">
									<strong>More Details <span>[-]</span></strong>
								</div>
								<ul class="hidden_content3" xstyle="display: none;">
									<li>យើងខ្ញុំមិនទទួលខុសត្រូវរាល់ការគ្រោះថ្នាក់ផ្សៀងៗរបួសនិងបាត់បង់ទ្រព្យសម្បតិ្តនៅក្នុងបរិវេណហាងរបស់យើងខ្ញុំឡើយ</li>
									<li>ក្នុងករណីមិនធ្វើតាមការណែនាំរបស់បុគ្គលិកនិងបទបញ្ចារបស់ហាងដែលធ្វើ់​ឲបុគ្គលិករបស់យើងមិនអាចរក្សាបានននូវសុវត្ថិភាព និងភាពអាចទុកចិត្ដបានចំពោះហាងយើងខ្ញុំ </li>
									<li>ដូចនេះបុគ្គលិករបស់យើងនិងធ្វើការស្នើសុំលោកអ្នកអោយចាកចេញពីហាង។</li>
									<li>យើងមានគោលនយោបាយមួយក្នុងការអនុញ្ញាតឲក្មេងអាយុក្រោមមួយឆ្នាំចូលលេងកំសាន្តនៅក្នុងហាងយើងខ្ញុំដោយមិនបាច់បង់ប្រាក់។</li>
									<li>ខ្ញុំបានអានលក្ខខណ្ឌ</li>	
								</ul>
							</div>

						</div>
						<div class="col-md-12 col-xs-12">
							<h3><?= lang("General information", "General information"); ?></h3>
							<h4 class="text-left">ឈ្មោះឪពុក ម្ដាយ  : (អាយុចាប់ពី១៨ឆ្នាំឡើងទៅ)</h4>
								<div class="form-group col-md-12">
									<div class="col-md-3" style="padding: 0px;">
										<label class="container-checkbox">ឪពុក
										  <input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==1 ? 'checked': FALSE; ?> disabled>
										</label>
									</div>
									<div class="col-md-3" style="padding: 0px;">
										<label class="container-checkbox">ម្ដាយ
										  <input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==2 ? 'checked': FALSE; ?> disabled>
										</label>
									</div>
									<div class="col-md-3" >
										<label class="container-checkbox">ផ្សេងទៀត
										  <input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==3 ? 'checked': FALSE; ?> disabled>
										</label>
									</div>
									<div class="col-md-3" style="padding: 0px;">
										<label class="container-checkbox">គ្រូបង្រៀន
										  <input type="radio" name="parent_type" id="parent_type" <?= $result->parent_type==4 ? 'checked': FALSE; ?> disabled>
										</label>
									</div>
								</div>
									<div class="form-group col-md-12">
										<label class="label_green">ឈ្មោះឪពុក</label>
										<input type="text" class="form-control" name="father_name" id="father_name" value="<?= $result->father_name ?>" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">ឈ្មោះម្ដាយ</label>
										<input type="text" class="form-control" name="mother_name" id="mother_name"  value="<?= $result->mother_name ?>" readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">ឈ្មោះផ្សេងទៀត</label>
										<input type="text" class="form-control" name="phone" value="<?= $result->others_name ?>" id="phone" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">ឈ្មោះគ្រូបង្រៀន</label>
										<input type="text" class="form-control" name="phone" value="<?= $result->teacher_name ?>" id="phone" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">លេខទូរសព្វ័</label>
										<input type="text" class="form-control" name="phone" value="<?= $result->phone_number ?>" id="phone" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">អ៊ីម៉ែល</label>
										<input type="text" class="form-control" name="email" id="email"   value="<?= $result->email ?>" required readonly>
									</div>
								<h3><?= lang("Kids Name", "Kids Name"); ?></h3>
									<div class="form-group col-md-12">
										<label class="label_green">ឈ្មោះក្មេង 1</label>
										<input type="text" class="form-control"  value="<?= $result->kid_name1 ?>" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">ឈ្មោះក្មេង 2</label>
										<input type="text" class="form-control" value="<?= $result->kid_name2 ?>" readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">ឈ្មោះក្មេង 3</label>
										<input type="text" class="form-control" value="<?= $result->kid_name3 ?>" required readonly>
									</div>
									
									<div class="form-group col-md-12">
										<label class="label_green">ឈ្មោះក្មេង 4</label>
										<input type="text" class="form-control" value="<?= $result->kid_name4 ?>" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">ឈ្មោះក្មេង 5</label>
										<input type="text" class="form-control" value="<?= $result->kid_name5 ?>" readonly>
									</div>
									
									<div class="form-group col-md-12">
										<label class="label_green">ឈ្មោះក្មេង 6</label>
										<input type="text" class="form-control" value="<?= $result->kid_name6 ?>" required readonly>
									</div>
									<div class="form-group col-md-12">
										<label class="label_green">ចំនួនក្មេង</label>
										<input type="text" class="form-control" value="<?= $result->no_of_kids ?>" readonly>
									</div>
							<h3>Image</h3>
								<div class="form-group col-md-6">
									<label class="label_green">រូបអតិថិជន</label>
									<div class="clear"></div>			
									<img  src="<?=base_url()?>assets/uploads/<?= !empty($result->photo) ? $result->photo : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
								</div>
								<div class="form-group col-md-6">
									<label class="label_green">ហត្ថាលេខា</label>
									<div class="clear"></div>			
									<img src="<?=base_url()?>assets/uploads/<?= !empty($result->signature) ? $result->signature : 'no_image.jpg'; ?>" border="0" disabled width="100" height="100" />
								</div>
							<h3>Date</h3>
							<div class="form-group col-md-12">
								<label class="label_green"></label>
								<div class="clear"></div>
								<input type="text" class="form-control" value="<?= date('d/m/Y h:i', strtotime($result->created_on)) ?>" required readonly>
							</div>
							<div class="form-group col-md-12">
								<label class="label_green"></label>
								<div class="clear"></div>			
								<input type="checkbox" name="accept" id="accept" <?= $result->accept==1 ? 'checked': FALSE; ?> disabled> &nbsp;<b>ខ្ញុំយល់ព្រមតាមបទបញ្ចាខាងលើ</b>
							</div>
					</div>
        <div class="col-sm-12 last_sa_se"><?php //echo form_submit('edit_farmer', lang('submit'), 'class="btn btn-primary"'); ?></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
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