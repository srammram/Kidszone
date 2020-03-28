<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <base href="<?= admin_url() ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
   
    <title><?= $page_title ?> - <?= $Settings->site_name ?></title>
    <link rel="shortcut icon" href="<?= $assets ?>images/fav.png"/>
    <link href="<?= $assets ?>styles/theme.css" rel="stylesheet"/>
    <link href="<?= $assets ?>styles/style.css" rel="stylesheet"/>
    <link href="<?= $assets ?>styles/flipclock.css" rel="stylesheet"/>
    <script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?= $assets ?>js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="<?= $assets ?>js/jquery.validate.js"></script>
    <script type="text/javascript" src="<?= $assets ?>js/flipclock.min.js"></script>
    <!--[if lt IE 9]>
    <script src="<?= $assets ?>js/jquery.js"></script>
    <![endif]-->
    <noscript><style type="text/css">#loading { display: none; }</style></noscript>
    <?php if ($Settings->user_rtl) { ?>
        <link href="<?= $assets ?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
        <link href="<?= $assets ?>styles/style-rtl.css" rel="stylesheet"/>
        <script type="text/javascript">
            $(document).ready(function () { $('.pull-right, .pull-left').addClass('flip'); });
        </script>
    <?php } ?>
    <script type="text/javascript">
        $(window).load(function () {
            $("#loading").fadeOut("slow");
        });
    </script>
	 <script type="text/javascript">
		/*$(document).ready(function() {
			$("li").on("contextmenu",function(){
			   return false;
			}); 
		}); */
	</script>
  
</head>
<?php
//echo '<pre>';
//print_r($this->data['menu']);
//$app_permission->formseven_enable
//echo $menu->{'formone-index'}."@@@";

//echo $this->data['menu']->{'formone-index'}."@@@";

?>
<body>
<noscript>
    <div class="global-site-notice noscript">
        <div class="notice-inner">
            <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in
                your browser to utilize the functionality of this website.</p>
        </div>
    </div>
</noscript>
<div id="loading"></div>
<div id="app_wrapper">
 <?php if(!isset($isMobileApp)) : ?>
    <header id="header" class="navbar">
        <div class="container">
            <a class="navbar-brand" href="<?= admin_url() ?>"><span class="logo">
            
            
       </span></a>

            <div class="btn-group visible-xs pull-right btn-visible-sm">
                <button class="navbar-toggle btn" type="button" data-toggle="collapse" data-target="#sidebar_menu">
                    <span class="fa fa-bars"></span>
                </button>
                <a href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')); ?>" class="btn">
                    <span class="fa fa-user"></span>
                </a>
                <a href="<?= admin_url('logout'); ?>" class="btn">
                    <span class="fa fa-sign-out"></span>
                </a>
            </div>
            <div class="header-nav">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown">
                        <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
                            <img alt="" src="<?= $this->session->userdata('avatar') ? base_url() . 'assets/uploads/avatars/thumbs/' . $this->session->userdata('avatar') : base_url('assets/images/' . $this->session->userdata('gender') . '.png'); ?>" class="mini_avatar img-rounded">

                            <div class="user">
                                <span><?= lang('welcome') ?> <?= $this->session->userdata('username'); ?></span>
                            </div>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <<!--li>
                                <a href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')); ?>">
                                    <i class="fa fa-user"></i> <?= lang('profile'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= admin_url('users/profile/' . $this->session->userdata('user_id') . '/#cpassword'); ?>"><i class="fa fa-key"></i> <?= lang('change_password'); ?>
                                </a>
                            </li>
                            <li class="divider"></li>-->
                            <li>
                                <a href="<?= admin_url('logout'); ?>">
                                    <i class="fa fa-sign-out"></i> <?= lang('logout'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                
            </div>
        </div>
    </header>
<?php endif; ?>
    <div class="container" id="container">
        <div class="row" id="main-con">
        <table class="lt"><tr>
        <?php if(!isset($isMobileApp)) : ?>
        <td class="sidebar-con">
         
            <div id="sidebar-left">
                <div class="sidebar-nav nav-collapse collapse navbar-collapse" id="sidebar_menu">
                    <ul class="nav main-menu">
                       <li class="logo_img_s">
                       	<img src="<?= base_url(); ?>assets/uploads/logos/logo.png" alt="logo inner" class="center-block">
                       </li>
                        <li class="mm_welcome active">
                            <a href="<?= admin_url() ?>">
                                <i class="fa fa-dashboard"></i>
                                <span class="text"> <?= lang('dashboard'); ?></span>
                            </a>
                        </li>

                        <?php
                        if ($Owner || $Admin) {
                            ?>

                            <li class="mm_contract">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-star"></i>
                                    <span class="text"> Register </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="contract_index">
                                        <a class="submenu" href="<?= admin_url('register'); ?>">
                                           <i class="fa fa-star"></i>
                                            <span class="text"> Register list</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="mm_contract">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-star"></i>
                                    <span class="text"> Safety Message </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="contract_index">
                                        <a class="submenu" href="<?= admin_url('safety'); ?>">
                                           <i class="fa fa-star"></i>
                                            <span class="text"> Safety Message list</span>
                                        </a>
                                    </li>
                                    <!--<li id="contract_add">
                                        <a class="submenu" href="<?= admin_url('safety/safety_add'); ?>">
                                           <i class="fa fa-star"></i>
                                            <span class="text"> Safety Message Add</span>
                                        </a>
                                    </li>-->
                                </ul>
                            </li>

                            <li class="mm_contract">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-star"></i>
                                    <span class="text"> People </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="contract_index">
                                        <a class="submenu" href="<?= admin_url('staff'); ?>">
                                           <i class="fa fa-star"></i>
                                            <span class="text"> Staff list</span>
                                        </a>
                                    </li>
                                    <li id="contract_add">
                                        <a class="submenu" href="<?= admin_url('staff/add_staff'); ?>">
                                           <i class="fa fa-star"></i>
                                            <span class="text"> Staff Add</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="mm_contract">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-star"></i>
                                    <span class="text"> Outlet </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="contract_index">
                                        <a class="submenu" href="<?= admin_url('outlet'); ?>">
                                           <i class="fa fa-star"></i>
                                            <span class="text"> Outlet list</span>
                                        </a>
                                    </li>
                                    <li id="contract_add">
                                        <a class="submenu" href="<?= admin_url('outlet/add_outlet'); ?>">
                                           <i class="fa fa-star"></i>
                                            <span class="text"> Outlet Add</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            
                            <?php if ($Owner1 || $Admin1) { ?>
                                <li class="mm_system_settings" >
                                    <a class="dropmenu" href="#">
                                        <i class="fa fa-cog"></i>
                                        <span class="text"> <?= lang('settings'); ?> </span>
                                        <span class="chevron closed"></span>
                                    </a>
                                    <ul>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('system_settings'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/form') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('form_settings'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/department') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('department'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/role') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('role'); ?></span>
                                            </a>
                                        </li>
                                        
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/province') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('province'); ?></span>
                                            </a>
                                        </li>
                                        
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/district') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('district'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/commune') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('commune'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/village') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('village'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/pets') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('pets'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/pets_type') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('pets_type'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/hygine') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('hygine'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/general_hygine') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('general_hygine'); ?></span>
                                            </a>
                                        </li>
                                        
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/source_of_water') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('source_of_water'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/currency') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('currency'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/equipment') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('equipment'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/expanse') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('expanse'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings/occupations') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('occupations'); ?></span>
                                            </a>
                                        </li>
                                        <!--<li id="system_settings_index">
                                            <a href="<?= admin_url('groups') ?>">
                                               <i class="fa fa-star"></i>
                                                <span class="text"> <?= lang('groups'); ?></span>
                                            </a>
                                        </li>-->
                                    </ul>
                                </li>
                            <?php } ?>
                            

                                </ul>
                            </li>
                           
                           
                        <?php
                        } else { // not owner and not admin 
                        } ?>
                    </ul>
                </div>
<!--
                <a href="#" id="main-menu-act" class="minified visible-md visible-lg">
                    <i class="fa fa-angle-double-left"></i>
                </a>
-->
            </div>
            
            </td>
            <?php endif; ?>
        <td class="content-con">
            <div id="content">
             <?php if(!isset($isMobileApp)) : ?>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <ul class="breadcrumb">
                            <?php
                            foreach ($bc as $b) {
                                if ($b['link'] === '#') {
                                    echo '<li class="active">' . $b['page'] . '</li>';
                                } else {
                                    echo '<li><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
                                }
                            }
                            ?>
                            <!--<li class="right_log hidden-xs">
                               <?php echo lang('enter_info'); ?>
                            </li>-->
                        </ul>
                        
                    </div>
                </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($message) { ?>
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close" type="button">X</button>
                                <?= $message; ?>
                            </div>
                        <?php } ?>
                        <?php if ($error) { ?>
                            <div class="alert alert-danger">
                                <button data-dismiss="alert" class="close" type="button">X</button>
                                <?= $error; ?>
                            </div>
                        <?php } ?>
                        <?php if ($warning) { ?>
                            <div class="alert alert-warning">
                                <button data-dismiss="alert" class="close" type="button">X</button>
                                <?= $warning; ?>
                            </div>
                        <?php } ?>
                        <?php
                        if (@$info) {
                            foreach ($info as $n) {
                                if (!$this->session->userdata('hidden' . $n->id)) {
                                    ?>
                                    <div class="alert alert-info">
                                        <a href="#" id="<?= $n->id ?>" class="close hideComment external"
                                           data-dismiss="alert">&times;</a>
                                        <?= $n->comment; ?>
                                    </div>
                                <?php }
                            }
                        } ?>
                        <div class="alerts-con"></div>
<style>
 .main-menu .mm_reports a.submenu{
    height: 20px !important;
    background-color: transparent !important;
    color: #696969 !important;
    padding-top: 3px !important;
    padding-left: 16px !important;
    border-bottom: none !important;
}
.main-menu .mm_reports a.submenu span{
    white-space: normal;
   
    display: inline-block;
    width: 190px;
}
.mm_reports ul li ul li{
    background : none !important;
}
.main-menu .mm_procurment a.submenu{
    height: 20px !important;
    background-color: transparent !important;
    color: #696969 ;
    padding-top: 3px !important;
    padding-left: 16px !important;
    border-bottom: none !important;
}
.main-menu .mm_procurment a.submenu span{
    white-space: normal;
   
    display: inline-block;
    width: 190px;
}
.mm_procurment ul li ul li{
    background : none !important;
}
</style>

<script>
	
	
		$('.main-menu li a').click(function() {
    $('li').removeClass();
    $(this).closest(".sidebar-nav > ul > li").addClass('active');
    $(this).parent().addClass('active');
});
//	
//$(document).ready(function(){
//        if($(".main-menu li .dropdown  a").attr("href")==window.location.href){
//            $(".main-menu li .dropdown").attr("class","dropdown active");
//        }
//       else{
//          $(".main-menu li .dropdown").attr("class","dropdown");
//         }
//    });
</script>