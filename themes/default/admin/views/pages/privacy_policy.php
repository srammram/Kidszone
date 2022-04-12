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
        footer{background-color:#333;position:relative;bottom:0px;}
        .header{
            background-color:#efefef;
            padding:15px 0px;
        }
        .div-titles h3{font-size:18px!important;font-weight:bold;margin-bottom:20px;}
        .privacy_policy p{margin-bottom:20px;}
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
                <p>This Privacy Policy governs the manner in which Kidzoon collects, uses, maintains and discloses information collected from users (each, a "User") of the Kidzoon application. This privacy policy applies to the application and all products and services offered by the same.</p>
                <p><b>Personal identification information</b></p>
                <p>We may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users utilize the application, register on the application, fill out a form, and in connection with other activities, services, features or resources we make available on our application. Users may be asked for, as appropriate, name, email address, mailing address, phone number, credit card (iff required) information. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personally identification information, except that it may prevent them from engaging in certain application related activities.</p>
                <p><b>Non-personal identification information</b></p>
                <p>We may collect non-personal identification information about Users whenever they interact with our application. Non-personal identification information may include the browser name, the type of computer and technical information about Users means of connection to our application, such as the operating system and the Internet service provider’s utilized and other similar information.</p>
                <p><b>How we use collected information</b></p>
                <p>Kidzoon may collect and use Users personal information for the following purposes:</p>
                <p>- To improve customer service</p>
                <p>Information you provide helps us respond to your customer service requests and support needs more efficiently.</p>
                <p>- To personalize user experience</p>
                <p>We may use information in the aggregate to understand how our Users as a group use the services and resources provided on our application.</p>
                <p>- To improve our application</p>
                <p>We may use feedback you provide to improve our products and services.</p>
                <p>- To send periodic emails</p>
                <p>We may use the email address to send User information and updates pertaining to their order. It may also be used to respond to their inquiries, questions, and/or other requests. If User decides to opt-in to our mailing list, they will receive emails that may include company news, updates, related product or service information, etc. If at any time the User would like to unsubscribe from receiving future emails, we include detailed unsubscribe instructions at the bottom of each email.</p>
                <p><b>How we protect your information</b></p>
                <p>We adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of your personal information, username, password, transaction information and data stored on our application.</p>
                <p><b>Sharing your personal information</b></p>
                <p>We do not sell, trade, or rent Users personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates and advertisers for the purposes outlined above.</p>
                <p><b>Changes to this privacy policy</b></p>
                <p>Kidzoon has the discretion to update this privacy policy at any time. We encourage Users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect. You acknowledge and agree that it is your responsibility to review this privacy policy periodically and become aware of modifications.</p>
                <p>Your acceptance of these terms</p>
                <p>By using this application, you signify your acceptance of this policy. If you do not agree to this policy, please do not use our application. Your continued use of the application following the posting of changes to this policy will be deemed your acceptance of those changes.</p>
                
            </div>
        </div>
   </section>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <ul class="pull-right">
                    <li><a href="<?= admin_url('auth/login'); ?>">Login</a></li>
                    <li><a href="<?= admin_url('pages/privacy_policy'); ?>">Privacy Policy</a></li>
                    <!-- <li><a href="<?= admin_url('pages/terms_conditions'); ?>">Terms Conditions</a></li> -->
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
