$(document).ready(function () {
$('body a, body button').attr('tabindex', -1);
check_add_item_val();
if (site.settings.set_focus != 1) {
    $('#add_item').focus();
}
// Order level shipping and discoutn localStorage
    if (reqdiscount = localStorage.getItem('reqdiscount')) {
        $('#reqdiscount').val(reqdiscount);
    }
    $('#reqtax2').change(function (e) {
        localStorage.setItem('reqtax2', $(this).val());
        $('#reqtax2').val($(this).val());
    });
    if (reqtax2 = localStorage.getItem('reqtax2')) {
        $('#reqtax2').select2("val", reqtax2);
    }
    $('#reqstatus').change(function (e) {
        localStorage.setItem('reqstatus', $(this).val());
    });
    if (reqstatus = localStorage.getItem('reqstatus')) {
        $('#reqstatus').select2("val", reqstatus);
    }
    var old_shipping;
    $('#reqshipping').focus(function () {
        old_shipping = $(this).val();
    }).change(function () {
        if (!is_numeric($(this).val())) {
            $(this).val(old_shipping);
            bootbox.alert(lang.unexpected_value);
            return;
        } else {
            shipping = $(this).val() ? parseFloat($(this).val()) : '0';
        }
        localStorage.setItem('reqshipping', shipping);
        var gtotal = ((total + invoice_tax) - order_discount) + shipping;
        $('#gtotal').text(formatMoney(gtotal));
        $('#tship').text(formatMoney(shipping));
    });
    if (reqshipping = localStorage.getItem('reqshipping')) {
        shipping = parseFloat(reqshipping);
        $('#reqshipping').val(shipping);
    } else {
        shipping = 0;
    }

    $('#reqsupplier').change(function (e) {
        localStorage.setItem('reqsupplier', $(this).val());
        $('#supplier_id').val($(this).val());
    });
    /*if (reqsupplier = localStorage.getItem('reqsupplier')) {
        $('#reqsupplier').val(reqsupplier).select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url+"suppliers/getSupplier/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        callback(data[0]);
                    }
                });
            },
            ajax: {
                url: site.base_url + "suppliers/suggestions",
                dataType: 'json',
                reqietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });
    } else {
        nsSupplier();
    }
*/
    // If there is any item in localStorage
    if (localStorage.getItem('reqitems')) {
        loadItems();
    }

    // clear localStorage and reload
    $('#reset').click(function (e) {
            bootbox.confirm(lang.r_u_sure, function (result) {
                if (result) {
                    if (localStorage.getItem('reqitems')) {
                        localStorage.removeItem('reqitems');
                    }
                    if (localStorage.getItem('reqdiscount')) {
                        localStorage.removeItem('reqdiscount');
                    }
                    if (localStorage.getItem('reqtax2')) {
                        localStorage.removeItem('reqtax2');
                    }
                    if (localStorage.getItem('reqshipping')) {
                        localStorage.removeItem('reqshipping');
                    }
                    if (localStorage.getItem('reqref')) {
                        localStorage.removeItem('reqref');
                    }
                    if (localStorage.getItem('reqwarehouse')) {
                        localStorage.removeItem('reqwarehouse');
                    }
					if (localStorage.getItem('reqstore')) {
                        localStorage.removeItem('reqstore');
                    }
                    if (localStorage.getItem('reqnote')) {
                        localStorage.removeItem('reqnote');
                    }
                    if (localStorage.getItem('reqinnote')) {
                        localStorage.removeItem('reqinnote');
                    }
                    if (localStorage.getItem('reqcustomer')) {
                        localStorage.removeItem('reqcustomer');
                    }
                    if (localStorage.getItem('reqcurrency')) {
                        localStorage.removeItem('reqcurrency');
                    }
                    if (localStorage.getItem('reqdate')) {
                        localStorage.removeItem('reqdate');
                    }
                    if (localStorage.getItem('reqstatus')) {
                        localStorage.removeItem('reqstatus');
                    }
                    if (localStorage.getItem('reqbiller')) {
                        localStorage.removeItem('reqbiller');
                    }
		    if (localStorage.getItem('store_id_check')) {
                        localStorage.removeItem('store_id_check');
                    }
		    if (localStorage.getItem('reqsupplier')) {
                        localStorage.removeItem('reqsupplier');
                    }

                    $('#modal-loading').show();
                    location.reload();
                }
            });
    });

// save and load the fields in and/or from localStorage

    $('#reqref').change(function (e) {
        localStorage.setItem('reqref', $(this).val());
    });
    if (reqref = localStorage.getItem('reqref')) {
        $('#reqref').val(reqref);
    }
    $('#reqwarehouse').change(function (e) {
        localStorage.setItem('reqwarehouse', $(this).val());
    });
    if (reqwarehouse = localStorage.getItem('reqwarehouse')) {
        $('#reqwarehouse').select2("val", reqwarehouse);
    }
	
	$('#reqstore').change(function (e) {
        localStorage.setItem('reqstore', $(this).val());
    });
    if (reqstore = localStorage.getItem('reqstore')) {
        $('#reqstore').select2("val", reqstore);
    }

   /* $('#reqnote').redactor('destroy');
    $('#reqnote').redactor({
        buttons: ['formatting', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'bold', 'italic', 'underline', '|', 'unorderedlist', 'orderedlist', '|', 'link', '|', 'html'],
        formattingTags: ['p', 'pre', 'h3', 'h4'],
        minHeight: 100,
        changeCallback: function (e) {
            var v = this.get();
            localStorage.setItem('reqnote', v);
        }
    });*/
	$('#reqnote').change(function (e) {
        localStorage.setItem('reqnote', $(this).val());
    });
    if (reqnote = localStorage.getItem('reqnote')) {
        $('#reqnote').val(reqnote);
    }
	$('#reqcurrency').change(function (e) {
        localStorage.setItem('reqcurrency', $(this).val());
    });
    if (reqcurrency = localStorage.getItem('reqcurrency')) {
        $('#reqcurrency').select2("val", reqcurrency);
    }
	
    var $customer = $('#reqcustomer');
    $customer.change(function (e) {
        localStorage.setItem('reqcustomer', $(this).val());
    });
    if (reqcustomer = localStorage.getItem('reqcustomer')) {
        $customer.val(reqcustomer).select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url+"customers/getCustomer/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        callback(data[0]);
                    }
                });
            },
            ajax: {
                url: site.base_url + "customers/suggestions",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });
    } else {
        nsCustomer();
    }


// prevent default action upon enter
    $('body').bind('keypress', function (e) {
        if ($(e.target).hasClass('redactor_editor')) {
            return true;
        }
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

// Order tax calculation
if (site.settings.tax2 != 0) {
    $('#reqtax2').change(function () {
        localStorage.setItem('reqtax2', $(this).val());
        loadItems();
        return;
    });
}

// Order discount calculation
var old_reqdiscount;
$('#reqdiscount').focus(function () {
    old_reqdiscount = $(this).val();
}).change(function () {
    var new_discount = $(this).val() ? $(this).val() : '0';
    if (is_valid_discount(new_discount)) {
        localStorage.removeItem('reqdiscount');
        localStorage.setItem('reqdiscount', new_discount);
        loadItems();
        return;
    } else {
        $(this).val(old_reqdiscount);
        bootbox.alert(lang.unexpected_value);
        return;
    }

});

/* ----------------------
 * Delete Row Method
 * ---------------------- */
$(document).on('click', '.reqdel', function () {
    var row = $(this).closest('tr');
    var item_id = row.attr('data-item-id');
    delete reqitems[item_id];
    row.remove();
    if(reqitems.hasOwnProperty(item_id)) { } else {
        localStorage.setItem('reqitems', JSON.stringify(reqitems));
        loadItems();
        return;
    }
});

    /* -----------------------
     * Edit Row Modal Hanlder
     ----------------------- */
     $(document).on('click', '.edit', function () {
        var row = $(this).closest('tr');
        var row_id = row.attr('id');
        item_id = row.attr('data-item-id');
        item = reqitems[item_id];
        var qty = row.children().children('.rquantity').val(),
        product_option = row.children().children('.roption').val(),
        unit_price = formatDecimal(row.children().children('.ruprice').val()),
        discount = row.children().children('.rdiscount').val();
        if(item.options !== false) {
            $.each(item.options, function () {
                if(this.id == item.row.option && this.price != 0 && this.price != '' && this.price != null) {
                    unit_price = parseFloat(item.row.real_unit_price)+parseFloat(this.price);
                }
            });
        }
        var real_unit_price = item.row.real_unit_price;
        var net_price = unit_price;
        $('#prModalLabel').text(item.row.name + ' (' + item.row.code + ')');
        if (site.settings.tax1) {
            $('#ptax').select2('val', item.row.tax_rate);
            $('#old_tax').val(item.row.tax_rate);
            var item_discount = 0, ds = discount ? discount : '0';
            if (ds.indexOf("%") !== -1) {
                var pds = ds.split("%");
                if (!isNaN(pds[0])) {
                    item_discount = formatDecimal(parseFloat(((unit_price) * parseFloat(pds[0])) / 100), 4);
                } else {
                    item_discount = parseFloat(ds);
                }
            } else {
                item_discount = parseFloat(ds);
            }
            net_price -= item_discount;
            var pr_tax = item.row.tax_rate, pr_tax_val = 0;
            if (pr_tax !== null && pr_tax != 0) {
                $.each(tax_rates, function () {
                    if(this.id == pr_tax){
                        if (this.type == 1) {

                            if (reqitems[item_id].row.tax_method == 0) {
                                pr_tax_val = formatDecimal((((net_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate))), 4);
                                pr_tax_rate = formatDecimal(this.rate) + '%';
                                net_price -= pr_tax_val;
                            } else {
                                pr_tax_val = formatDecimal((((net_price) * parseFloat(this.rate)) / 100), 4);
                                pr_tax_rate = formatDecimal(this.rate) + '%';
                            }

                        } else if (this.type == 2) {

                            pr_tax_val = parseFloat(this.rate);
                            pr_tax_rate = this.rate;

                        }
                    }
                });
            }
        }
        if (site.settings.product_serial !== 0) {
            $('#pserial').val(row.children().children('.rserial').val());
        }
        var opt = '<p style="margin: 12px 0 0 0;">n/a</p>';
        if(item.options !== false) {
            var o = 1;
            opt = $("<select id=\"poption\" name=\"poption\" class=\"form-control select\" />");
            $.each(item.options, function () {
                if(o == 1) {
                    if(product_option == '') { product_variant = this.id; } else { product_variant = product_option; }
                }
                $("<option />", {value: this.id, text: this.name}).appendTo(opt);
                o++;
            });
        } else {
            product_variant = 0;
        }

        uopt = '<p style="margin: 12px 0 0 0;">n/a</p>';
        if (item.units) {
            uopt = $("<select id=\"punit\" name=\"punit\" class=\"form-control select\" />");
            $.each(item.units, function () {
                if(this.id == item.row.unit) {
                    $("<option />", {value: this.id, text: this.name, selected:true}).appendTo(uopt);
                } else {
                    $("<option />", {value: this.id, text: this.name}).appendTo(uopt);
                }
            });
        }

        $('#poptions-div').html(opt);
        $('#punits-div').html(uopt);
        $('select.select').select2({minimumResultsForSearch: 7});
        $('#pquantity').val(qty);
        $('#old_qty').val(qty);
        $('#pprice').val(unit_price);
        $('#punit_price').val(formatDecimal(parseFloat(unit_price)+parseFloat(pr_tax_val)));
        $('#poption').select2('val', item.row.option);
        $('#old_price').val(unit_price);
        $('#row_id').val(row_id);
        $('#item_id').val(item_id);
        $('#pserial').val(row.children().children('.rserial').val());
        $('#pdiscount').val(discount);
        $('#net_price').text(formatMoney(net_price-item_discount));
        $('#pro_tax').text(formatMoney(pr_tax_val));
        $('#prModal').appendTo("body").modal('show');

    });

    $('#prModal').on('shown.bs.modal', function (e) {
        if($('#poption').select2('val') != '') {
            $('#poption').select2('val', product_variant);
            product_variant = 0;
        }
    });

    $(document).on('change', '#pprice, #ptax, #pdiscount', function () {
        var row = $('#' + $('#row_id').val());
        var item_id = row.attr('data-item-id');
        var unit_price = parseFloat($('#pprice').val());
        var item = reqitems[item_id];
        var ds = $('#pdiscount').val() ? $('#pdiscount').val() : '0';
        if (ds.indexOf("%") !== -1) {
            var pds = ds.split("%");
            if (!isNaN(pds[0])) {
                item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
            } else {
                item_discount = parseFloat(ds);
            }
        } else {
            item_discount = parseFloat(ds);
        }
        unit_price -= item_discount;
        var pr_tax = $('#ptax').val(), item_tax_method = item.row.tax_method;
        var pr_tax_val = 0, pr_tax_rate = 0;
        if (pr_tax !== null && pr_tax != 0) {
            $.each(tax_rates, function () {
                if(this.id == pr_tax){
                    if (this.type == 1) {

                        if (item_tax_method == 0) {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate)), 4);
                            pr_tax_rate = formatDecimal(this.rate) + '%';
                            unit_price -= pr_tax_val;
                        } else {
                            pr_tax_val = formatDecimal((((unit_price) * parseFloat(this.rate)) / 100), 4);
                            pr_tax_rate = formatDecimal(this.rate) + '%';
                        }

                    } else if (this.type == 2) {

                        pr_tax_val = parseFloat(this.rate);
                        pr_tax_rate = this.rate;

                    }
                }
            });
        }

        $('#net_price').text(formatMoney(unit_price));
        $('#pro_tax').text(formatMoney(pr_tax_val));
    });

    $(document).on('change', '#punit', function () {
        var row = $('#' + $('#row_id').val());
        var item_id = row.attr('data-item-id');
        var item = reqitems[item_id];
        if (!is_numeric($('#pquantity').val()) || parseFloat($('#pquantity').val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var opt = $('#poption').val(), unit = $('#punit').val(), base_quantity = $('#pquantity').val(), aprice = 0;
        if(item.options !== false) {
            $.each(item.options, function () {
                if(this.id == opt && this.price != 0 && this.price != '' && this.price != null) {
                    aprice = parseFloat(this.price);
                }
            });
        }
        if(item.units && unit != reqitems[item_id].row.base_unit) {
            $.each(item.units, function(){
                if (this.id == unit) {
                    base_quantity = unitToBaseQty($('#pquantity').val(), this);
                    $('#pprice').val(formatDecimal(((parseFloat(item.row.base_unit_price+aprice))*unitToBaseQty(1, this)), 4)).change();
                }
            });
        } else {
            $('#pprice').val(formatDecimal(item.row.base_unit_price+aprice)).change();
        }
    });

    /* -----------------------
     * Edit Row Method
     ----------------------- */
     $(document).on('click', '#editItem', function () {
        var row = $('#' + $('#row_id').val());
        var item_id = row.attr('data-item-id'), new_pr_tax = $('#ptax').val(), new_pr_tax_rate = false;
        if (new_pr_tax) {
            $.each(tax_rates, function () {
                if (this.id == new_pr_tax) {
                    new_pr_tax_rate = this;
                }
            });
        }
        var price = parseFloat($('#pprice').val());
        if(item.options !== false) {
            var opt = $('#poption').val();
            $.each(item.options, function () {
                if(this.id == opt && this.price != 0 && this.price != '' && this.price != null) {
                    price = price-parseFloat(this.price);
                }
            });
        }
        if (site.settings.product_discount == 1 && $('#pdiscount').val()) {
            if(!is_valid_discount($('#pdiscount').val()) || $('#pdiscount').val() > price) {
                bootbox.alert(lang.unexpected_value);
                return false;
            }
        }
        if (!is_numeric($('#pquantity').val()) || parseFloat($('#pquantity').val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var unit = $('#punit').val();
        var base_quantity = parseFloat($('#pquantity').val());
        if(unit != reqitems[item_id].row.base_unit) {
            $.each(reqitems[item_id].units, function(){
                if (this.id == unit) {
                    base_quantity = unitToBaseQty($('#pquantity').val(), this);
                }
            });
        }

        reqitems[item_id].row.fup = 1,
        reqitems[item_id].row.qty = parseFloat($('#pquantity').val()),
        reqitems[item_id].row.base_quantity = parseFloat(base_quantity),
        reqitems[item_id].row.real_unit_price = price,
        reqitems[item_id].row.unit = unit,
        reqitems[item_id].row.tax_rate = new_pr_tax,
        reqitems[item_id].tax_rate = new_pr_tax_rate,
        reqitems[item_id].row.discount = $('#pdiscount').val() ? $('#pdiscount').val() : '',
        reqitems[item_id].row.option = $('#poption').val() ? $('#poption').val() : '',
        reqitems[item_id].row.serial = $('#pserial').val();
        localStorage.setItem('reqitems', JSON.stringify(reqitems));
        $('#prModal').modal('hide');

        loadItems();
        return;
    });

    /* -----------------------
     * Product option change
     ----------------------- */
     $(document).on('change', '#poption', function () {
        var row = $('#' + $('#row_id').val()), opt = $(this).val();
        var item_id = row.attr('data-item-id');
        var item = reqitems[item_id];
        var unit = $('#punit').val(), base_quantity = parseFloat($('#pquantity').val()), base_unit_price = item.row.base_unit_price;
        if(unit != reqitems[item_id].row.base_unit) {
            $.each(reqitems[item_id].units, function(){
                if (this.id == unit) {
                    base_unit_price = formatDecimal((parseFloat(item.row.base_unit_price)*(unitToBaseQty(1, this))), 4)
                    base_quantity = unitToBaseQty($('#pquantity').val(), this);
                }
            });
        }
        if(item.options !== false) {
            $.each(item.options, function () {
                if(this.id == opt && this.price != 0 && this.price != '' && this.price != null) {
                    $('#pprice').val(parseFloat(base_unit_price)+(parseFloat(this.price))).trigger('change');
                }
            });
        }
    });

    /* ------------------------------
     * Show manual item addition modal
     ------------------------------- */
     $(document).on('click', '#addManually', function (e) {
        if (count == 1) {
            reqitems = {};
            if ($('#reqwarehouse').val()) {
                $('#reqcustomer').select2("readonly", true);
                $('#reqwarehouse').select2("readonly", true);
				$('#reqstore').select2("readonly", true);
            } else {
                bootbox.alert(lang.select_above);
                item = null;
                return false;
            }
        }
        $('#mnet_price').text('0.00');
        $('#mpro_tax').text('0.00');
        $('#mModal').appendTo("body").modal('show');
        return false;
    });

     $(document).on('click', '#addItemManually', function (e) {
        var mid = (new Date).getTime(),
        mcode = $('#mcode').val(),
        mname = $('#mname').val(),
        mtax = parseInt($('#mtax').val()),
        mqty = parseFloat($('#mquantity').val()),
        mdiscount = $('#mdiscount').val() ? $('#mdiscount').val() : '0',
        unit_price = parseFloat($('#mprice').val()),
        mtax_rate = {};
        if (mcode && mname && mqty && unit_price) {
            $.each(tax_rates, function () {
                if (this.id == mtax) {
                    mtax_rate = this;
                }
            });

            reqitems[mid] = {"id": mid, "item_id": mid, "label": mname + ' (' + mcode + ')', "row": {"id": mid, "code": mcode, "name": mname, "quantity": mqty, "price": unit_price, "unit_price": unit_price, "real_unit_price": unit_price, "tax_rate": mtax, "tax_method": 0, "qty": mqty, "type": "manual", "discount": mdiscount, "serial": "", "option":""}, "tax_rate": mtax_rate, "options":false};
            localStorage.setItem('reqitems', JSON.stringify(reqitems));
            loadItems();
        }
        $('#mModal').modal('hide');
        $('#mcode').val('');
        $('#mname').val('');
        $('#mtax').val('');
        $('#mquantity').val('');
        $('#mdiscount').val('');
        $('#mprice').val('');
        return false;
    });

    $(document).on('change', '#mprice, #mtax, #mdiscount', function () {
        var unit_price = parseFloat($('#mprice').val());
        var ds = $('#mdiscount').val() ? $('#mdiscount').val() : '0';
        if (ds.indexOf("%") !== -1) {
            var pds = ds.split("%");
            if (!isNaN(pds[0])) {
                item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
            } else {
                item_discount = parseFloat(ds);
            }
        } else {
            item_discount = parseFloat(ds);
        }
        unit_price -= item_discount;
        var pr_tax = $('#mtax').val(), item_tax_method = 0;
        var pr_tax_val = 0, pr_tax_rate = 0;
        if (pr_tax !== null && pr_tax != 0) {
            $.each(tax_rates, function () {
                if(this.id == pr_tax){
                    if (this.type == 1) {

                        if (item_tax_method == 0) {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate)));
                            pr_tax_rate = formatDecimal(this.rate) + '%';
                            unit_price -= pr_tax_val;
                        } else {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / 100);
                            pr_tax_rate = formatDecimal(this.rate) + '%';
                        }

                    } else if (this.type == 2) {

                        pr_tax_val = parseFloat(this.rate);
                        pr_tax_rate = this.rate;

                    }
                }
            });
        }

        $('#mnet_price').text(formatMoney(unit_price));
        $('#mpro_tax').text(formatMoney(pr_tax_val));
    });
	
	
	$(document).on("change", '.rcost_price', function () {
		var row = $(this).closest('tr');
		var cost_price = parseFloat($(this).val());
		var item_id = row.attr('data-item-id');
		reqitems[item_id].row.cost_price = cost_price;
		localStorage.setItem('reqitems', JSON.stringify(reqitems));
        loadItems();
	});
	
	$(document).on("change", '.rselling_price', function () {
		var row = $(this).closest('tr');
		var selling_price = parseFloat($(this).val());
		var item_id = row.attr('data-item-id');
		reqitems[item_id].row.selling_price = selling_price;
		localStorage.setItem('reqitems', JSON.stringify(reqitems));
        loadItems();
	});
    /* --------------------------
     * Edit Row quantity Method
     -------------------------- */
     var old_row_qty;
     $(document).on("focus", '.rquantity', function () {
        old_row_qty = $(this).val();
    }).on("change", '.rquantity', function () {
       /* var row = $(this).closest('tr');
        if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var new_qty = parseFloat($(this).val()),
        item_id = row.attr('data-item-id');
        reqitems[item_id].row.base_quantity = new_qty;
        if(reqitems[item_id].row.unit != reqitems[item_id].row.base_unit) {
            $.each(reqitems[item_id].units, function(){
                if (this.id == reqitems[item_id].row.unit) {
                    reqitems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                }
            });
        }
        reqitems[item_id].row.qty = new_qty;
        localStorage.setItem('reqitems', JSON.stringify(reqitems));
        loadItems();*/
		var row = $(this).closest('tr');
        if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var new_qty = parseFloat($(this).val()),
		
        item_id = row.attr('data-item-id');
		//alert(row);
		//alert(new_qty);
        reqitems[item_id].row.base_quantity = new_qty;
        if(reqitems[item_id].row.unit != reqitems[item_id].row.base_unit) {
            $.each(reqitems[item_id].units, function(){
                if (this.id == reqitems[item_id].row.unit) {
                    reqitems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                }
            });
        }
        reqitems[item_id].row.qty = new_qty;
        reqitems[item_id].row.received = new_qty;
        localStorage.setItem('reqitems', JSON.stringify(reqitems));
        loadItems();
    });

    /* --------------------------
     * Edit Row Price Method
     -------------------------- */
    var old_price;
    $(document).on("focus", '.rprice', function () {
        old_price = $(this).val();
    }).on("change", '.rprice', function () {
        var row = $(this).closest('tr');
        if (!is_numeric($(this).val())) {
            $(this).val(old_price);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var new_price = parseFloat($(this).val()),
                item_id = row.attr('data-item-id');
        reqitems[item_id].row.price = new_price;
        localStorage.setItem('reqitems', JSON.stringify(reqitems));
        loadItems();
    });

    $(document).on("click", '#removeReadonly', function () {
       $('#reqcustomer').select2('readonly', false);
       //$('#reqwarehouse').select2('readonly', false);
       return false;
    });


   $('#add-quotation-request input[type="submit"]').click(function(e){
   
    $error = false;
    $('#s2id_reqsupplier').removeClass('procurment-input-error');  
    if($('#reqTable tbody tr').length==0){
        
        bootbox.alert('Add Any one Purchase Items');
        return false;
    }
    else if ($('#reqsupplier').val()=='') {
        
        $error = true;
        $('#s2id_reqsupplier').addClass('procurment-input-error');       
    }else{    
        
        $('.required').each(function(){
            $(this).removeClass('procurment-input-error');
            console.log($(this).val())
            if($(this).val()==''){
            $error=true;
            $(this).addClass('procurment-input-error');
            }        
        });
	$(".rquantity").each(function(n,v){
	    if($(this).val()=='' || $(this).val()==0){
		$error=true;
		$(this).addClass('procurment-input-error');
	    }
	});
    }
    // alert($error);
    if ($error) {      
        e.preventDefault();
        $("html, body").animate({ scrollTop: $('#reqTable').offset().top }, 1000);
        return false;   
    }else{
        $(this).text('Loading').attr('disabled', true);
        $('#add-quotation-request').submit();
        return false; 
    }
   });

});
/* -----------------------
 * Misc Actions
 ----------------------- */

// hellper function for customer if no localStorage value
function nsCustomer() {
    $('#reqcustomer').select2({
        minimumInputLength: 1,
        ajax: {
            url: site.base_url + "customers/suggestions",
            dataType: 'json',
            quietMillis: 15,
            data: function (term, page) {
                return {
                    term: term,
                    limit: 10
                };
            },
            results: function (data, page) {
                if (data.results != null) {
                    return {results: data.results};
                } else {
                    return {results: [{id: '', text: 'No Match Found'}]};
                }
            }
        }
    });
}

function nsSupplier() {
    $('#reqsupplier').select2({
        minimumInputLength: 1,
        ajax: {
            url: site.base_url + "suppliers/suggestions",
            dataType: 'json',
            quietMillis: 15,
            data: function (term, page) {
                return {
                    term: term,
                    limit: 10
                };
            },
            results: function (data, page) {
                if (data.results != null) {
                    return {results: data.results};
                } else {
                    return {results: [{id: '', text: 'No Match Found'}]};
                }
            }
        }
    });
}

//localStorage.clear();
function loadItems() {

    if (localStorage.getItem('reqitems')) {
        total = 0;
        count = 1;
        an = 1;
        product_tax = 0;
        invoice_tax = 0;
        product_discount = 0;
        order_discount = 0;
        total_discount = 0;

        $("#reqTable tbody").empty();
        reqitems = JSON.parse(localStorage.getItem('reqitems'));		
        sortedItems =  reqitems;
		
        $('#add_sale, #edit_sale').attr('disabled', false);
		var c = 1;
        $.each(sortedItems, function () {
			
            var item = this;
			
            // var item_id = site.settings.item_addition == 1 ? item.item_id : item.item_id;
            var item_id = item.item_id;
            
            // item.order = item.order ? item.order : new Date().getTime();

            var product_id = item.row.id, item_type = item.row.type, combo_items = item.combo_items, item_price = item.row.price, item_qty = item.row.qty, item_aqty = item.row.quantity, item_tax_method = item.row.tax_method, item_ds = item.row.discount, item_discount = 0, item_option = item.row.option, item_code = item.row.code, item_serial = item.row.serial, item_name = item.row.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;"),variant_name = item.row.variant_name.replace(/"/g, "&#034;").replace(/'/g, "&#039;"),variant_id = item.row.variant_id;
	    var category_id = item.row.category_id,
		category_name = item.row.category_name,
		subcategory_id = item.row.subcategory_id,
		subcategory_name = item.row.subcategory_name,
		brand_id = item.row.brand_id,
		brand_name = item.row.brand_name;
            var unit_price = item.row.real_unit_price;
			
			var cost_price = item.row.purchase_cost ? item.row.purchase_cost : 0;
			var selling_price = item.row.cost ? item.row.cost : 0;
			
            var product_unit = item.row.unit, base_quantity = item.row.base_quantity;
            if(item.units && item.row.fup != 1 && product_unit != item.row.base_unit) {
                $.each(item.units, function(){
                    if (this.id == product_unit) {
                        base_quantity = formatDecimal(unitToBaseQty(item.row.qty, this), 4);
                        unit_price = formatDecimal((parseFloat(item.row.base_unit_price)*(unitToBaseQty(1, this))), 4);
                    }
                });
            }
            if(item.options !== false) {
                $.each(item.options, function () {
                    if(this.id == item.row.option && this.price != 0 && this.price != '' && this.price != null) {
                        item_price = unit_price+(parseFloat(this.price));
                        unit_price = item_price;
                    }
                });
            }

            var ds = item_ds ? item_ds : '0';
            if (ds.indexOf("%") !== -1) {
                var pds = ds.split("%");
                if (!isNaN(pds[0])) {
                    item_discount = formatDecimal((((unit_price) * parseFloat(pds[0])) / 100), 4);
                } else {
                    item_discount = formatDecimal(ds);
                }
            } else {
                 item_discount = formatDecimal(ds);
            }
            product_discount += parseFloat(item_discount * item_qty);

            unit_price = formatDecimal(unit_price-item_discount);
            var pr_tax = item.tax_rate;
            var pr_tax_val = 0, pr_tax_rate = 0;
            /*if (site.settings.tax1 == 1) {
                if (pr_tax !== false) {
                    if (pr_tax.type == 1) {

                        if (item_tax_method == '0') {
                            pr_tax_val = formatDecimal((((unit_price) * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate))), 4);
                            pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                        } else {
                            pr_tax_val = formatDecimal((((unit_price) * parseFloat(pr_tax.rate)) / 100), 4);
                            pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                        }

                    } else if (pr_tax.type == 2) {

                        pr_tax_val = parseFloat(pr_tax.rate);
                        pr_tax_rate = pr_tax.rate;

                    }
                    product_tax += pr_tax_val * item_qty;
                }
            }*/
            item_price = item_tax_method == 0 ? formatDecimal(unit_price-pr_tax_val, 4) : formatDecimal(unit_price);
            unit_price = formatDecimal(unit_price+item_discount, 4);
            var sel_opt = '';
            $.each(item.options, function () {
                if(this.id == item_option) {
                    sel_opt = this.name;
                }
            });
            var row_no = (new Date).getTime();
	    $store_id= default_store;
            if (item.store_id) {
                $store_id = item.store_id;
            }
            var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id+'_'+$store_id+'_'+item.row.category_id+'_'+item.row.subcategory_id+'_'+item.row.brand_id + '"></tr>');
			
			
			
			tr_html = '<td><span class="sno" id="no_' + row_no + '">' + c  +'</span></td>';
			c++;
			
			tr_html += '<td><span class="scode" id="code_' + row_no + '">' + item_code +'</span></td>';
            $variant_name ='';            
			if(variant_name !=''){
                $variant_name = ' ['+variant_name+']';
            }
            tr_html += '<td><input name="store_id[]" type="hidden" class="store-id" value="' + $store_id + '"><input name="product_id[]" type="hidden" class="rid" value="' + product_id + '"><input name="variant_id[]" type="hidden" class="variant_id" value="' + variant_id + '"><input name="product_type[]" type="hidden" class="rtype" value="' + item_type + '"><input name="product_code[]" type="hidden" class="rcode" value="' + item_code + '"><input name="product_name[]" type="hidden" class="rname" value="' + item_name + '"><input name="product_option[]" type="hidden" class="roption" value="' + item_option + '"><span class="sname" id="name_' + row_no + '">' + item_name+$variant_name +'</span> </td>';
			
	    if (category_name==null) {category_name ='';}if (category_id==null) {category_id =0;}
	    tr_html +='<td>'+
		     '<input name="category_id[]" type="hidden" class="cid" value="' + category_id + '">'+
		     '<input name="category_name[]" type="hidden" class="cname" readonly value="' + category_name + '">'+
		     '<span class="sname" id="name_' + row_no + '">' + category_name +'</span>'+
		     '</td>';
		     if (subcategory_name==null) {subcategory_name ='';}if (subcategory_id==null) {subcategory_id =0;}
	    tr_html +='<td>'+
		     '<input name="subcategory_id[]" type="hidden" class="scid" value="' + subcategory_id + '">'+
		     '<input name="subcategory_name[]" type="hidden" class="scname" readonly value="' + subcategory_name + '">'+
		     '<span class="sname" id="name_' + row_no + '">' + subcategory_name +'</span>'+
		     '</td>';
		    if (brand_name==null) {brand_name ='';}if (brand_id==null) {brand_id =0;}
	    tr_html +='<td>'+
		     '<input name="brand_id[]" type="hidden" class="bid" value="' + brand_id + '">'+
		     '<input name="brand_name[]" type="hidden" class="bname" readonly value="' + brand_name + '">'+
		     '<span class="sname" id="name_' + row_no + '">' + brand_name +'</span>'+
		     '</td>';
		     
		     
            tr_html += '<input class="form-control input-sm text-right rprice" name="net_price[]" type="hidden" id="price_' + row_no + '" value="' + formatDecimal(item_price) + '"><input class="ruprice" name="unit_price[]" type="hidden" value="' + unit_price + '"><input class="realuprice" name="real_unit_price[]" type="hidden" value="' + item.row.real_unit_price + '">';
            tr_html += '<td><input class="form-control text-right rquantity" tabindex="'+((site.settings.set_focus == 1) ? an : (an+1))+'" name="quantity[]" type="text" value="' + formatDecimals(item_qty) + '" data-id="' + row_no + '" data-item="' + item_id + '" id="quantity_' + row_no + '" onClick="this.select();"><input name="product_unit[]" type="hidden" class="runit" value="' + product_unit + '"><input name="product_base_quantity[]" type="hidden" class="rbase_quantity" value="' + base_quantity + '"></td>';
            /*if ((site.settings.product_discount == 1 && allow_discount == 1) || item_discount) {
                tr_html += '<td class="text-right"><input class="form-control input-sm rdiscount" name="product_discount[]" type="hidden" id="discount_' + row_no + '" value="' + item_ds + '"><span class="text-right sdiscount text-danger" id="sdiscount_' + row_no + '">' + formatMoney(0 - (item_discount * item_qty)) + '</span></td>';
            }*/
            /*if (site.settings.tax1 == 1) {
                tr_html += '<td class="text-right"><input class="form-control input-sm text-right rproduct_tax" name="product_tax[]" type="hidden" id="product_tax_' + row_no + '" value="' + pr_tax.id + '"><span class="text-right sproduct_tax" id="sproduct_tax_' + row_no + '">' + (pr_tax_rate ? '(' + formatDecimal(pr_tax_rate) + ')' : '') + ' ' + formatMoney(pr_tax_val * item_qty) + '</span></td>';
            }*/
			
          
			
		
			
            tr_html += '<td class="text-center"><i class="fa fa-trash-o tip pointer reqdel" id="' + row_no + '" title="Remove" style="cursor:pointer; color:red;"></i></td>';
            newTr.html(tr_html);
            newTr.appendTo("#reqTable");
            total += formatDecimal(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)), 4);
            count += parseFloat(item_qty);
            an++;
            if (item_type == 'standard' && item.options !== false) {
                $.each(item.options, function () {
                    if(this.id == item_option && base_quantity > this.quantity) {
                        $('#row_' + row_no).addClass('danger');
                        if(site.settings.overselling != 1) { $('#add_sale, #edit_sale').attr('disabled', true); }
                    }
                });
            } else if(item_type == 'standard' && base_quantity > item_aqty) {
                $('#row_' + row_no).addClass('danger');
            } else if (item_type == 'combo') {
                if(combo_items === false) {
                    $('#row_' + row_no).addClass('danger');
                } else {
                    $.each(combo_items, function() {
                       if(parseFloat(this.quantity) < (parseFloat(this.qty)*base_quantity) && this.type == 'standard') {
                           $('#row_' + row_no).addClass('danger');
                       }
                   });
                }
            }
			
			

        });
		

        var col = 2;
		var tfoot = '';
         //tfoot +=  '<tr id="tfoot" class="tfoot active"><th colspan="'+col+'">Total</th><th class="text-center">' + formatQty(parseFloat(count) - 1) + '</th>';
        /*if ((site.settings.product_discount == 1 && allow_discount == 1) || product_discount) {
            tfoot += '<th class="text-right">'+formatMoney(product_discount)+'</th>';
        }*/
        /*if (site.settings.tax1 == 1) {
            tfoot += '<th class="text-right">'+formatMoney(product_tax)+'</th>';
        }*/
       // tfoot += '<th class="text-right">'+formatMoney(total)+'</th><th class="text-center"><i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i></th></tr>';
        $('#reqTable tfoot').html(tfoot);

        // Order level discount calculations
        if (reqdiscount = localStorage.getItem('reqdiscount')) {
            var ds = reqdiscount;
            if (ds.indexOf("%") !== -1) {
                var pds = ds.split("%");
                if (!isNaN(pds[0])) {
                    order_discount = formatDecimal((((total) * parseFloat(pds[0])) / 100), 4);
                } else {
                    order_discount = formatDecimal(ds);
                }
            } else {
                order_discount = formatDecimal(ds);
            }
        }

        // Order level tax calculations
        /*if (site.settings.tax2 != 0) {
            if (reqtax2 = localStorage.getItem('reqtax2')) {
                $.each(tax_rates, function () {
                    if (this.id == reqtax2) {
                        if (this.type == 2) {
                            invoice_tax = formatDecimal(this.rate);
                        }
                        if (this.type == 1) {
                            invoice_tax = formatDecimal((((total - order_discount) * this.rate) / 100), 4);
                        }
                    }
                });
            }
        }*/
        total_discount = parseFloat(order_discount + product_discount);
        // Totals calculations after item addition
        var gtotal = parseFloat(((total + invoice_tax) - order_discount) + shipping);
        $('#total').text(formatMoney(total));
        $('#titems').text((an - 1) + ' (' + formatQty(parseFloat(count) - 1) + ')');
        $('#total_items').val(formatDecimals((parseFloat(count) - 1)));
        $('#tds').text(formatMoney(order_discount));
        if (site.settings.tax2 != 0) {
            $('#ttax2').text(formatMoney(invoice_tax));
        }
        $('#tship').text(formatMoney(shipping));
        $('#gtotal').text(formatMoney(gtotal));
        if (an > parseInt(site.settings.bc_fix) && parseInt(site.settings.bc_fix) > 0) {
            $("html, body").animate({scrollTop: $('#sticker').offset().top}, 500);
            $(window).scrollTop($(window).scrollTop() + 1);
        }
        set_page_focus();
    }
}

/* -----------------------------
 * Add reqotation Item Function
 * @param {json} item
 * @returns {Boolean}
 ---------------------------- */
 function add_invoice_item(item) {

    if (count == 1) {
        reqitems = {};
        if ($('#reqwarehouse').val()) {
            $('#reqcustomer').select2("readonly", true);
            $('#reqwarehouse').select2("readonly", true);
			$('#reqstore').select2("readonly", true);
        } else {
            bootbox.alert(lang.select_above);
            item = null;
            return;
        }
    }
    if (item == null)
        return;

   // var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
	
	var item_id = item.item_id+'_'+default_store+'_'+item.row.category_id+'_'+item.row.subcategory_id+'_'+item.row.brand_id;
	
    if (reqitems[item_id]) {

        var new_qty = parseFloat(reqitems[item_id].row.qty) + 1;
        reqitems[item_id].row.base_quantity = new_qty;
        if(reqitems[item_id].row.unit != reqitems[item_id].row.base_unit) {
            $.each(reqitems[item_id].units, function(){
                if (this.id == reqitems[item_id].row.unit) {
                    reqitems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                }
            });
        }
        reqitems[item_id].row.qty = new_qty;

    } else {
        reqitems[item_id] = item;
    }
    reqitems[item_id].order = new Date().getTime();
    localStorage.setItem('reqitems', JSON.stringify(reqitems));
    loadItems();
    return true;
	
	
}

if (typeof (Storage) === "undefined") {
    $(window).bind('beforeunload', function (e) {
        if (count > 1) {
            var message = "You will loss data!";
            return message;
        }
    });
}
