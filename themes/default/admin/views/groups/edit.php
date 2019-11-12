<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .table td:first-child {
        font-weight: bold;
    }

    label {
        margin-right: 10px;
    }
</style>

<?php
//echo '<pre>';
//print_r($this->data['pages']);
//echo $edit_link;
//echo $p->{'formone'};
?>


<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= $page_title ?></h2>
    </div>
    <div class="box-content">
        <div class="row group-permission">
            <div class="col-lg-12">

                <p class="introtext"><?= lang("set_permissions"); ?></p>
                <?php //echo admin_form_open($edit_link); ?>
                <?php $attrib = array('class' => 'form-horizontal', 'class' => 'add_from','data-toggle' => 'validator', 'role' => 'form', 'autocomplete' => "off");
                //echo admin_form_open_multipart("groups/edit/".$group_id, $attrib);
                echo admin_form_open("groups/edit/".$group_id);
                ?>
                        <div class="table-responsive">

                            <table class="table table-bordered table-hover table-striped reports-table">
                                <thead>
                                <tr>
                                    <th colspan="6"
                                        class="text-center"><?php echo $group->description . ' ( ' . $group->name . ' ) ' . $page_title; ?></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center"><?= lang("module_name"); ?>
                                    </th>
                                    <th colspan="5" class="text-center"><?= lang("permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th class="text-center"><?= lang("view"); ?></th>
                                    <th class="text-center"><?= lang("add"); ?></th>
                                    <th class="text-center"><?= lang("edit"); ?></th>
                                    <th class="text-center"><?= lang("delete"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= lang("Form One"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="formone" <?php echo $p->{'formone'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="add_formone" <?php echo $p->{'add_formone'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="edit_formone" <?php echo $p->{'edit_formone'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="delete_formone" <?php echo $p->{'delete_formone'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                </tr>
                                <tr>
                                    <td><?= lang("Form Two"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="formtwo" <?php echo $p->{'formtwo'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="add_formtwo" <?php echo $p->{'add_formtwo'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="edit_formtwo" <?php echo $p->{'edit_formtwo'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="delete_formtwo" <?php echo $p->{'delete_formtwo'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                </tr>
                                <tr>
                                    <td><?= lang("Form Three"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="formthree" <?php echo $p->{'formthree'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="add_formthree" <?php echo $p->{'add_formthree'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="edit_formthree" <?php echo $p->{'edit_formthree'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="delete_formthree" <?php echo $p->{'delete_formthree'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                </tr>
                                <tr>
                                    <td><?= lang("Farmer"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="farmer" <?php echo $p->{'farmer'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="add_farmer" <?php echo $p->{'add_farmer'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="edit_farmer" <?php echo $p->{'edit_farmer'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="delete_farmer" <?php echo $p->{'delete_farmer'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                </tr>
                                <tr>
                                    <td><?= lang("Vendor"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="vendor" <?php echo $p->{'vendor'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="add_vendor" <?php echo $p->{'add_vendor'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="edit_vendor" <?php echo $p->{'edit_vendor'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="delete_vendor" <?php echo $p->{'delete_vendor'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="form-actions">
                            <?php echo form_submit('insert_permission', lang('update'), 'class="btn btn-primary"'); ?>
                        </div>
               <?php echo form_close();?>
        </div>
    </div>
</div>
<style>
    .group-permission ul{
	list-style: none;
	
    }
    .reports ul{
    -moz-column-count: 4 !important;
    -moz-column-gap: 23px;
    -webkit-column-count: 4 !important;
    -webkit-column-gap: 23px;
    column-count: 4 !important;
    column-gap: 0px;/*23px;*/
    }
    .orders-settings ul,.billing-settings ul,.group-permission ul{
    -moz-column-count: 3;
    -moz-column-gap: 23px;
    -webkit-column-count: 3;
    -webkit-column-gap: 23px;
    column-count: 3;
    column-gap: 0px;/*23px;*/
    }
    .restaurants-group-permission ul li{
	 /*-moz-column-count: 1 !important;
    -moz-column-gap: 23px;
    -webkit-column-count: 1 !important;
    -webkit-column-gap: 23px;
    column-count: 1 !important;
    column-gap: 0px;*//*23px;*/
     display: block;
    float: left;
    width:45%
    }
</style>
