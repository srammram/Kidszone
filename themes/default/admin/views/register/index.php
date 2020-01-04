
<script>
    
	
	function active_status(x) {
		
        var y = x.split("__");
		return y[1] == 1 ?
		"<a href='#' class='tip po' title='' data-content=\"<p>Are you Sure</p><a class='btn btn-danger' id='a__$1' href=' <?= admin_url('farmer/farmer_status/deactive/') ?>"+ y[0] +" '>Yes I`m Sure</a> <button class='btn po-close'>No</button>\"  rel='popover'><span class=\"label label-success\">"+lang['active']+"</span> </a>"
			:

		"<a href='#' class='tip po' title='' data-content=\"<p>Are you Sure</p><a class='btn btn-danger' id='a__$1' href=' <?= admin_url('farmer/farmer_status/active/') ?>"+ y[0] +" '>Yes I`m Sure</a> <button class='btn po-close'>No</button>\"  rel='popover'><span class=\"label label-danger\">"+lang['inactive']+"</span> </a>"		
        
    }
	
	
	function parent_type(type) {
        var type = type;

        if(type==1){
            type = 'Father Name';
        }
        else if(type==2){
            type = 'Mother Name';
        }
        else if(type==3){
            type = 'Others';
        }

        return type;
    }
	//$(document).ready(function() { $('#FlagsExport').DataTable({ "pageLength": 50, dom: 'Bfrtip',  }); });
    $(document).ready(function () {
        'use strict';
        var pendingCount = 0;
        oTable = $('#UsrTable').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('register/getRegister?sdate='.$_GET['sdate'].'&edate='.$_GET['edate']) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
              'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
				var index = oSettings._iDisplayStart+parseInt(iDisplayIndex) +parseInt(1) ;
                $("td:first", nRow).html(index);
				pendingCount = oTable.fnSettings().fnRecordsTotal();
				$('#pendingCount').text(pendingCount);

                return nRow;
            },
             "aoColumns": [ null, /*{
                "bSortable": false,
                "mRender": checkbox
            },*/ {"mRender": parent_type} , null, null, null, null, null, null, null, null, null, null, null, null, null, null, null ]
        });
    });
</script>
<style>.table td:nth-child(6) {
        text-align: right;
        width: 10%;
    }

    .table td:nth-child(8) {
        text-align: center;
    }</style>
<?php if ($Owner) {
    //echo admin_form_open('incentive/incentive_actions', 'id="action-form"');
} ?>


<?php //if ($Owner || $GP['bulk_actions'] || $GP['billers-excel']) {
    echo admin_form_open('register/register_actions', 'id="action-form"');
//} ?>

<div class="box">

<div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('Register'); ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i></a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li><a href="#" id="excel" data-action="export_excel"><i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>
                        <li><a href="javascript:void(0)" onclick="printDiv('print-content')"><i class="fa fa-file-pdf-o"></i> <?= lang('print_pdf') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">    
        <div class="row">
            <div class="col-lg-12">
			<div class="col-lg-3">
				<div class="form-group">
					<?php echo lang('Start Date', 'Start Date'); ?>
					<div class="controls">
						<input type="text" id="start_date" name="start_date" class="form-control" xonkeypress="dateCheck(this);" value="<?= $_GET['sdate'] ?>"/>
					</div>
				 </div>
			</div>
            <div class="col-lg-3">        
				<div class="form-group">
					<?php echo lang('End Date', 'End Date'); ?>
					<div class="controls">
						<input type="text" id="end_date" name="end_date" class="form-control" xonkeypress="dateCheck(this);"  value="<?= $_GET['edate'] ?>"/>
					</div>
				</div>
            </div>

            <div class="col-lg-3 row">
				<div class="form-group col-lg-7">
					<?php echo lang('&nbsp;'); ?><br>
				   <a href="javascript:void(0)" id="filte_ride" class="btn btn-primary btn-block">SEARCH</a>
				</div>
				<div class="form-group col-lg-5">            	
					<?php echo lang('&nbsp;'); ?><br>
					 <?php
					$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
					?>
				   <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0]; ?>" id="resetfilter"  class="btn btn-primary btn-block">RESET</a>
				</div>            
            </div><?php ?>

            <div class="clearfix"></div>

            <div class="clearfix"></div>
                <span style="color:red"><b>Total Count: <span id="pendingCount"></span></b></span>
            	<!--a href="<?//= admin_url('farmer/add_farmer'); ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> <?//= lang("add_farmer"); ?></button></a>-->
                
                <div class="table-responsive" id="print-content">
                    <table id="UsrTable" cellpadding="0" cellspacing="0" border="0"
                           class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        	<th class="col-xs-2"><?php echo lang('S.No'); ?></th>
                            <!--<th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>-->
                            <th class="col-xs-2"><?php echo lang('parent_type'); ?></th>
                            <th class="col-xs-2"><?php echo lang('father_name'); ?></th>
                            <th class="col-xs-2"><?php echo lang('mother_name'); ?></th>
                            <th class="col-xs-2"><?php echo lang('others_name'); ?></th>
                            <th class="col-xs-2"><?php echo lang('teacher_name'); ?></th>
                            <th class="col-xs-2"><?php echo lang('phone_number'); ?></th>
                            <th class="col-xs-2"><?php echo lang('email'); ?></th>
                            <th class="col-xs-2"><?php echo lang('kid_name1'); ?></th>
                            <th class="col-xs-2"><?php echo lang('kid_name2'); ?></th>
                            <th class="col-xs-2"><?php echo lang('kid_name3'); ?></th>
                            <th class="col-xs-2"><?php echo lang('kid_name4'); ?></th>
                            <th class="col-xs-2"><?php echo lang('kid_name5'); ?></th>
                            <th class="col-xs-2"><?php echo lang('kid_name6'); ?></th>                            
                            <th class="col-xs-2"><?php echo lang('no_of_kids'); ?></th>
                            <th class="col-xs-2"><?php echo lang('reg_date'); ?></th>
                            <th class="col-xs-2" id="action_div"><?php echo lang('actions'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                       
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

<?php //if ($Owner || $GP['bulk_actions'] || $GP['billers-excel']) { ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>
<?php //} ?>


<?php if ($Owner) { ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>

    <script language="javascript">
        $(document).ready(function () {
            $('#set_admin').click(function () {
                $('#usr-form-btn').trigger('click');
            });

        });
    </script>

<?php } ?>

<script>
$(document).ready(function(){
	var m_new = new Date();
	var month_new = m_new.getMonth() - <?= $due_month ?>;
	m_new.setMonth(month_new);
	
	var yearRangeMin =  '-<?= $due_year ?>:+0';
	var yearRangeMax =  '-0:+<?= $due_year ?>';
	
	function getDate(element) {
     var date;
     try {
       date = element.value;
     } catch (error) {
       date = null;
     }

     return date;
   }

	var dateFormat =  "dd/mm/yy";
		
	var start_date = $("#start_date") .datepicker({
       defaultDate: "+1w",
	   
	   dateFormat: "dd/mm/yy" ,
		changeMonth: true,
		changeYear: true,
		
		maxDate: 0,
		numberOfMonths: 1,
		yearRange: '-100:+0',
		
	})
	.on("change", function() {
		end_date.datepicker("option", "minDate", getDate(this));
	});
	
	var end_date = $("#end_date") .datepicker({
       defaultDate: "+1w",
	   
	   dateFormat: "dd/mm/yy" ,
		changeMonth: true,
		changeYear: true,
		
		maxDate: 0,
		numberOfMonths: 1
	})
	.on("change", function() {
		start_date.datepicker("option", "maxDate", getDate(this));
	});
	
	$('#filte_ride').click(function(e) {
        var site = '<?php echo site_url() ?>';
		var sdate = $('#start_date').val();
		var edate = $('#end_date').val();
		var is_country = $('#is_country').val();
		
		window.location.href = site+"admin/incentive/index?sdate="+sdate+"&edate="+edate+"&is_country="+is_country;
		
    });

});

</script>


<script>
    $('#filte_ride').click(function(){

        var sdate = $('#start_date').val();
        var edate = $('#end_date').val();
        var rperson = $('#rperson').val();

        //if(sdate != '' && edate != ''){
            //$('#UsrTable').DataTable().destroy();
            //fetch_data(start_date,end_date);
            window.location.href = '<?php echo 'http://'.$_SERVER['HTTP_HOST'].$uri_parts[0]; ?>?sdate='+sdate+'&edate='+edate+'&rperson='+rperson;
        //}else{
            //alert('Both Date is Required and Choose what to show!');
        //}
    });
</script>

<script>
$(function() {
    $("#start_date").datepicker({
        maxDate: new Date(),
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        //showOn: "button",        
        showAnim: "slideDown",
        dateFormat: "dd/mm/yy",
        onClose: function(selectedDate) {
            $("#end_date").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#end_date").datepicker({
        maxDate: new Date(),
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        //showOn: "button",        
        showAnim: "slideDown",
        dateFormat: "dd/mm/yy",
        onClose: function(selectedDate) {
            $("#start_date").datepicker("option", "maxDate", selectedDate);
        }
    });
});
</script>

<script type="text/javascript">
    function printDiv(divName) {

        document.getElementById('UsrTable_info').style.visibility = 'hidden';
        document.getElementById('UsrTable_length').style.visibility = 'hidden';
        document.getElementById('UsrTable_filter').style.visibility = 'hidden';
        document.getElementById('action_div').style.visibility = 'hidden';
        document.getElementsByClassName("pagination pagination-sm")[0].style.visibility = 'hidden';


        var printContents = document.getElementById(divName).innerHTML;
        w=window.open();
        w.document.write(printContents);
        w.print();
        w.close();

        document.getElementById('UsrTable_info').style.visibility = 'visible';
        document.getElementById('UsrTable_length').style.visibility = 'visible';
        document.getElementById('UsrTable_filter').style.visibility = 'visible';
        document.getElementById('action_div').style.visibility = 'visible';
        document.getElementsByClassName("pagination pagination-sm")[0].style.visibility = 'visible';
    }
</script>

