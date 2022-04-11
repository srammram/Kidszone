<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <script type="text/javascript">if (parent.frames.length !== 0) { top.location = '<?=admin_url()?>'; }</script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= $assets ?>images/fav.png"/>
    <link href="<?= $assets ?>styles/theme.css" rel="stylesheet"/>
    <link href="<?= $assets ?>styles/style.css" rel="stylesheet"/>
    <link href="<?= $assets ?>styles/helpers/login.css" rel="stylesheet"/>
    <script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
    <!--[if lt IE 9]>
    <script src="<?= $assets ?>js/respond.min.js"></script>
    <![endif]-->

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
    <div class="container">
        <div class="row">
            <?php if ($Settings->logo2) {
                echo '<img src="' . base_url('assets/uploads/logos/' . $Settings->logo2) . '" alt="' . $Settings->site_name . '" style="position:absolute; left:40%;top:5%;" />';
            } ?>
            
        </div>

    </div>
		<a href="<?= admin_url('auth/login'); ?>">Login</a>
		<a href="<?= admin_url('pages/privacy_policy'); ?>">Privacy Policy</a>
		<a href="<?= admin_url('pages/terms_conditions'); ?>">Terms Conditions</a>
    <div class="page-back">


        <div id="login">
            <div class=" container">

                <div class="login-form-div">
                    <div class="login-content">

                        <div class="div-title col-sm-12">
                            <h3 class="text-primary">Privacy Policy</h3>
                        </div>
                        <div class="col-sm-12">
                            <div class="textbox-wrap form-group">
                                <div class="input-group">

								
								
Privacy Policy

This Privacy Policy explains how we collect, process, use, share and protect information about you. It also tells you how you can access and update your information and make certain choices about how your information is used.

The Privacy Policy covers both “online” (e.g., web and mobile services, including any websites operated by us such as http://www.kidzooona.com/ or Mobile Application, however accessed and/or used, whether via personal computers, mobile devices or otherwise) and “offline” (e.g., collection of data through mailings, telephone, or in person) activities owned, operated, provided, or made available by the Company. Our “online” and “offline” activities, in relation to facilitation of taxi hire services through a network of third party drivers and taxi operators, are collectively referenced as the “Services”. This Privacy Policy also applies to your use of interactive features or downloads that: (i) we own or control; (ii) are available through the Services; or (iii) interact with the Services and post or incorporate this Privacy Policy.

BY ACCEPTING THE CUSTOMER TERMS AND CONDITIONS, YOU AGREE TO THE TERMS OF THIS PRIVACY POLICY. Please review the following carefully so that you understand our privacy practices. If you do not agree to this Privacy Policy, do not accept the Customer Terms and Conditions or use our Services. This Privacy Policy is incorporated by reference into the Customer Terms and Conditions.

If you have questions about this Privacy Policy, please contact us through email address provided on our website and/ or Mobile Application.

1. DEFINITIONS

Unless otherwise provided in this Privacy Policy, the terms capitalized in the Privacy Policy shall have the meaning as provided hereunder:

“Co-branded Services” shall have the meaning assigned to the term in paragraph 4(c) hereto.
“Device” shall mean computer, mobile or other device used to access the Services.
“Device Identifier” shall mean IP address or other unique identifier for the Device.
“Mobile Application” shall mean application provided by us on the Device to access the Services.
“Mobile Device Information” shall have the meaning assigned to the term in paragraph 2(d)(ii) hereto.
“Promotion” shall mean any contest and other promotions offered by us.
“Protected Information” shall mean such categories of information that could reasonably be used to identify you personally, including your name, e-mail address, and mobile number.
“TPSP” shall mean a third party service provider.
“Usage Information” shall have the meaning assigned to the term in paragraph 2(b)(i) hereto.
2. WHAT INFORMATION DO WE COLLECT?

INFORMATION YOU PROVIDE TO US

We may ask you to provide us with certain Protected Information. We may collect this information through various means and in various places through the Services, including account registration forms, contact us forms, or when you otherwise interact with us. When you sign up to use the Services, you create a user profile. We shall ask you to provide only such Protected Information which is for lawful purpose connected with our Services and necessary to be collected by us for such purpose.

The current data fields that might be requested for are:

Email
Password
Name
Address
Mobile phone Number
Postal Code
Date of Birth
INFORMATION WE COLLECT AS YOU ACCESS AND USE OUR SERVICES

In addition to any Protected Information or other information that you choose to submit to us, we and our TPSP may use a variety of technologies that automatically (or passively) collect certain information whenever you visit or interact with the Services (“Usage Information”). This Usage Information may include the browser that you are using, the URL that referred you to our Services, all of the areas within our Services that you visit, and the time of day, among other information. In addition, we collect your Device Identifier for your Device. A Device Identifier is a number that is automatically assigned to your Device used to access the Services, and our computers identify your Device by its Device Identifier.
In case of booking via call centre, Kidzooona may record calls for quality and training purposes.
In addition, tracking information is collected as you navigate through our Services, including, but not limited to geographic areas. The driver’s mobile phone will send your GPS coordinates, during the ride, to our servers. Most GPS enabled mobile devices can define one’s location to within 50 feet.
Usage Information may be collected using a cookie. If you do not want information to be collected through the use of cookies, your browser allows you to deny or accept the use of cookies. Cookies can be disabled or controlled by setting a preference within your web browser or on your Device. If you choose to disable cookies or flash cookies on your Device, some features of the Services may not function properly or may not be able to customize the delivery of information to you. The Company cannot control the use of cookies (or the resulting information) by third parties, and use of third party cookies is not covered by our Privacy Policy.
INFORMATION THIRD PARTIES PROVIDE ABOUT YOU

We may, from time to time, supplement the information we collect about you through our website or Mobile Application or Services with outside records from third parties.

INFORMATION COLLECTED BY MOBILE APPLICATIONS

Our Services are primarily provided through the Mobile Application. We may collect and use technical data and related information, including but not limited to, technical information about your device, system and application software, and peripherals, that is gathered periodically to facilitate the provision of software updates, product support and other services to you (if any) related to such Mobile Applications.
When you use any of our Mobile Applications, the Mobile Application may automatically collect and store some or all of the following information from your mobile device (“Mobile Device Information”), in addition to the Device Information, including without limitation:
Your preferred language and country site (if applicable)
The manufacturer and model of your mobile device
Your mobile operating system
The type of mobile internet browsers you are using
Your geo location
Information about how you interact with the Mobile Application and any of our web sites to which the Mobile Application links, such as how many times you use a specific part of the Mobile Application over a given time period, the amount of time you spend using the Mobile Application, how often you use the Mobile Application, actions you take in the Mobile Application and how you engage with the Mobile Application
Information to allow us to personalize the services and content available through the Mobile Application
Data from SMS/ text messages upon receiving Device permissions for the purposes of (i) issuing and receiving one time passwords and other device verification, and (ii) automatically filling verification details during financial transactions, either through us or a third-party service provider, in accordance with applicable law. We do not share or transfer SMS/ text message data to any third party other than as provided under this Privacy Policy.
3. USE OF INFORMATION COLLECTED

Our primary goal in collecting your information is to provide you with an enhanced experience when using the Services. We use your information to closely monitor which features of the Services are used most, to allow you to view your trip history, rate trips, and to determine which features we need to focus on improving, including usage patterns and geographic locations to determine where we should offer or focus services, features and/or resources.
Based upon the Protected Information you provide us when registering for an account, we will send you a welcoming email to verify your username and password.
We use the information collected from our Mobile Application so that we are able to serve you the correct app version depending on your device type, for troubleshooting and in some cases, marketing purposes.
We use your Internet Protocol (IP) address to help diagnose problems with our computer server, and to administer our web site(s). Your IP address is used to help identify you, but contains no personal information about you.
We will send you strictly service-related announcements on rare occasions when it is necessary to do so. For instance, if our Services are temporarily suspended for maintenance, we might send you an email. If you do not wish to receive them, you have the option to deactivate your account.
We may use the information obtained from you to prevent, discover and investigate violations of this Privacy Policy or any applicable terms of service or terms of use for the Mobile Application, and to investigate fraud, chargeback or other matters.
We provide some of your Protected Information (such as your name, pick up address, contact number) to the driver who accepts your request for transportation so that the driver may contact and find you. The companies for which drivers work (that are providing the transportation service) are also able to access your Protected Information, including your geo-location data.
We also provide your information to the other users who shall be traveling with you in the vehicle assigned to you, should you choose any pooled vehicle feature of our Services.
We use that geo-location information for various purposes, including for you to be able to view the drivers in your area that are close to your location, for you to set your pick up location, for the drivers to identify the pick up location, to send you promotions and offers, and to allow you (if you choose through any features we may provide) to share this information with other people.
In addition, we may use your Protected Information or Usage Information that we collect about you:
To provide you with information or services or process transactions that you have requested or agreed to receive including to send you electronic newsletters, or to provide you with special offers or promotional materials on behalf of us or third parties;
To enable you to participate in a variety of the Services’ features such as online or mobile entry sweepstakes, contests or other promotions;
To contact you with regard to your use of the Services and, in our discretion, changes to the Services and/or the Services’ policies;
for internal business purposes;
for inclusion in our data analytics;
for purposes disclosed at the time you provide your information or as otherwise set forth in this Privacy Policy.
We may use the information collected from you for targeted advertising. This involves using information collected on an individual's web or mobile browsing behavior such as the pages they have visited or the searches they have made. This information is then used to select which advertisements should be displayed to a particular individual on websites other than our web site(s). The information collected is only linked to an anonymous cookie ID (alphanumeric number); it does not include any information that could be linked back to a particular person, such as their name, address or credit card number.
4. HOW AND WHEN DO WE DISCLOSE INFORMATION TO THIRD PARTIES

We do not sell, share, rent or trade the information we have collected about you, other than as disclosed within this Privacy Policy or at the time you provide your information. Following are the situations when information may be shared:

(a) WHEN YOU AGREE TO RECEIVE INFORMATION FROM THIRD PARTIES.

You may be presented with an opportunity to receive information and/or marketing offers directly from third parties. If you do agree to have your Protected Information shared, your Protected Information will be disclosed to such third parties and all information you disclose will be subject to the privacy policy and practices of such third parties. We are not responsible for the privacy policies and practices of such third parties and, therefore, you should review the privacy policies and practices of such third parties prior to agreeing to receive such information from them. If you later decide that you no longer want to receive communication from a third party, you will need to contact that third party directly.

(b) THIRD PARTIES PROVIDING SERVICES ON OUR BEHALF

We use third party companies and individuals to facilitate our Services, provide or perform certain aspects of the Services on our behalf – such as drivers and companies they work for to provide the Services, other third parties including TFS to host the Services, design and/or operate the Services’ features, track the Services’ analytics, process payments, engage in anti-fraud and security measures, provide customer support, provide geo-location information to our drivers, enable us to send you special offers, host our job application form, perform technical services (e.g., without limitation, maintenance services, database management, web analytics and improvement of the Services‘ features), or perform other administrative services. These third parties will have access to user information, including Protected Information to only carry out the services they are performing for you or for us. Each of these third parties are required to ensure the same level of data protection as us and are obligated not to disclose or use Protected Information for any other purpose. Analytics TPSPs may set and access their own cookies, web beacons and embedded scripts on your Device and they may otherwise collect or have access to information about you, including non-personally identifiable information. We use a third party hosting provider who hosts our support section of our website. Information collected within this section of our website by such third party is governed by our Privacy Policy.

(c) CO-BRANDED SERVICES

Certain aspects of the Services may be provided to you in association with third parties (“Co- Branded Services”) such as sponsors and charities, and may require you to disclose Protected Information to them. Such Co-Branded Services will identify the third party. If you elect to register for products and/or services through the Co-Branded Services, you shall have deemed to consent to providing your information to both us and the third party. Further, if you sign-in to a Co-Branded Service with a username and password obtained through our Services, your Protected Information may be disclosed to the identified third parties for that Co-Branded Service and will be subject to their posted privacy policies.

(d) CONTESTS AND PROMOTIONS

We may offer Promotions through the Services that may require registration. By participating in a Promotion, you are agreeing to official rules that govern that Promotion, which may contain specific requirements of you, including, allowing the sponsor of the Promotion to use your name, voice and/or likeness in advertising or marketing associated with the Promotion. If you choose to enter a Promotion, you agree that your Protected Information may be disclosed to third parties or the public in connection with the administration of such Promotion, including, in connection with winner selection, prize fulfillment, and as required by law or permitted by the Promotion’s official rules, such as on a winners list.

(e) ADMINISTRATIVE AND LEGAL REASONS

We cooperate with Government and law enforcement officials and private parties to enforce and comply with the law. Thus, we may access, use, preserve, transfer and disclose your information (including Protected Information, IP address, Device Information or geo-location data), to Government or law enforcement officials or private parties as we reasonably determine is necessary and appropriate:

(i) to satisfy any applicable law, regulation, subpoenas, Governmental requests or legal process;
(ii) to protect and/or defend the Terms and Conditions for online and mobile Services or other policies applicable to any online and mobile Services, including investigation of potential violations thereof;
(iii) to protect the safety, rights, property or security of the Company, our Services or any third party;
(iv) to protect the safety of the public for any reason;
(v) to detect, prevent or otherwise address fraud, security or technical issues; and /or
(vi) to prevent or stop activity we may consider to be, or to pose a risk of being, an illegal, unethical, or legally actionable activity.

(f) WHEN YOU SHARE INFORMATION

Protected Information may be collected and shared with third-parties if there is content from the Mobile Application that you specifically and knowingly upload to, share with or transmit to an email recipient, online community, website, or to the public, e.g. uploaded photos, posted reviews or comments, or information about you or your ride that you choose to share with others through features which may be provided on our Services. This uploaded, shared or transmitted content will also be subject to the privacy policy of the email, online community website, social media or other platform to which you upload, share or transmit the content.

(g) BUSINESS TRANSFER

We may share your information, including your Protected Information and Usage Information with our parent, subsidiaries and affiliates for internal reasons, including business and operational purposes. We also reserve the right to disclose and transfer all such information:

(i) to a subsequent owner, co-owner or operator of the Services or applicable database; or
(ii) in connection with a corporate merger, consolidation, restructuring, the sale of substantially all of our membership interests and/or assets or other corporate change, including, during the course of any due diligence process.

(h) MARKET STUDY AND OTHER BENEFITS

We may share your information, including your Protected Information and Usage Information with third parties for any purpose, including but not limited to undertaking market research/ study, conduct data analysis, determine and customize product or service offerings, to improve the products or Services or to make any other benefits/products/ services available to you.

(i) WITH THE OWNER OF KIDZOOONA ACCOUNTS THAT YOU MAY USE

If you use an account or profile associated with another party we may share the details of the trip with the owner of the profile. This may occur:

A. If you use your employer’s profile under a corporate arrangement;

B. If you take trip arranged by a friend.

5. THIRD PARTY CONTENT AND LINKS TO THIRD PARTY SERVICES

The Services may contain content that is supplied by a third party, and those third parties may collect website usage information and your Device Identifier when web pages from any online or mobile Services are served to your browser. In addition, when you are using the Services, you may be directed to other sites or applications that are operated and controlled by third parties that we do not control. We are not responsible for the privacy practices employed by any of these third parties. For example, if you click on a banner advertisement, the click may take you away from one of our websites onto a different web site. These other web sites may send their own cookies to you, independently collect data or solicit Protected Information and may or may not have their own published privacy policies. We encourage you to note when you leave our Services and to read the privacy statements of all third party web sites or applications before submitting any Protected Information to third parties.

6. SOCIAL MEDIA FEATURES AND WIDGETS

Our online and mobile Services may include social media features, such as the Facebook Like button, and widgets such as a “Share This” button, or interactive mini-programs that run on our online and mobile Services. These features may collect your IP address, photograph, which page you are visiting on our online or mobile Services, and may set a cookie to enable the feature to function properly. Social media features and widgets are either hosted by a third party or hosted directly on our online Services. Your interactions with these features and widgets are governed by the privacy policy of the company providing them.

7. INFORMATION COLLECTED BY DRIVERS

This Privacy Policy shall not cover the usage of any information about you which is obtained by the driver or the company to which the driver belongs, while providing you a ride on a cab booked using the Services, or otherwise, which is not provided by us.

8. CHANGE OF INFORMATION AND CANCELLATION OF ACCOUNT

(a) You are responsible for maintaining the accuracy of the information you submit to us, such as your contact information provided as part of account registration. If your Protected Information changes, or if you no longer desire our Services, you may correct, delete inaccuracies, or amend information by making the change on our member information page or by contacting us through through email address mentioned on our website or Mobile Application. We will make good faith efforts to make requested changes in our then active databases as soon as reasonably practicable.

(b) You may also cancel or modify your communications that you have elected to receive from the Services by following the instructions contained within an e-mail or by logging into your user account and changing your communication preferences.

(c) If upon modifying or changing the information earlier provided to Us, we find it difficult to permit access to our Services to you due to insufficiency/ inaccuracy of the information, we may, in our sole discretion terminate your access to the Services by providing you a written notice to this effect on your registered email id.

(d) If you wish to cancel your account or request that we no longer use your information to provide you services, contact us through through email address mentioned on the trip bill received. We will retain your Protected Information and Usage Information (including geo-location) for as long as your account with the Services is active and as needed to provide you services. Even after your account is terminated, we will retain your Protected Information and Usage Information (including geo-location, trip history, and transaction history) as needed to comply with our legal and regulatory obligations, resolve disputes, conclude any activities related to cancellation of an account, investigate or prevent fraud and other inappropriate activity, to enforce our agreements, and for other business reason. After a period of time, your data may be anonymized and aggregated, and then may be held by us as long as necessary for us to provide our Services effectively, but our use of the anonymized data will be solely for analytic purposes.

9. SECURITY

The Protected Information and Usage Information we collect is securely stored within our databases, and we use standard, industry-wide, commercially reasonable security practices such as encryption, firewalls and SSL (Secure Socket Layers) for protecting your information. However, as effective as encryption technology is, no security system is impenetrable. We cannot guarantee the security of our databases, nor can we guarantee that information you supply won't be intercepted while being transmitted to us over the Internet or wireless communication, and any information you transmit to the Company you do at your own risk. We recommend that you not disclose your password to anyone.

10. GRIEVANCE OFFICER

Kidzooona hereby appoints Kidzooona Support Manager as the grievance officer for the purposes of the rules drafted under the Information Technology Act, 2000, who may be contacted at support@kidzooona.com. You may address any grievances you may have in respect of this privacy policy or usage of your Protected Information or other data to him.

11. CHANGES TO THE PRIVACY POLICY

From time to time, we may update this Privacy Policy to reflect changes to our information practices. Any changes will be effective immediately upon the posting of the revised Privacy Policy. If we make any material changes, we will notify you by email (sent to the e-mail address specified in your account) or by means of a notice on the Services prior to the change becoming effective. We encourage you to periodically review this page for the latest information on our privacy practices.
								
								
								
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                </div>
            </div>
        </div>


    </div>

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
