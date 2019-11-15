<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registration Form</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="<?= $assets ?>styles/jquery.mCustomScrollbar.css" rel="stylesheet"/>
<link rel="shortcut icon" href="<?= $assets ?>images/fav.png"/>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?= $assets ?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<style>
	body {
    height: 100vh;
    width: 100%;
    background: url(<?=base_url()?>themes/default/admin/views/frontend/images/login_bg.png) no-repeat;
    background-color: transparent;
	background-size: 100% 100%;
	font-family: 'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif;
}
/*	.kidszoona{background: url(images/1.jpg) no-repeat;background-size: 100% 100%;width: 100%;height: 100vh;overflow: hidden}*/
/*	.kidszoona::after{content: '';position: absolute;width: 100%;height: 100vh;background-color: rgba(0,0,0,0.6);overflow: hidden;}*/
/* The container */
.container-checkbox {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 16px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
	font-weight: normal;
}

/* Hide the browser's default checkbox */
.container-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.container-checkbox .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #31708f;
}

/* On mouse-over, add a grey background color */
.container-checkbox:hover input ~ .checkmark {
    background-color: #31708f;
}

/* When the checkbox is checked, add a blue background */
.container-checkbox input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.container-checkbox .checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container-checkbox input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container-checkbox .checkmark:after {
    left: 7px;
    top: 4px;
    width: 5px;
    height: 11px;
    border: solid white;
    border-width: 0 2px 2px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
	.kids_list{padding: 0px;}
	.kids_list ol{margin: 0px;padding: 0px 0px 0px 10%;}
	.kids_list ol li{margin-bottom: 10px;float: left;}
	.kids_list ol li input{width: 100%;}
	.kidszoona h4{margin-bottom: 30px;margin-top: 0px;font-weight: bold;}
	.kidszoona{padding: 30px 0px 0px;height: 99vh;transition: all .2s ease-in;}
	.kidszoona .form-group{padding: 0px;}
	.kidszon_content h4,.kidszon_content .h4{font-weight: bold;}
	.kidszoona .kidszon_content h4,.kidszoona .kidszon_content .h4{margin-bottom: 15px;position: relative;}
	.kidszon_content ul{list-style: none;padding: 0px;margin: 0px 0px 15px;}
	.kidszon_content ul li{padding-left: 20px;line-height: 26px;position: relative;}
	.kidszon_content ul li::before{content: '';position: absolute;width: 5px;height: 5px;background-color: darkblue;left: 10px;top: 10px;}
	.kidszon_content h4::after{content: '';background-color: darkred;width:6%;height: 2px;left: 0px;position: absolute;bottom: -5px;}
	.kids_zon_c{padding: 0px;}
	.show_hidden{background-color: #1c94d2;display: block;position: absolute;padding: 0px;cursor: pointer;margin-right: 3px;font-weight: normal;border: 1px solid #1c94d2;left:15%;top: 0px;color: #fff;width: 103px;text-align: center;font-size: 12px;}
	.show_hidden1{background-color: #1c94d2;display: block;position: absolute;padding: 0px;cursor: pointer;margin-right: 3px;font-weight: normal;border: 1px solid #1c94d2;left:15%;top: 0px;color: #fff;width: 103px;text-align: center;font-size: 12px;}
	.show_hidden2{background-color: #1c94d2;display: block;position: absolute;padding: 0px;cursor: pointer;margin-right: 3px;font-weight: normal;border: 1px solid #1c94d2;left:15%;top: 0px;color: #fff;width: 103px;text-align: center;font-size: 12px;}
	.form-control-feedback{right: 10px;}
/*	*/
	.kids_list ol {
    list-style: none;
    counter-reset: my-awesome-counter;}
	.kids_list ol li {
    counter-increment: my-awesome-counter;
    position: relative;}
	.kids_list ol li::before {
    content: counter(my-awesome-counter) ". ";
    color: #31708f;
    font-weight: bold;
	position: absolute;
    left: -2px;
    top: 5px;}
</style>
</head>

<body>
<?php echo frontend_form_open("register", 'class="login" data-toggle="validator" enctype="multipart/form-data"'); ?>

<section class="kidszoona">
	<div class="container-fluid">
		<div class="row">
			
			<div class="col-md-6 col-md-offset-6 col-xs-12">
				<div class="col-md-12 text-center">
					<img src="<?=base_url()?>assets/uploads/logos/logo_inner.png" alt="kidszoona">
				</div>
				<div class="col-md-12 kidszon_content">
					<h3 class="h4">Dear all customers</h3>
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
				<div class="col-md-12">
					<h4 class="text-left">Parent name: (Age over 18 years old)</h4>
					<form>
						<div class="form-group col-md-12">
							<div class="col-md-4">
								<label class="container-checkbox">Father Name
								  <input type="radio" name="parent_type" id="parent_type" value="1">
								  <span class="checkmark"></span>
								</label>
							</div>
							<div class="col-md-4">
								<label class="container-checkbox">Mother Name
								  <input type="radio" name="parent_type" id="parent_type" value="2">
								  <span class="checkmark"></span>
								</label>
							</div>
							<div class="col-md-4">
								<label class="container-checkbox">Others
								  <input type="radio" name="parent_type" id="parent_type" value="3">
								  <span class="checkmark"></span>
								</label>
							</div>
						</div>
						<div class="form-group col-md-12">
							<label class="col-md-5">Father Name:</label>
							<div class="col-md-7">
								<input type="text" class="form-control" name="father_name" id="father_name">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label class="col-md-5">Mother Name:</label>
							<div class="col-md-7">
								<input type="text" class="form-control" name="mother_name" id="mother_name">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label class="col-md-5">Phone:</label>
							<div class="col-md-7">
								<input type="text" class="form-control" name="phone_number" id="phone_number">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label class="col-md-5">Email:</label>
							<div class="col-md-7">
								<input type="text" class="form-control" name="email" id="email">
							</div>
						</div>
						<div class="form-group col-md-12">
							<label class="col-md-12">Kids name: </label>
							<div class="col-md-12 kids_list">
								<ol>
									<li class="col-md-6"><input type="text" class="form-control" name="kid_name1" id="kid_name1"></li>
									<li class="col-md-6"><input type="text" class="form-control" name="kid_name2" id="kid_name2"></li>
									<li class="col-md-6"><input type="text" class="form-control" name="kid_name3" id="kid_name3"></li>
									<li class="col-md-6"><input type="text" class="form-control" name="kid_name4" id="kid_name4"></li>
									<li class="col-md-6"><input type="text" class="form-control" name="kid_name5" id="kid_name5"></li>
									<li class="col-md-6"><input type="text" class="form-control" name="kid_name6" id="kid_name6"></li>
								</ol>
							</div>
						</div>
						<div class="form-group col-md-12" style="padding: 0px 15px;">
							<label class="container-checkbox col-md-12">I agree to follow the rules
							  <input type="checkbox" name="accept" id="accept">
							  <span class="checkmark"></span>
							</label>
						</div>
						<div class="form-group col-md-6">
							<label class="col-md-12">Signature</label>
							<div class="col-md-12">
								<input type="file" data-browse-label="<?= lang('browse'); ?>" name="signature" id="signature" data-show-upload="false" data-show-preview="false" class="form-control" accept="im/*">
							</div>
						</div>
						<div class="form-group col-md-6">
							<label class="col-md-12">Date</label>
							<div class="col-md-12">
								<input type="text" class="form-control" name="reg_date" id="reg_date">
							</div>
						</div>
						<div class="form-group col-md-12">
							<input type="submit" class="btn btn-danger center-block" value="Upload">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?php echo form_close(); ?>
</body>
</html>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
$(document).ready(function() {
$('form[class="login"]').bootstrapValidator({
	message: 'This value is not valid',
	 feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		excluded: ':disabled',
        fields: {
			parent_type: {
                validators: {
                    notEmpty: {
                     message: 'Please select at least 1 parent type.'
                    }
                }
       		},
			father_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter father name'
                    },

                    regexp: {
                       regexp: /^[a-zA-Z0-9_ \s]+$/,
                        message: 'The make can only consist of alphabetical, number, space and underscore'
                    }
                }
            },
			father_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Father Name'
                    },
                    regexp: {
                       regexp: /^[a-zA-Z0-9_ \s]+$/,
                        message: 'The make can only consist of alphabetical, number, space and underscore'
                    }
                }
            },
			mother_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Mother Name'
                    },
                    regexp: {
                       regexp: /^[a-zA-Z0-9_ \s]+$/,
                        message: 'The make can only consist of alphabetical, number, space and underscore'
                    }
                }
            },
			phone_number: {
				validators: {
				notEmpty: {
						message: 'Please Enter Mobile Number'
				},
				stringLength: {
						min:7,
						max: 15,
						message: 'Please put 15 digit mobile number'
					},
					regexp: {
						regexp: /^[0-9 ]+$/,
						message: 'The Mobile number can only consist of number'
					}
				}
        	},
			email: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Email Address'
                    }
                }
            },
			kid_name1: {
                validators: {
                    /*notEmpty: {
                        message: 'Please enter Email Address'
                    }*/
                    regexp: {
                       regexp: /^[a-zA-Z0-9_ \s]+$/,
                        message: 'The make can only consist of alphabetical, number, space and underscore'
                    }
                }
            },
			kid_name2: {
                validators: {
                    regexp: {
                       regexp: /^[a-zA-Z0-9_ \s]+$/,
                        message: 'The make can only consist of alphabetical, number, space and underscore'
                    }
                }
            },
			kid_name3: {
                validators: {
                    regexp: {
                       regexp: /^[a-zA-Z0-9_ \s]+$/,
                        message: 'The make can only consist of alphabetical, number, space and underscore'
                    }
                }
            },
			kid_name4: {
                validators: {
                    regexp: {
                       regexp: /^[a-zA-Z0-9_ \s]+$/,
                       message: 'The make can only consist of alphabetical, number, space and underscore'
                    }
                }
            },
			kid_name5: {
                validators: {
                    regexp: {
                       regexp: /^[a-zA-Z0-9_ \s]+$/,
                        message: 'The make can only consist of alphabetical, number, space and underscore'
                    }
                }
            },
			kid_name6: {
                validators: {
                    regexp: {
                       regexp: /^[a-zA-Z0-9_ \s]+$/,
                        message: 'The make can only consist of alphabetical, number, space and underscore'
                    }
                }
            },
			accept: {
                validators: {
                    notEmpty: {
                        message: 'Please select the I agree to follow the rules'
                    }
                }
            },
			signature: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpg,image/jpeg,image/png',
                        message: 'The selected file is not valid'
                    }
                }
            },
			/*reg_date: {
                validators: {
                    notEmpty: {
                        message: 'Please select the Date'
                    }
                }
            }*/

        	},

    })

});
</script>


<script>
$(function() {
    $("#reg_date").datepicker({
		dateFormat: 'dd-mm-yy' 
	});
});
	 $(document).ready(function(){
        $(".kidszoona").mCustomScrollbar({
          theme:"dark",
           mouseWheelPixels: 170,
        });
    });
</script>
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