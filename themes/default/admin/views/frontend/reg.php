<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>


<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>

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
    height: 25px;
    width: 25px;
    background-color: #ccc;
}

/* On mouse-over, add a grey background color */
.container-checkbox:hover input ~ .checkmark {
    background-color: #ccc;
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
    left: 9px;
    top: 5px;
    width: 5px;
    height: 12px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
	.kids_list ol{margin: 0px;padding: 0px 0px 0px 10%;}
	.kids_list ol li{margin-bottom: 10px;width: 50%;float: left;}
	.kids_list ol li input{width: 90%;}
	.kidszoona h4{margin-bottom: 30px;margin-top: 0px;}
	.kidszoona{padding: 50px 0px;}
</style>
</head>

<body>
<?php echo frontend_form_open("register", 'class="login" data-toggle="validator" enctype="multipart/form-data"'); ?>

<section class="kidszoona">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="col-md-6">
					<img src="<?=base_url()?>themes/default/admin/views/frontend/images/5.png" alt="kidszoona" width="100%">
				</div>
				<div class="col-md-6">
					<h4 class="text-center">Parent name: (Age over 18 years old)</h4>
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
							<label class="col-md-5">Others:</label>
							<div class="col-md-7">
								<input type="text" class="form-control" name="others_name" id="others_name">
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
									<li><input type="text" class="form-control" name="kid_name1" id="kid_name1"></li>
									<li><input type="text" class="form-control" name="kid_name2" id="kid_name2"></li>
									<li><input type="text" class="form-control" name="kid_name3" id="kid_name3"></li>
									<li><input type="text" class="form-control" name="kid_name4" id="kid_name4"></li>
									<li><input type="text" class="form-control" name="kid_name5" id="kid_name5"></li>
									<li><input type="text" class="form-control" name="kid_name6" id="kid_name6"></li>
								</ol>
							</div>
						</div>
						<div class="form-group col-md-12">
							<label class="container-checkbox">I agree to follow the rules
							  <input type="checkbox" name="accept" id="accept">
							  <span class="checkmark"></span>
							</label>
						</div>
						<div class="form-group col-md-6">
							<label>Photo</label>
							<input type="file" data-browse-label="<?= lang('browse'); ?>" name="photo" id="photo" data-show-upload="false" data-show-preview="false" class="form-control" accept="im/*">
						</div>
						<div class="form-group col-md-6">
							<label>Signature</label>
							<input type="file" data-browse-label="<?= lang('browse'); ?>" name="signature" id="signature" data-show-upload="false" data-show-preview="false" class="form-control" accept="im/*">
						</div>
						<div class="form-group col-md-6">
							<label>Date</label>
							<input type="text" class="form-control" name="reg_date" id="reg_date">
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
                    },
                    emailAddress: {
                        message: 'The value is not a valid email address'
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
			photo: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpg,image/jpeg,image/png',
                        message: 'The selected file is not valid'
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
			reg_date: {
                validators: {
                    notEmpty: {
                        message: 'Please select the Date'
                    }
                }
            }

        	},

    })

});
</script>


<script>
$(function() {
    $("#reg_date").datepicker({
		dateFormat: 'dd-mm-yy'
	})
    .on('change', function() {

           $('.login').bootstrapValidator('updateStatus', 'reg_date', 'NOT_VALIDATED')
           .bootstrapValidator('validateField', 'reg_date');

    })
});
</script>



<script>
$(document).ready(function() {

		$('#accept_all').on('ifChanged', function(event) {
			$('.check').iCheck('check');
		});

		$('#accept_all').on('ifUnchecked', function(event) {
			$('.check').iCheck('uncheck');
		});


})


</script>