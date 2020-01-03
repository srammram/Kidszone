<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if(!isset($isMobileApp)) : ?>
<div class="clearfix"></div>
<?= '</div></div></div></td></tr></table></div></div>'; ?>
<div class="clearfix"></div>
<footer>
<a href="#" id="toTop" class="blue" style="position: fixed; bottom: 30px; right: 30px; font-size: 30px; display: none;">
    <i class="fa fa-chevron-circle-up"></i>
</a>

    <p style="text-align:center;">&copy; <?= date('Y') . " " . $Settings->site_name; ?> <?php if ($_SERVER["REMOTE_ADDR"] == '127.0.0.1') {
            echo ' - Page rendered in <strong>{elapsed_time}</strong> seconds';
        } ?></p>
</footer>
<?= '</div>'; ?>
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"></div>


<div id="modal-loading" style="display: none;">
    <div class="blackbg"></div>
    <div class="loader"></div>
</div>
<div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>
<?php unset($Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->update, $Settings->reg_ver, $Settings->allow_reg, $Settings->default_email, $Settings->mmode, $Settings->timezone, $Settings->restrict_calendar, $Settings->restrict_user, $Settings->auto_reg, $Settings->reg_notification, $Settings->protocol, $Settings->mailpath, $Settings->smtp_crypto, $Settings->corn, $Settings->customer_group, $Settings->srampos_username, $Settings->purchase_code); ?>
<script type="text/javascript">
var dt_lang = <?=$dt_lang?>, dp_lang = <?=$dp_lang?>, site = <?=json_encode(array('url' => base_url(), 'base_url' => admin_url(), 'assets' => $assets, 'settings' => $Settings, 'dateFormats' => $dateFormats))?>;
var lang = {paid: '<?=lang('paid');?>', pending: '<?=lang('pending');?>', completed: '<?=lang('completed');?>', ordered: '<?=lang('ordered');?>', received: '<?=lang('received');?>', partial: '<?=lang('partial');?>', sent: '<?=lang('sent');?>', r_u_sure: '<?=lang('r_u_sure');?>', due: '<?=lang('due');?>', returned: '<?=lang('returned');?>', transferring: '<?=lang('transferring');?>', active: '<?=lang('active');?>', inactive: '<?=lang('inactive');?>', unexpected_value: '<?=lang('unexpected_value');?>', select_above: '<?=lang('select_above');?>', download: '<?=lang('download');?>'};
</script>
<?php
$s2_lang_file = read_file('./assets/config_dumps/s2_lang.js');
foreach (lang('select2_lang') as $s2_key => $s2_line) {
    $s2_data[$s2_key] = str_replace(array('{', '}'), array('"+', '+"'), $s2_line);
}
$s2_file_date = $this->parser->parse_string($s2_lang_file, $s2_data, true);
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script type="text/javascript" src="<?= $assets ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery.dataTables.dtFilter.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/select2.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery.calculator.min.js"></script>
<!-- <script type="text/javascript" src="<?= $assets ?>js/core.js"></script> -->
<script type="text/javascript" src="<?= $assets ?>js/core.js?v=1"></script>
<script type="text/javascript" src="<?= $assets ?>js/perfect-scrollbar.min.js"></script>
<script src="<?= $assets ?>js/jquery.table2excel.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<?= ( ($m == 'products' || $m == 'recipe') && ($vv == 'add_adjustment' || $vv == 'edit_adjustment')) ? '<script type="text/javascript" src="' . $assets . 'js/adjustments.js"></script>' : ''; ?>

<script type="text/javascript" charset="UTF-8">var oTable = '', r_u_sure = "<?=lang('r_u_sure')?>";
    <?=$s2_file_date?>
    $.extend(true, $.fn.dataTable.defaults, {"oLanguage":<?=$dt_lang?>});
    $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
    $(window).load(function () {
	var seg2 = '<?=$this->uri->segment(2)?>';
        var mm = '<?=$m?>';
        var vv = '<?=$m?>_<?=$vv?>';  console.log('mm-'+mm);        
	if (seg2=="procurment") {
	    $('.mm_'+seg2).addClass('active');
            $('.mm_'+seg2).find("ul").first().slideToggle();
	    
	    $('#'+seg2+'_<?=$m?>').addClass('active');
            $('#'+seg2+'_<?=$m?>').find("ul").first().slideToggle();
	    
	    
	    $('#'+seg2+'_<?=$m?>_<?=$vv?>').addClass('active');
	    
	}
        else if (mm=='reports') {
	    $('.mm_<?=$m?>').addClass('active');
            $('.mm_<?=$m?>').find("ul").first().slideToggle();
            $('#<?=$m?>_<?=$vv?>').addClass('active');
            $('.mm_<?=$m?> a .chevron').removeClass("closed").addClass("opened");
	   
	    $('#'+vv).closest('ul.level-3-menu').slideToggle();
	 }else if(mm != 'system_settings'){   

            $('.mm_<?=$m?>').addClass('active');
            $('.mm_<?=$m?>').find("ul").first().slideToggle();
            $('#<?=$m?>_<?=$vv?>').addClass('active');
            $('.mm_<?=$m?> a .chevron').removeClass("closed").addClass("opened");
         }
         else{	    
                if(vv == 'system_settings_index')
                {                
                    $('.mm_system_settings,.mm_pos').addClass('active');
                    $('.mm_pos').find("ul").first().slideToggle();
                    $('.mm_tables').removeClass('active');
                    $('#system_settings_index').addClass('active');
                }else if(vv == 'system_settings_warehouses')
                {
                    $('.mm_tables,.mm_system_settings').addClass('active');
                    $('.mm_system_settings').find("ul").first().slideToggle();
                    $('.mm_system_settings').removeClass('active');
                    $('#system_settings_warehouses').addClass('active');
                }else{
                    $('.mm_<?=$m?>').addClass('active');
                    $('.mm_<?=$m?>').find("ul").first().slideToggle();
                    $('#<?=$m?>_<?=$vv?>').addClass('active');
                    $('.mm_<?=$m?> a .chevron').removeClass("closed").addClass("opened");
                }
         }
    });
	
	
</script>

<script>
$(".numberonly").keypress(function (event){
	
	if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
	}
  
	});

$(document).ready(function(){
    $('form').attr('autocomplete', 'off');
    $('input').attr('autocomplete', 'off');
});

</script>
<?php endif; ?>

</body>
</html>