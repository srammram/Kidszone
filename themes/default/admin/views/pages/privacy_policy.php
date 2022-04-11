<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <script type="text/javascript">
        if (parent.frames.length !== 0) { top.location = '<?=admin_url()?>'; }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= $assets ?>images/fav.png"/>
    <link href="<?= $assets ?>styles/theme.css" rel="stylesheet"/>
    <link href="<?= $assets ?>styles/style.css" rel="stylesheet"/>
    <link href="<?= $assets ?>styles/helpers/login.css" rel="stylesheet"/>
    <script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
    <!--[if lt IE 9]>
    <script src="<?= $assets ?>js/respond.min.js"></script>
    <![endif]-->
    <style>
        body{
            background:none;
        }
        .footer ul{
            list-style:none;
            margin: 0px;padding:0px;
        }
        .footer ul li{display:inline-block;padding-right:15px}
        .footer ul li a{color:#ccc;font-size:12px;font-weight:normal;letter-spacing:1px;}
        .footer ul li a:hover{text-decoration:none;color:#ddd}
        footer{background-color:#333;position:absolute;bottom:0px;}
        .header{
            background-color:#efefef;
            padding:15px 0px;
        }
        .div-titles h3{font-size:18px!important;font-weight:bold;margin-bottom:20px;}

        @media (min-width: 1200px){
        .container {
            width: 1170px !important;
        }
    }
    </style>
</head>

<body class="login-page">
    <noscript>
        <div class="global-site-notice noscript">
            <div class="notice-inner">
                <p>
                    <strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in
                    your browser to utilize the functionality of this website.
                </p>
            </div>
        </div>
    </noscript>
   
	<header class="header">
        <div class="container">
            <div class="row">
                <div class="logo_section">
                        <?php if ($Settings->logo2) {
                            echo '<img src="' . base_url('assets/uploads/logos/' . $Settings->logo2) . '" alt="' . $Settings->site_name . '" style="position:relative; left:40%;top:5%;" />';
                        } ?>
                </div>
            </div>
        </div>
    </header>	
		
		
   <section class="privacy_policy">
        <div class="container">
            <div class="row">
                <div class="div-titles">
                    <h3>Privacy Policy</h3>
                </div>

                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Itaque id vero quibusdam saepe. Ut doloribus consequuntur vel sunt odit libero molestiae nulla, quae voluptates sint at sapiente nam nesciunt neque.</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Itaque id vero quibusdam saepe. Ut doloribus consequuntur vel sunt odit libero molestiae nulla, quae voluptates sint at sapiente nam nesciunt neque.</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Itaque id vero quibusdam saepe. Ut doloribus consequuntur vel sunt odit libero molestiae nulla, quae voluptates sint at sapiente nam nesciunt neque.</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Itaque id vero quibusdam saepe. Ut doloribus consequuntur vel sunt odit libero molestiae nulla, quae voluptates sint at sapiente nam nesciunt neque.</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Itaque id vero quibusdam saepe. Ut doloribus consequuntur vel sunt odit libero molestiae nulla, quae voluptates sint at sapiente nam nesciunt neque.</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Itaque id vero quibusdam saepe. Ut doloribus consequuntur vel sunt odit libero molestiae nulla, quae voluptates sint at sapiente nam nesciunt neque.</p>
                
            </div>
        </div>
   </section>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <ul class="pull-right">
                    <li><a href="<?= admin_url('auth/login'); ?>">Login</a></li>
                    <li><a href="<?= admin_url('pages/privacy_policy'); ?>">Privacy Policy</a></li>
                    <li><a href="<?= admin_url('pages/terms_conditions'); ?>">Terms Conditions</a></li>
                </ul>
            </div>
        </div>
    </footer>
    <script src="<?= $assets ?>js/jquery.js"></script>
    <script src="<?= $assets ?>js/bootstrap.min.js"></script>
    <script src="<?= $assets ?>js/jquery.cookie.js"></script>
    <script src="<?= $assets ?>js/login.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            localStorage.clear();
            var hash = window.location.hash;
            if (hash && hash != '') {
                $("#login").hide();
                $(hash).show();
            }
        });
    </script>
</body>
</html>
