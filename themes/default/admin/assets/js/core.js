$(window).load(function () {
    $("#loading").fadeOut("slow");
});
function cssStyle() {
    if ($.cookie('sma_style') == 'light') {
        $('link[href="'+site.assets+'styles/blue.css"]').attr('disabled', 'disabled');
        $('link[href="'+site.assets+'styles/blue.css"]').remove();
		
		$('link[href="'+site.assets+'styles/dark_blue.css"]').attr('disabled', 'disabled');
        $('link[href="'+site.assets+'styles/dark_blue.css"]').remove();
        $('<link>')
        .appendTo('head')
        .attr({type: 'text/css', rel: 'stylesheet'})
        .attr('href', site.assets+'styles/light.css');
    }
    else if ($.cookie('sma_style') == 'blue') {
        $('link[href="'+site.assets+'styles/light.css"]').attr('disabled', 'disabled');
        $('link[href="'+site.assets+'styles/light.css"]').remove();
		
		$('link[href="'+site.assets+'styles/dark_blue.css"]').attr('disabled', 'disabled');
        $('link[href="'+site.assets+'styles/dark_blue.css"]').remove();
        $('<link>')
        .appendTo('head')
        .attr({type: 'text/css', rel: 'stylesheet'})
        .attr('href', ''+site.assets+'styles/blue.css');
    }
	
	 else if ($.cookie('sma_style') == 'dark_blue') {
         $('link[href="'+site.assets+'styles/light.css"]').attr('disabled', 'disabled');
        $('link[href="'+site.assets+'styles/light.css"]').remove();
		
		$('link[href="'+site.assets+'styles/blue.css"]').attr('disabled', 'disabled');
        $('link[href="'+site.assets+'styles/blue.css"]').remove();
        $('<link>')
        .appendTo('head')
        .attr({type: 'text/css', rel: 'stylesheet'})
        .attr('href', ''+site.assets+'styles/dark_blue.css');
    }
	
    else {
        $('link[href="'+site.assets+'styles/light.css"]').attr('disabled', 'disabled');
        $('link[href="'+site.assets+'styles/blue.css"]').attr('disabled', 'disabled');
		$('link[href="'+site.assets+'styles/dark_blue.css"]').attr('disabled', 'disabled');
        $('link[href="'+site.assets+'styles/light.css"]').remove();
        $('link[href="'+site.assets+'styles/blue.css"]').remove();
		$('link[href="'+site.assets+'styles/dark_blue.css"]').remove();
    }

    if($('#sidebar-left').hasClass('minified')) {
        $.cookie('sma_theme_fixed', 'no', { path: '/' });
        $('#content, #sidebar-left, #header').removeAttr("style");
        $('#sidebar-left').removeClass('sidebar-fixed');
        $('#content').removeClass('content-with-fixed');
        $('#fixedText').text('Fixed');
        $('#main-menu-act').addClass('full visible-md visible-lg').show();
        $('#fixed').removeClass('fixed');
    } else {
        if(site.settings.rtl == 1) {
            $.cookie('sma_theme_fixed', 'no', { path: '/' });
        }
        if ($.cookie('sma_theme_fixed') == 'yes') {
            $('#content').addClass('content-with-fixed');
            $('#sidebar-left').addClass('sidebar-fixed').css('height', $(window).height()- 80);
            $('#header').css('position', 'fixed').css('top', '0').css('width', '100%');
            $('#fixedText').text('Static');
            $('#main-menu-act').removeAttr("class").hide();
            $('#fixed').addClass('fixed');
            $("#sidebar-left").css("overflow","hidden");
            $('#sidebar-left').perfectScrollbar({suppressScrollX: true});
        } else {
            $('#content, #sidebar-left, #header').removeAttr("style");
            $('#sidebar-left').removeClass('sidebar-fixed');
            $('#content').removeClass('content-with-fixed');
            $('#fixedText').text('Fixed');
            $('#main-menu-act').addClass('full visible-md visible-lg').show();
            $('#fixed').removeClass('fixed');
            $('#sidebar-left').perfectScrollbar('destroy');
        }
    }
    widthFunctions();
}
$('#csv_file').change(function(e) {
    v = $(this).val();
    if (v != '') {
        var validExts = new Array(".csv");
        var fileExt = v;
        fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
        if (validExts.indexOf(fileExt) < 0) {
            e.preventDefault();
            bootbox.alert("Invalid file selected. Only .csv file is allowed.");
            $(this).val(''); $(this).fileinput('clear');
            $('form[data-toggle="validator"]').bootstrapValidator('updateStatus', 'csv_file', 'NOT_VALIDATED');
            return false;
        }
        else
            return true;
    }
});

$(document).ready(function() {
    $("#suggest_product").autocomplete({
        source: site.base_url+'reports/suggestions',
        select: function (event, ui) {
            $('#report_product_id').val(ui.item.id);
        },
        minLength: 1,
        autoFocus: false,
        delay: 250,
        response: function (event, ui) {
            if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).val(ui.item.label);
                $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');
            }
        },
    });
    $(document).on('blur', '#suggest_product', function(e) {
        if (! $(this).val()) {
            $('#report_product_id').val('');
        }
    });
    $('#random_num').click(function(){
        $(this).parent('.input-group').children('input').val(generateCardNo(8));
    });
    $('#toogle-customer-read-attr').click(function () {
        var icus = $(this).closest('.input-group').find("input[name='customer']");
        var nst = icus.is('[readonly]') ? false : true;
        icus.select2("readonly", nst);
        return false;
    });
    $('.top-menu-scroll').perfectScrollbar();
    $('#fixed').click(function(e) {
        e.preventDefault();
        if($('#sidebar-left').hasClass('minified')) {
            bootbox.alert('Unable to fix minified sidebar');
        } else {
            if($(this).hasClass('fixed')) {
                $.cookie('sma_theme_fixed', 'no', { path: '/' });
            } else {
                $.cookie('sma_theme_fixed', 'yes', { path: '/' });
            }
            cssStyle();
        }
    });
});

function widthFunctions(e) {
    var l = $("#sidebar-left").outerHeight(true),
    c = $("#content").height(),
    co = $("#content").outerHeight(),
    h = $("header").height(),
    f = $("footer").height(),
    wh = $(window).height(),
    ww = $(window).width();
    if (ww < 992) {
        $("#main-menu-act").removeClass("minified").addClass("full").find("i").removeClass("fa-angle-double-right").addClass("fa-angle-double-left");
        $("body").removeClass("sidebar-minified");
        $("#content").removeClass("sidebar-minified");
        $("#sidebar-left").removeClass("minified")
        if ($.cookie('sma_theme_fixed') == 'yes') {
            $.cookie('sma_theme_fixed', 'no', { path: '/' });
            $('#content, #sidebar-left, #header').removeAttr("style");
            $("#sidebar-left").css("overflow-y","visible");
            $('#fixedText').text('Fixed');
            $('#main-menu-act').addClass('full visible-md visible-lg').show();
            $('#fixed').removeClass('fixed');
            $('#sidebar-left').perfectScrollbar('destroy');
        }
    }
    if (ww < 998 && ww > 750) {
        $('#main-menu-act').hide();
        $("body").addClass("sidebar-minified");
        $("#content").addClass("sidebar-minified");
        $("#sidebar-left").addClass("minified");
        $(".dropmenu > .chevron").removeClass("opened").addClass("closed");
        $(".dropmenu").parent().find("ul").hide();
        $("#sidebar-left > div > ul > li > a > .chevron").removeClass("closed").addClass("opened");
        $("#sidebar-left > div > ul > li > a").addClass("open");
        $('#fixed').hide();
    }
    if (ww > 1024 && $.cookie('sma_sidebar') != 'minified') {
        $('#main-menu-act').removeClass("minified").addClass("full").find("i").removeClass("fa-angle-double-right").addClass("fa-angle-double-left");
        $("body").removeClass("sidebar-minified");
        $("#content").removeClass("sidebar-minified");
        $("#sidebar-left").removeClass("minified");
        $("#sidebar-left > div > ul > li > a > .chevron").removeClass("opened").addClass("closed");
        $("#sidebar-left > div > ul > li > a").removeClass("open");
        $('#fixed').show();
    }
    if ($.cookie('sma_theme_fixed') == 'yes') {
        $('#content').addClass('content-with-fixed');
        $('#sidebar-left').addClass('sidebar-fixed').css('height', $(window).height()- 80);
    }
    if (ww > 767) {
        wh - 80 > l && $("#sidebar-left").css("min-height", wh - h - f - 30);
        wh - 80 > c && $("#content").css("min-height", wh - h - f - 30);
    } else {
        $("#sidebar-left").css("min-height", "0px");
        $(".content-con").css("max-width", ww);
    }
    //$(window).scrollTop($(window).scrollTop() + 1);
}

jQuery(document).ready(function(e) {
    window.location.hash ? e('#myTab a[href="' + window.location.hash + '"]').tab('show') : e("#myTab a:first").tab("show");
    e("#myTab2 a:first, #dbTab a:first").tab("show");
    e("#myTab a, #myTab2 a, #dbTab a").click(function(t) {
        t.preventDefault();
        e(this).tab("show");
    });
    e('[rel="popover"],[data-rel="popover"],[data-toggle="popover"]').popover();
    e("#toggle-fullscreen").button().click(function() {
        var t = e(this),
        n = document.documentElement;
        if (!t.hasClass("active")) {
            e("#thumbnails").addClass("modal-fullscreen");
            n.webkitRequestFullScreen ? n.webkitRequestFullScreen(window.Element.ALLOW_KEYBOARD_INPUT) : n.mozRequestFullScreen && n.mozRequestFullScreen()
        } else {
            e("#thumbnails").removeClass("modal-fullscreen");
            (document.webkitCancelFullScreen || document.mozCancelFullScreen || e.noop).apply(document)
        }
    });
    e(".btn-close").click(function(t) {
        t.preventDefault();
        e(this).parent().parent().parent().fadeOut()
    });
    e(".btn-minimize").click(function(t) {
        t.preventDefault();
        var n = e(this).parent().parent().next(".box-content");
        n.is(":visible") ? e("i", e(this)).removeClass("fa-chevron-up").addClass("fa-chevron-down") : e("i", e(this)).removeClass("fa-chevron-down").addClass("fa-chevron-up");
        n.slideToggle("slow", function() {
            widthFunctions();
        })
    });
});

jQuery(document).ready(function(e) {
    e("#main-menu-act").click(function() {
        if (e(this).hasClass("full")) {
            $.cookie('sma_sidebar', 'minified', { path: '/' });
            e(this).removeClass("full").addClass("minified").find("i").removeClass("fa-angle-double-left").addClass("fa-angle-double-right");
            e("body").addClass("sidebar-minified");
            e("#content").addClass("sidebar-minified");
            e("#sidebar-left").addClass("minified");
            e(".dropmenu > .chevron").removeClass("opened").addClass("closed");
            e(".dropmenu").parent().find("ul").hide();
            e("#sidebar-left > div > ul > li > a > .chevron").removeClass("closed").addClass("opened");
            e("#sidebar-left > div > ul > li > a").addClass("open");
            $('#fixed').hide();
        } else {
            $.cookie('sma_sidebar', 'full', { path: '/' });
            e(this).removeClass("minified").addClass("full").find("i").removeClass("fa-angle-double-right").addClass("fa-angle-double-left");
            e("body").removeClass("sidebar-minified");
            e("#content").removeClass("sidebar-minified");
            e("#sidebar-left").removeClass("minified");
            e("#sidebar-left > div > ul > li > a > .chevron").removeClass("opened").addClass("closed");
            e("#sidebar-left > div > ul > li > a").removeClass("open");
            $('#fixed').show();
        }
        return false;
    });
e(".dropmenu").click(function(t) {
    t.preventDefault();
    if (e("#sidebar-left").hasClass("minified")) {
        if (!e(this).hasClass("open")) {
            e(this).parent().find("ul").first().slideToggle();
            e(this).find(".chevron").hasClass("closed") ? e(this).find(".chevron").removeClass("closed").addClass("opened") : e(this).find(".chevron").removeClass("opened").addClass("closed")
        }
    } else {
        e(this).parent().find("ul").first().slideToggle();
        e(this).find(".chevron").hasClass("closed") ? e(this).find(".chevron").removeClass("closed").addClass("opened") : e(this).find(".chevron").removeClass("opened").addClass("closed")
    }
});
if (e("#sidebar-left").hasClass("minified")) {
    e("#sidebar-left > div > ul > li > a > .chevron").removeClass("closed").addClass("opened");
    e("#sidebar-left > div > ul > li > a").addClass("open");
    e("body").addClass("sidebar-minified")
}
});

$(document).ready(function() {
    cssStyle();
    $('select, .select').select2({minimumResultsForSearch: 7});
    $('#customer, #rcustomer').select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"customers/suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});
    $('#supplier, #rsupplier, .rsupplier').select2({
       minimumInputLength: 1,
        placeholder: "Select_supplier",
       ajax: {
        url: site.base_url+"suppliers/suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});

$('#recipe_product, #rrecipe_product, .rrecipe_product').select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"recipe/product_suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});

$('#recipe_addon, #rrecipe_addon, .rrecipe_addon').select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"recipe/addon_suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});

$('#raw_product, #rraw_product, .rraw_product').select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"products/raw_suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});


$('.recipe_category_item').select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"system_settings/recipe_category_suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});

$('.recipe_item').select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"system_settings/recipe_item_suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});

    $('.input-tip').tooltip({placement: 'top', html: true, trigger: 'hover focus', container: 'body',
        title: function() {
            return $(this).attr('data-tip');
        }
    });
    $('.input-pop').popover({placement: 'top', html: true, trigger: 'hover', container: 'body',
        content: function() {
            return $(this).attr('data-tip');
        },
        title: function() {
            return '<b>' + $('label[for="' + $(this).attr('id') + '"]').text() + '</b>';
        }
    });
});

$(document).on('click', '*[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
$(document).on('click', '*[data-toggle="popover"]', function(event) {
    event.preventDefault();
    $(this).popover();
});

$(document).ajaxStart(function(){
  $('#ajaxCall').show();
}).ajaxStop(function(){
  $('#ajaxCall').hide();
});

$(document).ready(function() {
    $('input[type="checkbox"],[type="radio"]').not('.skip').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('textarea').not('.skip').redactor({
        buttons: ['formatting', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'bold', 'italic', 'underline', '|', 'unorderedlist', 'orderedlist', '|', /*'image', 'video',*/ 'link', '|', 'html'],
        formattingTags: ['p', 'pre', 'h3', 'h4'],
        minHeight: 100,
        changeCallback: function(e) {
            var editor = this.$editor.next('textarea');
            if($(editor).attr('required')){
                $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', $(editor).attr('name'));
            }
        }
    });
    $(document).on('click', '.file-caption', function(){
        $(this).next('.input-group-btn').children('.btn-file').children('input.file').trigger('click');
    });
});

function suppliers(ele) {
    $(ele).select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"suppliers/suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});
}

function recipe_products(ele) {
    $(ele).select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"recipe/product_suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});
}

function recipe_addon(ele) {
    $(ele).select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"recipe/addon_suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});
}

function raw_products(ele) {
    $(ele).select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"products/raw_suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});
}


function recipe_category_item(ele) {
    $(ele).select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"system_settings/recipe_category_suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});
}



function recipe_item(ele) {
    $(ele).select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"system_settings/recipe_item_suggestions",
        dataType: 'json',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
                limit: 10
            };
        },
        results: function (data, page) {
            if(data.results != null) {
                return { results: data.results };
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
});
}




$(function() {
    $('.datetime').datetimepicker({format: site.dateFormats.js_ldate, fontAwesome: true, language: 'sma', weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, forceParse: 0});
    $('.date').datetimepicker({format: 'yyyy-mm-dd', fontAwesome: true, language: 'sma', todayBtn: 1, autoclose: 1,  minView: 2 });



	$('.time,.timepicker').datetimepicker({format: "HH:00", fontAwesome: true, language: 'sma',  autoclose: 1, showMeridian: true,
                startView: 1,
                maxView: 1,minView:1});
    $(document).on('focus','.date', function(t) {
        $(this).datetimepicker({format: site.dateFormats.js_sdate, fontAwesome: true, todayBtn: 1, autoclose: 1, minView: 2 });
    });
    $(document).on('focus','.totay_date', function(t) {
        $(this).datetimepicker({format: site.dateFormats.js_sdate, fontAwesome: true, todayBtn: 1, autoclose: 1, minView: 2,startDate: new Date() });
    });
    $(document).on('focus','.datetime', function() {
        $(this).datetimepicker({format: site.dateFormats.js_ldate, fontAwesome: true, weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, forceParse: 0});
    });
    
	$(document).on('focus','.time', function() {
        $(this).datetimepicker({format: "HH:00", fontAwesome: true,  autoclose: 1,  forceParse: 0, showMeridian: true,
                startView: 1,
                maxView: 1,minView:1});
    });
    $(document).on('focus','.timepicker', function() {
        $(this).datetimepicker({format: "HH:00", fontAwesome: true, language: 'sma',  autoclose: 1, showMeridian: true,
                startView: 1,
                maxView: 1,minView:1});
    });
    $(document).on('focus','.date_picker', function() {
        $(this).datetimepicker({format: site.dateFormats.js_sdate, fontAwesome: true, todayBtn: 1, autoclose: 1, minView: 2,startDate: new Date() });
    });
});

$(document).ready(function() {
    $('#dbTab a').on('shown.bs.tab', function(e) {
      var newt = $(e.target).attr('href');
      var oldt = $(e.relatedTarget).attr('href');
      $(oldt).hide();
      //$(newt).hide().fadeIn('slow');
      $(newt).hide().slideDown('slow');
  });
    $('.dropdown').on('show.bs.dropdown', function(e){
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown('fast');
    });
    $('.dropdown').on('hide.bs.dropdown', function(e){
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp('fast');
    });
    $('.hideComment').click(function(){
        $.ajax({ url: site.base_url+'welcome/hideNotification/'+$(this).attr('id')});
    });
    $('.tip').tooltip();
    $('body').on('click', '#delete', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form').submit();
    });
    $('body').on('click', '#sync_quantity', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
    $('body').on('click', '#excel', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
    $('body').on('click', '#pdf', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
    $('body').on('click', '#labelProducts', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
    $('body').on('click', '#barcodeProducts', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
    $('body').on('click', '#combine', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
});

$(document).ready(function() {
    $('#product-search').click(function() {
        $('#product-search-form').submit();
    });
    //feedbackIcons:{valid: 'fa fa-check',invalid: 'fa fa-times',validating: 'fa fa-refresh'},
    $('form[data-toggle="validator"]').bootstrapValidator({ message: 'Please enter/select a value', submitButtons: 'input[type="submit"]' });
    fields = $('.form-control');
    $.each(fields, function() {
        var id = $(this).attr('id');
        var iname = $(this).attr('name');
        var iid = '#'+id;
       // if (!!$(this).attr('data-bv-notempty') || !!$(this).attr('required')) {
		    if (!!$(this).attr('required')) {
            $("label[for='" + id + "']").append(' *');
            $(document).on('change', iid, function(){
                $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', iname);
            });
        }
    });
    $('body').on('click', 'label', function (e) {
        var field_id = $(this).attr('for');
        if (field_id) {
            if($("#"+field_id).hasClass('select')) {
                $("#"+field_id).select2("open");
                return false;
            }
        }
    });
    $('body').on('focus', 'select', function (e) {
        var field_id = $(this).attr('id');
        if (field_id) {
            if($("#"+field_id).hasClass('select')) {
                $("#"+field_id).select2("open");
                return false;
            }
        }
    });
    $('#myModal').on('hidden.bs.modal', function() {
        $(this).find('.modal-dialog').empty();
        //$(this).find('#myModalLabel').empty().html('&nbsp;');
        //$(this).find('.modal-body').empty().text('Loading...');
        //$(this).find('.modal-footer').empty().html('&nbsp;');
        $(this).removeData('bs.modal');
    });
    $('#myModal2').on('hidden.bs.modal', function () {
        $(this).find('.modal-dialog').empty();
        //$(this).find('#myModalLabel').empty().html('&nbsp;');
        //$(this).find('.modal-body').empty().text('Loading...');
        //$(this).find('.modal-footer').empty().html('&nbsp;');
        $(this).removeData('bs.modal');
        $('#myModal').css('zIndex', '1050');
        $('#myModal').css('overflow-y', 'scroll');
    });
    $('#myModal2').on('show.bs.modal', function () {
        $('#myModal').css('zIndex', '1040');
    });
    $('.modal').on('show.bs.modal', function () {
        $('#modal-loading').show();
        $('.blackbg').css('zIndex', '1041');
        $('.loader').css('zIndex', '1042');
    }).on('hide.bs.modal', function () {
        $('#modal-loading').hide();
        $('.blackbg').css('zIndex', '3');
        $('.loader').css('zIndex', '4');
    });
    $(document).on('click', '.po', function(e) {
        e.preventDefault();
        $('.po').popover({html: true, placement: 'left', trigger: 'manual'}).popover('show').not(this).popover('hide');
        return false;
    });
    $(document).on('click', '.po-close', function() {
        $('.po').popover('hide');
        return false;
    });
    $(document).on('click', '.po-delete', function(e) {
        var row = $(this).closest('tr');
        e.preventDefault();
        $('.po').popover('hide');
        var link = $(this).attr('href');
        var return_id = $(this).attr('data-return-id');
        $.ajax({type: "get", url: link, dataType: 'json',
            success: function(data) {
                if (data.error == 1) { addAlert(data.msg, 'danger'); }
                else { addAlert(data.msg, 'success'); if(oTable != '') { oTable.fnDraw(); } }
            },
            error: function(data) { addAlert('Ajax call failed', 'danger'); }
        });
        return false;
    });
    $(document).on('click', '.po-delete1', function(e) {
        e.preventDefault();
        $('.po').popover('hide');
        var link = $(this).attr('href');
        var s = $(this).attr('id'); var sp = s.split('__')
        $.ajax({type: "get", url: link, dataType: 'json',
            success: function(data) {
                if (data.error == 1) { addAlert(data.msg, 'danger'); }
                else { addAlert(data.msg, 'success'); if(oTable != '') { oTable.fnDraw(); } }
            },
            error: function(data) { addAlert('Ajax call failed', 'danger'); }
        });
        return false;
    });
    $('body').on('click', '.bpo', function(e) {
        e.preventDefault();
        $(this).popover({html: true, trigger: 'manual'}).popover('toggle');
        return false;
    });
    $('body').on('click', '.bpo-close', function(e) {
        $('.bpo').popover('hide');
        return false;
    });
    $('#genNo').click(function(){
        var no = generateCardNo();
        $(this).parent().parent('.input-group').children('input').val(no);
        return false;
    });
    $('#inlineCalc').calculator({layout: ['_%+-CABS','_7_8_9_/','_4_5_6_*','_1_2_3_-','_0_._=_+'], showFormula:true});
    $('.calc').click(function(e) { e.stopPropagation();});
    $(document).on('click', '.sname', function(e) {
        var row = $(this).closest('tr');
        var itemid = row.find('.rid').val();
        $('#myModal').modal({remote: site.base_url + 'products/modal_view/' + itemid});
        $('#myModal').modal('show');
    });
});

function addAlert(message, type) {
    $('.alerts-con').empty().append(
        '<div class="alert alert-' + type + '">' +
        '<button type="button" class="close" data-dismiss="alert">' +
        '&times;</button>' + message + '</div>');
}

$(document).ready(function() {
    if ($.cookie('sma_sidebar') != 'minified') {
        
        $('#main-menu-act').removeClass("minified").addClass("full").find("i").removeClass("fa-angle-double-right").addClass("fa-angle-double-left");
        $("body").removeClass("sidebar-minified");
        $("#content").removeClass("sidebar-minified");
        $("#sidebar-left").removeClass("minified");
        $("#sidebar-left > div > ul > li > a > .chevron").removeClass("opened").addClass("closed");
        $("#sidebar-left > div > ul > li > a").removeClass("open");
        $('#fixed').show();
    } else {
		
		$('#main-menu-act').removeClass("full").addClass("minified").find("i").removeClass("fa-angle-double-left").addClass("fa-angle-double-right");
        $("body").addClass("sidebar-minified");
        $("#content").addClass("sidebar-minified");
        $("#sidebar-left").addClass("minified");
        $(".dropmenu > .chevron").removeClass("opened").addClass("closed");
        $(".dropmenu").parent().find("ul").hide();
        $("#sidebar-left > div > ul > li > a > .chevron").removeClass("closed").addClass("opened");
        $("#sidebar-left > div > ul > li > a").addClass("open");
        $('#fixed').hide();
		
    }
});

$(document).ready(function() {
    $('#daterange').daterangepicker({
        timePicker: true,
        format: (site.dateFormats.js_sdate).toUpperCase()+' HH:mm',
        ranges: {
         'Today': [moment().hours(0).minutes(0).seconds(0), moment()],
         'Yesterday': [moment().subtract('days', 1).hours(0).minutes(0).seconds(0), moment().subtract('days', 1).hours(23).minutes(59).seconds(59)],
         'Last 7 Days': [moment().subtract('days', 6).hours(0).minutes(0).seconds(0), moment().hours(23).minutes(59).seconds(59)],
         'Last 30 Days': [moment().subtract('days', 29).hours(0).minutes(0).seconds(0), moment().hours(23).minutes(59).seconds(59)],
         'This Month': [moment().startOf('month').hours(0).minutes(0).seconds(0), moment().endOf('month').hours(23).minutes(59).seconds(59)],
         'Last Month': [moment().subtract('month', 1).startOf('month').hours(0).minutes(0).seconds(0), moment().subtract('month', 1).endOf('month').hours(23).minutes(59).seconds(59)]
     }
 },
 function(start, end) {
    refreshPage(start.format('YYYY-MM-DD HH:mm'), end.format('YYYY-MM-DD HH:mm'));
});
});

function refreshPage(start, end) {
    window.location.replace(CURI + '/' + encodeURIComponent(start) + '/' + encodeURIComponent(end));
}

function retina() {
    retinaMode = window.devicePixelRatio > 1;
    return retinaMode
}

$(document).ready(function() {
    $('#cssLight').click(function(e) {
        e.preventDefault();
        $.cookie('sma_style', 'light', { path: '/' });
        cssStyle();
        return true;
    });
    $('#cssBlue').click(function(e) {
        e.preventDefault();
        $.cookie('sma_style', 'blue', { path: '/' });
        cssStyle();
        return true;
    });
    $('#cssBlack').click(function(e) {
        e.preventDefault();
        $.cookie('sma_style', 'black', { path: '/' });
        cssStyle();
        return true;
    });
	 $('#cssdarkBlue').click(function(e) {
        e.preventDefault();
        $.cookie('sma_style', 'dark_blue', { path: '/' });
        cssStyle();
        return true;
    });
	
    $("#toTop").click(function(e) {
        e.preventDefault();
        $("html, body").animate({scrollTop: 0}, 100);
    });
    $(document).on('click', '.delimg', function(e) {
        e.preventDefault();
        var ele = $(this), id = $(this).attr('data-item-id');
        bootbox.confirm(lang.r_u_sure, function(result) {
        if(result == true) {
            $.get(site.base_url+'products/delete_image/'+id, function(data) {
                if (data.error === 0) {
                    addAlert(data.msg, 'success');
                    ele.parent('.gallery-image').remove();
                }
            });
        }
        });
        return false;
    });
});
$(document).ready(function() {
    $(document).on('click', '.row_status', function(e) {
        e.preventDefault;
        var row = $(this).closest('tr');
        var id = row.attr('id');
        if (row.hasClass('invoice_link')) {
            $('#myModal').modal({remote: site.base_url + 'sales/update_status/' + id});
            $('#myModal').modal('show');
        } else if (row.hasClass('purchase_link')) {
            $('#myModal').modal({remote: site.base_url + 'purchases/update_status/' + id});
            $('#myModal').modal('show');
        } else if (row.hasClass('quote_link')) {
            $('#myModal').modal({remote: site.base_url + 'quotes/update_status/' + id});
            $('#myModal').modal('show');
        }else if (row.hasClass('material_request_link')) {
            $('#myModal').modal({remote: site.base_url + 'material_request/update_status/' + id});
            $('#myModal').modal('show');
        } else if (row.hasClass('transfer_link')) {
            $('#myModal').modal({remote: site.base_url + 'transfers/update_status/' + id});
            $('#myModal').modal('show');
        } else if (row.hasClass('purchases_order_link')) {
            $('#myModal').modal({remote: site.base_url + 'purchases_order/update_status/' + id});
            $('#myModal').modal('show');
        }
        return false;
    });
});
/*
 $(window).scroll(function() {
    if ($(this).scrollTop()) {
        $('#toTop').fadeIn();
    } else {
        $('#toTop').fadeOut();
    }
 });
*/
$(document).on('ifChecked', '.checkth, .checkft', function(event) {
    $('.checkth, .checkft').iCheck('check');
    $('.multi-select').each(function() {
        $(this).iCheck('check');
    });
});
$(document).on('ifUnchecked', '.checkth, .checkft', function(event) {
    $('.checkth, .checkft').iCheck('uncheck');
    $('.multi-select').each(function() {
        $(this).iCheck('uncheck');
    });
});
$(document).on('ifUnchecked', '.multi-select', function(event) {
    $('.checkth, .checkft').attr('checked', false);
    $('.checkth, .checkft').iCheck('update');
});

function check_add_item_val() {
    $('#add_item').bind('keypress', function (e) {
        if (e.keyCode == 13 || e.keyCode == 9) {
            e.preventDefault();
            $(this).autocomplete("search");
        }
    });
}
function fld(oObj) {
    if (oObj != null) {
        var aDate = oObj.split('-');
        var bDate = aDate[2].split(' ');
        year = aDate[0], month = aDate[1], day = bDate[0], time = bDate[1];
        if (site.dateFormats.js_sdate == 'dd-mm-yyyy')
            return day + "-" + month + "-" + year + " " + time;
        else if (site.dateFormats.js_sdate === 'dd/mm/yyyy')
            return day + "/" + month + "/" + year + " " + time;
        else if (site.dateFormats.js_sdate == 'dd.mm.yyyy')
            return day + "." + month + "." + year + " " + time;
        else if (site.dateFormats.js_sdate == 'mm/dd/yyyy')
            return month + "/" + day + "/" + year + " " + time;
        else if (site.dateFormats.js_sdate == 'mm-dd-yyyy')
            return month + "-" + day + "-" + year + " " + time;
        else if (site.dateFormats.js_sdate == 'mm.dd.yyyy')
            return month + "." + day + "." + year + " " + time;
        else
            return oObj;
    } else {
        return '';
    }
}

function fsd(oObj) {
    if (oObj != null) {
        var aDate = oObj.split('-');
        if (site.dateFormats.js_sdate == 'dd-mm-yyyy')
            return aDate[2] + "-" + aDate[1] + "-" + aDate[0];
        else if (site.dateFormats.js_sdate === 'dd/mm/yyyy')
            return aDate[2] + "/" + aDate[1] + "/" + aDate[0];
        else if (site.dateFormats.js_sdate == 'dd.mm.yyyy')
            return aDate[2] + "." + aDate[1] + "." + aDate[0];
        else if (site.dateFormats.js_sdate == 'mm/dd/yyyy')
            return aDate[1] + "/" + aDate[2] + "/" + aDate[0];
        else if (site.dateFormats.js_sdate == 'mm-dd-yyyy')
            return aDate[1] + "-" + aDate[2] + "-" + aDate[0];
        else if (site.dateFormats.js_sdate == 'mm.dd.yyyy')
            return aDate[1] + "." + aDate[2] + "." + aDate[0];
        else
            return oObj;
    } else {
        return '';
    }
}
function generateCardNo(x) {
    if(!x) { x = 16; }
    chars = "1234567890";
    no = "";
    for (var i=0; i<x; i++) {
       var rnum = Math.floor(Math.random() * chars.length);
       no += chars.substring(rnum,rnum+1);
   }
   return no;
}
function roundNumber(num, nearest) {
    if(!nearest) { nearest = 0.05; }
    return Math.round((num / nearest) * nearest);
}
function getNumber(x) {
    return accounting.unformat(x);
}
function formatQuantity(x) {
    return (x != null) ? '<div class="text-center">'+formatNumber(x, site.settings.qty_decimals)+'</div>' : '';
}
function formatQuantity2(x) {
    return (x != null) ? formatQuantityNumber(x, site.settings.qty_decimals) : '';
}
function formatQuantityNumber(x, d) {
    if (!d) { d = site.settings.qty_decimals; }
    return parseFloat(accounting.formatNumber(x, d, '', '.'));
}
function formatQty(x) {
    return (x != null) ? formatNumber(x, site.settings.qty_decimals) : '';
}
function formatNumber(x, d) {
    if(!d && d != 0) { d = site.settings.decimals; }
    if(site.settings.sac == 1) {
        return formatSA(parseFloat(x).toFixed(d));
    }
    return accounting.formatNumber(x, d, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep);
}
function formatMoney(x, symbol) {
    if(!symbol) { symbol = ""; }
    if(site.settings.sac == 1) {
        return (site.settings.display_symbol == 1 ? site.settings.symbol : '') +
            ''+formatSA(parseFloat(x).toFixed(site.settings.decimals)) +
            (site.settings.display_symbol == 2 ? site.settings.symbol : '');
    }
    var fmoney = accounting.formatMoney(x, symbol, site.settings.decimals, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v");
    if(symbol){
       return fmoney; 
    }
    return (site.settings.display_symbol == 1 ? site.settings.symbol : '') +
        fmoney +
        (site.settings.display_symbol == 2 ? site.settings.symbol : '');
}
function is_valid_discount(mixed_var) {
    return (is_numeric(mixed_var) || (/([0-9]%)/i.test(mixed_var))) ? true : false;
}
function is_numeric(mixed_var) {
    var whitespace =
    " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -
        1)) && mixed_var !== '' && !isNaN(mixed_var);
}
function is_float(mixed_var) {
  return +mixed_var === mixed_var && (!isFinite(mixed_var) || !! (mixed_var % 1));
}
function decimalFormat(x) {
    return '<div class="text-center">'+formatNumber(x != null ? x : 0)+'</div>';
}
function currencyFormat(x) {
    return '<div class="text-right">'+formatMoney(x != null ? x : 0)+'</div>';
}
function formatDecimal(x, d) {
    if (!d) { d = site.settings.decimals; }
    return parseFloat(accounting.formatNumber(x, d, '', '.'));
}
function formatDecimals(x, d) {
    if (!d) { d = site.settings.decimals; }
    return parseFloat(accounting.formatNumber(x, d, '', '.')).toFixed(d);
}
function format2Decimals(x,d=2) {
    if (!d) { d = site.settings.decimals; }
    return parseFloat(accounting.formatNumber(x, d, '', '.')).toFixed(d);
}
function pqFormat(x) {
    if (x != null) {
        var d = '', pqc = x.split("___");
        for (index = 0; index < pqc.length; ++index) {
            var pq = pqc[index];
            var v = pq.split("__");
            d += v[0]+' ('+formatQuantity2(v[1])+')<br>';
        }
        return d;
    } else {
        return '';
    }
}
function checkbox(x) {
    return '<div class="text-center"><input class="checkbox multi-select" type="checkbox" name="val[]" value="' + x + '" /></div>';
}
function decode_html(value){
    return $('<div/>').html(value).text();
}
function img_hl(x) {
    var image_link = (x == null || x == '') ? 'no_image.png' : x;
    return '<div class="text-center"><a href="'+site.url+'assets/uploads/' + image_link + '" data-toggle="lightbox"><img src="'+site.url+'assets/uploads/thumbs/' + image_link + '" alt="" style="width:30px; height:30px;" /></a></div>';
}
function recipe_img(x) {
    var y = x.split("__");    
    var image_link = (y[3] == null || y[3] == '') ? 'no_image.png' : y[3];
     if(y[0] == 1 ) {
    return '<a href="'+site.base_url+'recipe/deactivate/'+ y[1] +'" data-toggle="modal" data-target="#myModal"><img src="'+site.url+'assets/uploads/thumbs/' + image_link + '" alt="" style="width:30px; height:30px;" /></a>' 
    }
     else{
       return '<a href="'+site.base_url+'recipe/activate/'+ y[1] +'" data-toggle="modal" data-target="#myModal"><img src="'+site.url+'assets/uploads/thumbs/' + image_link + '" alt="" style="width:30px; height:30px;" /><a/>';
     }
}
function recipe_stock(x) {
    var y = x;    
   
    return '<a href="'+site.base_url+'recipe/stock/'+ y +'" data-toggle="modal" data-target="#myModal">stock<a/>';
     
}
function attachment(x) {
    return x == null ? '' : '<div class="text-center"><a href="'+site.base_url+'welcome/download/' + x + '" class="tip" title="'+lang.download+'"><i class="fa fa-file"></i></a></div>';
}
function procurment_attachment(x) {
    var y = x.split("__");    
    var image_link = (y[1] == null || y[1] == '') ? '' : y[0]+y[1];
    return y[1] == null || y[1]==''? '' : '<div class="text-center"><a href="'+site.url+ image_link + '" class="tip" title="'+lang.download+'" download><i class="fa fa-file"></i></a></div>';
}
function attachment2(x) {
    return x == null ? '' : '<div class="text-center"><a href="'+site.base_url+'welcome/download/' + x + '" class="tip" title="'+lang.download+'"><i class="fa fa-file-o"></i></a></div>';
}
function user_status(x) {
    var y = x.split("__");
    return y[0] == 1 ?
    '<a href="'+site.base_url+'auth/deactivate/'+ y[1] +'" data-toggle="modal" data-target="#myModal"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>' :
    '<a href="'+site.base_url+'auth/activate/'+ y[1] +'"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
}

function recipe_status(x) {
    var y = x.split("__");
    return y[0] == 1 ?
    '<a href="'+site.base_url+'recipe/deactivate/'+ y[1] +'" data-toggle="modal" data-target="#myModal"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>' :
    '<a href="'+site.base_url+'recipe/activate/'+ y[1] +'" data-toggle="modal" data-target="#myModal"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
}

function product_status(x) {    
    var y = x.split("__");
    return y[0] == 1 ?

    '<a href="'+site.base_url+'products/deactivate/'+ y[1] +'" data-toggle="modal" data-target="#myModal"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>' :
    '<a href="'+site.base_url+'products/activate/'+ y[1] +'"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
}
function row_status(x) {
    if(x == null) {
        return '';
    } else if(x == 'pending') {
        return '<div class="text-center"><span class="row_status label label-warning">'+lang[x]+'</span></div>';
    } else if(x == 'completed' || x == 'paid' || x == 'sent' || x == 'received') {
        return '<div class="text-center"><span class="row_status label label-success">'+lang[x]+'</span></div>';
    } else if(x == 'partial' || x == 'transferring' || x == 'ordered') {
        return '<div class="text-center"><span class="row_status label label-info">'+lang[x]+'</span></div>';
    } else if(x == 'due' || x == 'returned') {
        return '<div class="text-center"><span class="row_status label label-danger">'+lang[x]+'</span></div>';
    } else {
        return '<div class="text-center"><span class="row_status label label-default">'+x+'</span></div>';
    }
}
function pay_status(x) {
    if(x == null) {
        return '';
    } else if(x == 'pending') {
        return '<div class="text-center"><span class="payment_status label label-warning">'+lang[x]+'</span></div>';
    } else if(x == 'completed' || x == 'paid' || x == 'sent' || x == 'received') {
        return '<div class="text-center"><span class="payment_status label label-success">'+lang[x]+'</span></div>';
    } else if(x == 'partial' || x == 'transferring' || x == 'ordered') {
        return '<div class="text-center"><span class="payment_status label label-info">'+lang[x]+'</span></div>';
    } else if(x == 'due' || x == 'returned') {
        return '<div class="text-center"><span class="payment_status label label-danger">'+lang[x]+'</span></div>';
    } else {
        return '<div class="text-center"><span class="payment_status label label-default">'+x+'</span></div>';
    }
}
function formatSA (x) {
    x=x.toString();
    var afterPoint = '';
    if(x.indexOf('.') > 0)
       afterPoint = x.substring(x.indexOf('.'),x.length);
    x = Math.floor(x);
    x=x.toString();
    var lastThree = x.substring(x.length-3);
    var otherNumbers = x.substring(0,x.length-3);
    if(otherNumbers != '')
        lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;

    return res;
}

function unitToBaseQty(qty, unitObj) {
    switch(unitObj.operator) {
        case '*':
            return parseFloat(qty)*parseFloat(unitObj.operation_value);
            break;
        case '/':
            return parseFloat(qty)/parseFloat(unitObj.operation_value);
            break;
        case '+':
            return parseFloat(qty)+parseFloat(unitObj.operation_value);
            break;
        case '-':
            return parseFloat(qty)-parseFloat(unitObj.operation_value);
            break;
        default:
            return parseFloat(qty);
    }
}

function baseToUnitQty(qty, unitObj) {
    switch(unitObj.operator) {
        case '*':
            return parseFloat(qty)/parseFloat(unitObj.operation_value);
            break;
        case '/':
            return parseFloat(qty)*parseFloat(unitObj.operation_value);
            break;
        case '+':
            return parseFloat(qty)-parseFloat(unitObj.operation_value);
            break;
        case '-':
            return parseFloat(qty)+parseFloat(unitObj.operation_value);
            break;
        default:
            return parseFloat(qty);
    }
}

function set_page_focus() {
    if (site.settings.set_focus == 1) {
        $('#add_item').attr('tabindex', an);
        $('[tabindex='+(an-1)+']').focus().select();
    } else {
        $('#add_item').attr('tabindex', 1);
        $('#add_item').focus();
    }
    $('.rquantity').bind('keypress', function (e) {
        if (e.keyCode == 13) {
            $('#add_item').focus();
        }
    });
}

function calculateTax(tax, amt, met) {
    if (tax && tax_rates) {
        tax_val = 0; tax_rate = '';
        $.each(tax_rates, function() {
            if (this.id == tax) {
                tax = this;
                return false;
            }
        });
        if (tax.type == 1) {
            if (met == '0') {
                tax_val = formatDecimal(((amt) * parseFloat(tax.rate)) / (100 + parseFloat(tax.rate)), 4);
                tax_rate = formatDecimal(tax.rate) + '%';
            } else {
                tax_val = formatDecimal(((amt) * parseFloat(tax.rate)) / 100, 4);
                tax_rate = formatDecimal(tax.rate) + '%';
            }
        } else if (tax.type == 2) {
            tax_val = parseFloat(tax.rate);
            tax_rate = formatDecimal(tax.rate);
        }
        return [tax_val, tax_rate];
    }
    return false;
}

function calculateDiscount(val, amt) {
    if (val.indexOf("%") !== -1) {
        var pds = val.split("%");
        return formatDecimal((parseFloat(((amt) * parseFloat(pds[0])) / 100)), 4);
    }
    return formatDecimal(val);
}

$(document).ready(function() {
    $('#view-customer').click(function(){
        $('#myModal').modal({remote: site.base_url + 'customers/view/' + $("input[name=customer]").val()});
        $('#myModal').modal('show');
    });
    $('#view-supplier').click(function(){
        $('#myModal').modal({remote: site.base_url + 'suppliers/view/' + $("input[name=supplier]").val()});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.customer_details_link td:not(:first-child, :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'customers/view/' + $(this).parent('.customer_details_link').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.supplier_details_link td:not(:first-child, :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'suppliers/view/' + $(this).parent('.supplier_details_link').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.product_link td:not(:first-child, :nth-child(2), :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'products/modal_view/' + $(this).parent('.product_link').attr('id')});
        $('#myModal').modal('show');
        //window.location.href = site.base_url + 'products/view/' + $(this).parent('.product_link').attr('id');
    });
    $('body').on('click', '.product_link2 td:first-child, .product_link2 td:nth-child(2)', function() {
        $('#myModal').modal({remote: site.base_url + 'products/modal_view/' + $(this).closest('tr').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.purchase_link td:not(:first-child, :nth-child(5), :nth-last-child(2), :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'purchases/modal_view/' + $(this).parent('.purchase_link').attr('id')});
        $('#myModal').modal('show');
        //window.location.href = site.base_url + 'purchases/view/' + $(this).parent('.purchase_link').attr('id');
    });
    $('body').on('click', '.purchase_link2 td', function() {
        $('#myModal').modal({remote: site.base_url + 'purchases/modal_view/' + $(this).closest('tr').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.transfer_link td:not(:first-child, :nth-last-child(3), :nth-last-child(2), :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'transfers/view/' + $(this).parent('.transfer_link').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.transfer_link2', function() {
        $('#myModal').modal({remote: site.base_url + 'transfers/view/' + $(this).attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.invoice_link td:not(:first-child, :nth-child(6), :nth-last-child(2), :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'sales/modal_view/' + $(this).parent('.invoice_link').attr('id')});
        $('#myModal').modal('show');
        //window.location.href = site.base_url + 'sales/view/' + $(this).parent('.invoice_link').attr('id');
    });
    $('body').on('click', '.invoice_link2 td:not(:first-child, :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'sales/modal_view/' + $(this).closest('tr').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.receipt_link td:not(:first-child, :last-child)', function() {
        $('#myModal').modal({ remote: site.base_url + 'pos/view/' + $(this).parent('.receipt_link').attr('id') + '/1' });
    });
    $('body').on('click', '.return_link td', function() {
        // window.location.href = site.base_url + 'sales/view_return/' + $(this).parent('.return_link').attr('id');
        $('#myModal').modal({remote: site.base_url + 'sales/view_return/' + $(this).parent('.return_link').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.return_purchase_link td', function() {
        $('#myModal').modal({remote: site.base_url + 'purchases/view_return/' + $(this).parent('.return_purchase_link').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.payment_link td', function() {
        $('#myModal').modal({remote: site.base_url + 'sales/payment_note/' + $(this).parent('.payment_link').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.payment_link2 td', function() {
        $('#myModal').modal({remote: site.base_url + 'purchases/payment_note/' + $(this).parent('.payment_link2').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.expense_link2 td:not(:last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'purchases/expense_note/' + $(this).closest('tr').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.quote_link td:not(:first-child, :nth-last-child(3), :nth-last-child(2), :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'quotes/modal_view/' + $(this).parent('.quote_link').attr('id')});
        $('#myModal').modal('show');
        //window.location.href = site.base_url + 'quotes/view/' + $(this).parent('.quote_link').attr('id');
    });
    $('body').on('click', '.purchases_order_link td:not(:first-child, :nth-last-child(3), :nth-last-child(2), :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'purchases_order/modal_view/' + $(this).parent('.purchases_order_link').attr('id')});
        $('#myModal').modal('show');
        //window.location.href = site.base_url + 'purchases_order/view/' + $(this).parent('.purchases_order_link').attr('id');
    });

    $('body').on('click', '.quote_link2', function() {
        $('#myModal').modal({remote: site.base_url + 'quotes/modal_view/' + $(this).attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.delivery_link td:not(:first-child, :nth-last-child(2), :nth-last-child(3), :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'sales/view_delivery/' + $(this).parent('.delivery_link').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.customer_link td:not(:first-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'customers/edit/' + $(this).parent('.customer_link').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.supplier_link td:not(:first-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'suppliers/edit/' + $(this).parent('.supplier_link').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.adjustment_link td:not(:first-child, :nth-last-child(2), :last-child)', function() {
        $('#myModal').modal({remote: site.base_url + 'products/view_adjustment/' + $(this).parent('.adjustment_link').attr('id')});
        $('#myModal').modal('show');
    });
    $('body').on('click', '.adjustment_link2', function() {
        $('#myModal').modal({remote: site.base_url + 'products/view_adjustment/' + $(this).attr('id')});
        $('#myModal').modal('show');
    });
    $('#clearLS').click(function(event) {
        bootbox.confirm(lang.r_u_sure, function(result) {
        if(result == true) {
            localStorage.clear();
            location.reload();
        }
        });
        return false;
    });
    $(document).on('click', '[data-toggle="ajax"]', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        $.get(href, function( data ) {
            $("#myModal").html(data).modal();
        });
    });
    $(".sortable_rows").sortable({
        items: "> tr",
        appendTo: "parent",
        helper: "clone",
        placeholder: "ui-sort-placeholder",
        axis: "x",
        update: function(event, ui) {
            var item_id = $(ui.item).attr('data-item-id');
            console.log(ui.item.index());
        }
    }).disableSelection();
});

function fixAddItemnTotals() {
    var ai = $("#sticker");
    var aiTop = (ai.position().top)+250;
    var bt = $("#bottom-total");
    $(window).scroll(function() {
        var windowpos = $(window).scrollTop();
        if (windowpos >= aiTop) {
            ai.addClass("stick").css('width', ai.parent('form').width()).css('zIndex', 2);
            if ($.cookie('sma_theme_fixed') == 'yes') { ai.css('top', '40px'); } else { ai.css('top', 0); }
            //$('#add_item').removeClass('input-lg');
            $('.addIcon').removeClass('fa-2x');
        } else {
            ai.removeClass("stick").css('width', bt.parent('form').width()).css('zIndex', 2);
            if ($.cookie('sma_theme_fixed') == 'yes') { ai.css('top', 0); }
            //$('#add_item').addClass('input-lg');
            $('.addIcon').addClass('fa-2x');
        }
        if (windowpos <= ($(document).height() - $(window).height() - 120)) {
            bt.css('position', 'fixed').css('bottom', 0).css('width', bt.parent('form').width()).css('zIndex', 2);
        } else {
            bt.css('position', 'static').css('width', ai.parent('form').width()).css('zIndex', 2);
        }
    });
}

function ItemnTotals() {
    fixAddItemnTotals();
    $(window).bind("resize", fixAddItemnTotals);
}

function getSlug(title, type) {
    var slug_url = site.base_url+'welcome/slug';
    $.get(slug_url, {title: title, type: type}, function (slug) {
        $('#slug').val(slug).change();
    });
}

function openImg(img) {
    var imgwindow = window.open('', 'sma_pos_img');
    imgwindow.document.write('<html><head><title>Screenshot</title>');
    imgwindow.document.write('<link rel="stylesheet" href="'+site.assets+'styles/helpers/bootstrap.min.css" type="text/css" />');
    imgwindow.document.write('</head><body style="display:flex;align-items:center;justify-content:center;">');
    imgwindow.document.write('<img src="'+img+'" class="img-thumbnail"/>');
    imgwindow.document.write('</body></html>');
    return true;
}

if(site.settings.auto_detect_barcode == 1) {
    $(document).ready(function() {
        var pressed = false;
        var chars = [];
        $(window).keypress(function(e) {
            chars.push(String.fromCharCode(e.which));
            if (pressed == false) {
                setTimeout(function(){
                    if (chars.length >= 8) {
                        var barcode = chars.join("");
                        $( "#add_item" ).focus().autocomplete( "search", barcode );
                    }
                    chars = [];
                    pressed = false;
                },200);
            }
            pressed = true;
        });
    });
}
$('.sortable_table tbody').sortable({
    containerSelector: 'tr'
});
$(window).bind("resize", widthFunctions);
$(window).load(widthFunctions);

$(document).ready(function() {
    $("#suggest_recipe").autocomplete({
        source: site.base_url+'reports/recipesearch',
        select: function (event, ui) {
            $('#report_recipe_id').val(ui.item.id);
        },
        minLength: 1,
        autoFocus: false,
        delay: 250,
        response: function (event, ui) {

            if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).val(ui.item.label);
                $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');
            }
        },
    });

    $(document).on('blur', '#suggest_recipe', function(e) {
        
        if (! $(this).val()) {
            $('#report_recipe_id').val('');
        }
    });
});
$(document).ready(function() {
 $('[data-target=#myModal]').attr('data-backdrop',"static");
 
});
 function cus_discount_status(x) {
    var y = x.split("__");
    return y[0] == 1 ?
    '<a href="'+site.base_url+'system_settings/customer_discount_deactivate/'+ y[1] +'"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>' :
    '<a href="'+site.base_url+'system_settings/customer_discount_activate/'+ y[1] +'"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
}
 function discount_status(x) {
    var y = x.split("__");
    return y[0] == 1 ?
    '<a href="'+site.base_url+'system_settings/discount_deactivate/'+ y[1] +'"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>' :
    '<a href="'+site.base_url+'system_settings/discount_activate/'+ y[1] +'"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
}

 function bbq_discount_status(x) {
    var y = x.split("__");
    return y[0] == 1 ?
    '<a href="'+site.base_url+'system_settings/bbq_discount_deactivate/'+ y[1] +'"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>' :
    '<a href="'+site.base_url+'system_settings/bbq_discount_activate/'+ y[1] +'"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
}

function loyalty_status(x) {
    var y = x.split("__");
    return y[0] == 1 ?
    '<a href="'+site.base_url+'loyalty_settings/deactivate/'+ y[1] +'" data-toggle="modal" data-target="#myModal"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>' :
    '<a href="'+site.base_url+'loyalty_settings/activate/'+ y[1] +'"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
}


function loyalty_card_status(x) {
    var y = x.split("__");
    
    if(y[0] == 1) {//btn-warning
        return '<a href="'+site.base_url+'loyalty_settings/card_deactivate/'+ y[1] +'" data-toggle="modal" data-target="#myModal"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>';
    } else if(y[0] == 0) {
        return '<a href="'+site.base_url+'loyalty_settings/card_activate/'+ y[1] +'"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
    } else if(y[0] == 2) {
        return '<div class="text-center"><span class="payment_status label label-warning">Issued</span></div>';
    }else {
        return '<div class="text-center"><span class="payment_status label label-primary">Expired</span></div>';
    }
}

function payment_method_status(x) {
    var y = x.split("__");
    return y[0] == 1 ?
    '<a href="'+site.base_url+'system_settings/payment_method_deactivate/'+ y[1] +'"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>' :
    '<a href="'+site.base_url+'system_settings/payment_method_activate/'+ y[1] +'"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
}

function change_shift_time_status(x) {
    var y = x.split("__");
    return y[0] == 1 ?
    '<a href="'+site.base_url+'system_settings/shift_time_deactivate/'+ y[1] +'"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>' :
    '<a href="'+site.base_url+'system_settings/shift_time_activate/'+ y[1] +'"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
}

function recipe_gategory_status(x) {
    var y = x.split("__");
    return y[0] == 1 ?
    '<a href="'+site.base_url+'system_settings/recipe_gategory_deactivate/'+ y[1] +'"><span class="label label-success"><i class="fa fa-check"></i> '+lang['active']+'</span></a>' :
    '<a href="'+site.base_url+'system_settings/recipe_gategory_activate/'+ y[1] +'"><span class="label label-danger"><i class="fa fa-times"></i> '+lang['inactive']+'</span><a/>';
}

$(document).ready(function() {
 $('[data-target=#myModal]').attr('data-backdrop',"static");

    $('.search-varients').select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"recipe/search_varients",
        dataType: 'json',
    type:'post',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
        existing:$existingVarients
            };
        },
        results: function (data, page) {
        console.log(data)
            if(data != null) {
        $results = []
        $.each(data,function(n,v){
             $results[n] = {};
             $results[n]['id'] = v.id
             $results[n]['text'] = v.name
        })
        console.log($results)
                return {results: $results};
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        }
    }
  }).on('change', function (v) {
    $lable = v.added.text;
    $id = v.added.id;
    //if($existingVarients.indexOf($id)!=-1){
    //    alert('already exist');
    //    return false;
    //}
    $('.search-varients').select2("val", "");
    $existingVarients.push($id);
        $html = '<tr class="each-varient">';
        $html +='<td  class="col-sm-4"><input class="form-control" type="text" value="'+$lable+'" disabled>';
        $html +='<input class="form-control" type="hidden" name="varients[id][]" value="'+$id+'">';
        $html +='<input class="form-control" type="hidden" name="varients[val_id][]" value=""></td>';
        $html +='<td  class="col-sm-4"><input class="form-control" type="text" name="varients[price][]" value=""></td>';
        $html +='<td  class="col-sm-2"><input id="varients_file" type="file"  name="varients_file[]" style="display:none">';
        $html +='<input type="checkbox" name="varients[status][]" checked value="1"></td>';
        $html +='<td class="col-sm-2"><a href="" data-id="" data-vid="'+$id+'" class="btn btn-primary btn-xs remove-variant"><i class="fa fa-trash-o"></i></a></td>'
        $html +='<td  class="col-sm-2"><input type="radio" name="varients[preferred][]"  class="varient_preferred" data-vid="'+$id+'"  value="'+$id+'"></td>';        
        $html +='</tr>';
        $('.varients-container tbody').prepend($html);
         $('.varients-container tbody tr:first input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
        });
         $('.varients-container tbody tr:first input[type="radio"]').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
        });
        $('.search-varients').val();
    });
  
  $(document).on('ifChanged','.varient_preferred',function(e){ 
    $obj = $(this);
    $('.peferred').val('');
    $id = $obj.attr('data-vid');
    /*$('.varient_preferred').removeAttr('checked').iCheck('update');
    $('.varient_preferred').iCheck('checked');*/
    // alert($id);
    $('.varient_preferred').val($id);
  });
  
    $(document).on('click','.remove-variant',function(e){        
    e.preventDefault();
    $obj = $(this);
    $id = $obj.attr('data-id');
    $vid = $obj.attr('data-vid');
    //console.log($vid)
    //console.log($existingVarients);//return false;
    if ($id!='') {
        $.ajax({
        type: "get", async: false,
        url: site.base_url+'recipe/deleteRecipeVariant/'+$id,
        dataType: "json",
        success: function (data) {
            if (data.status=="success") {
            $obj.closest('tr').remove();
                alert('Removed');           
            
            }
            
        }
        })
    }else{
        $obj.closest('tr').remove();
        alert('Removed');
    }
    var index = $existingVarients.indexOf($vid);
            //console.log('i'+index)
        if (index > -1) {
          $existingVarients.splice(index, 1);
        }//console.log($existingVarients)
    });
    
    
    $('.search-purchase-items').select2({
       minimumInputLength: 1,
       ajax: {
        url: site.base_url+"recipe/search_purchase_items",
        dataType: 'json',
    type:'post',
        quietMillis: 15,
        data: function (term, page) {
            return {
                term: term,
        existing:$existing_purchase_items,
        item_type:$('#type').val()
            };
        },
        results: function (data, page) {
        console.log(data)
            if(data != null) {
        $results = []
        $.each(data,function(n,v){
             $results[n] = {};
             $results[n]['id'] = v.id
	     $results[n]['cm_id'] = v.cm_id
	     $results[n]['cate_name'] = v.category_name
	     $results[n]['sub_cat_name'] = v.subcategory_name
	     $results[n]['brand_name'] = v.brand_name
             $results[n]['html'] = v.name +' <strong>Cat</strong> -'+v.category_name+' | <strong>Sub</strong> -'+v.subcategory_name+' | <strong>Brand</strong> -'+v.brand_name;
	     
	     
	     $results[n]['text'] = v.name +' Cat-'+v.category_name+' | Sub-'+v.subcategory_name+' | Brand-'+v.brand_name;
             $results[n]['unit'] = v.unit;
             $results[n]['cost'] = v.cost;
	     $results[n]['unit_id'] = v.unit_id;
        })
        console.log($results)
                return {results: $results};
            } else {
                return { results: [{id: '', text: 'No Match Found'}]};
            }
        },
	
    },
    formatResult: function (i) {return '<div>'+i.html+'</div>';},
    formatSelection: function (i) {return '<div>'+i.text+'</div>'; },
  }).on('change', function (v) {
    $lable = v.added.text;
    $pid = v.added.id;
    $cm_id = v.added.cm_id;
    $uniqid = $pid+'-'+$cm_id;
    $unit = v.added.unit;
    $cost = v.added.cost;
    $unitid = v.added.unit_id;
    $('.search-purchase-items').select2("val", "");
    $existing_purchase_items.push($uniqid);
        $html = '<tr class="each-purchase-item">';
        $html +='<td  class="col-sm-4"><input class="form-control" type="text" value="'+$lable+'" disabled>';
        $html +='<input class="form-control" type="hidden" name="purchase_item[id][]" value="'+$pid+'"><input class="form-control" type="hidden" name="purchase_item[cm_id][]" value="'+$cm_id+'"></td>';
        $html +='<td  class="col-sm-2"><input class="p-item-quantity form-control" type="text" name="purchase_item[quantity][]" value=""></td>';
	$html +='<td  class="col-sm-2"><input class="form-control" type="hidden" name="purchase_item[unit_id][]" value="'+$unitid+'"><input readonly="readonly" class="p-item-unit form-control" type="test" name="purchase_item[unit][]" value="'+$unit+'"></td>';
        //$html +='<td  class="col-sm-2"><input class="p-item-cost form-control" type="hidden" name="purchase_item[cost][]" value="'+$cost+'"><input class="p-item-price form-control" type="text" name="purchase_item[price][]" value=""></td>';
       
        $html +='<td class="col-sm-2"><a href="" data-id="" data-vid="'+$pid+'" class="btn btn-primary btn-xs remove-purchase-item"><i class="fa fa-trash-o"></i></a></td>'
        $html +='</tr>';
        $('.purchase-item-container tbody').prepend($html);
         $('.purchase-item-container tbody tr:first input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
        });
        $('.search-purchase-items').val();
    });
    
    $(document).on('click','.remove-purchase-item',function(e){
    e.preventDefault();
    $obj = $(this);
    $id = $obj.attr('data-id');
   
   
    if ($id!='') {
        $.ajax({
        type: "get", async: false,
        url: site.base_url+'recipe/delete_purchase_item/'+$id,
        dataType: "json",
        success: function (data) {
            if (data.status=="success") {
            $obj.closest('tr').remove();
                alert('Removed');           
            
            }
            
        }
        })
    }else{
        $obj.closest('tr').remove();
        alert('Removed');
    }
    var index = $existing_purchase_items.indexOf($uniqid);
        if (index > -1) {
          $existing_purchase_items.splice(index, 1);
        }
    });
//    $(document).on('keyup','.p-item-quantity',function(){
//	$obj = $(this);
//	$q = $obj.val();
//	$c = $obj.closest('.each-purchase-item').find('.p-item-cost').val();
//	$p = $c*$q;
//	$obj.closest('.each-purchase-item').find('.p-item-price').val($p);
//    });
});
 $(function() {
	 var d = new Date();
   var dateFormat = "mm/dd/yy",
     from = $("#construction_begin_date")
     .datepicker({
       defaultDate:d,
       changeMonth: true,
       changeYear: true,
       numberOfMonths: 1,
     })
   .on('change', function(ev) {
	   to.datepicker("option", "minDate", getDate(this));
    if($('#construction_begin_date').valid()){
       $('#construction_begin_date').removeClass('invalid').addClass('success');   
       $('.date_pick').removeClass('has-error').addClass('has-success');   
       $('.date_pick .help-block').css({'display':'none'});   
    }
 }),
//     .on("change", function() {
//       
//     }),
     to = $("#construction_end_date").datepicker({
       defaultDate: d,
       changeMonth: true,
       changeYear: true,
       numberOfMonths: 1
     })
   .on('change', function(ev) {
	   from.datepicker("option", "maxDate", getDate(this));
    if($('#construction_end_date').valid()){
       $('#construction_end_date').removeClass('invalid').addClass('success');   
       $('.date_pick_2').removeClass('has-error').addClass('has-success');   
       $('.date_pick_2 .help-block').css({'display':'none'});   
    }
 });
//     .on("change", function() {
//       
//     });

   function getDate(element) {
     var date;
     try {
       date = $.datepicker.parseDate(dateFormat, element.value);
     } catch (error) {
       date = null;
     }

     return date;
   }
   
	 
	  $("#date_formthree").datepicker({
       defaultDate:d,
       changeMonth: true,
       changeYear: true,
       numberOfMonths: 1,
     })
 });

$(function() {
    $( "#construction_begin_date" ).datepicker({
        onSelect: function(){
            $('form[class="add_from"]').bootstrapValidator('revalidateField', 'date');
        }
    });
});

  
 $('#phone_number,#total_land_size,#total_land_size_for_building_oven,#underground_water_level_during_dry_season,#loan_size,#bank_amount,#no_of_pets,#daily_amount_of_stool,#phone').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
  });

/*$("#daily_amount_of_stool").inputFilter(function(value) {
  return /^\d*$/.test(value); });*/

$(document).ready(function() {
   $('#phone_number').attr({ maxLength : 10 });
});
$(document).ready(function() {
   $('#phone').attr('maxlength', 10);
});
function limitText(field, maxChar){
    var ref = $(field),
        val = ref.val();
    if ( val.length >= maxChar ){
        ref.val(function() {
            console.log(val.substr(0, maxChar))
            return val.substr(0, maxChar);       
        });
    }
}

//$(document).ready(function() {
//    $('.add_from').find('input[name="raining_season"]')
//            // Init iCheck elements
//            .iCheck({
//                checkboxClass: 'icheckbox_square-blue',
//                radioClass: 'iradio_square-blue'
//            })
//            // Called when the radios/checkboxes are changed
//            .on('ifChanged', function(e) {
//                // Get the field name
//                var field = $(this).attr('name');
//                $('.add_from').bootstrapValidator('revalidateField', field);
//            });
//});
$(document).ready(function() {
			$('.minus').click(function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 0 ? 0 : count;
				$input.val(count);
				$input.change();
				return false;
			});
			$('.plus').click(function () {
				var $input = $(this).parent().find('input');
				$input.val(parseInt($input.val()) + 1);
				$input.change();
				return false;
			});
		});
$(document).ready(function(){ 
            $("#survey_date").keyup(function(e){
                if (e.keyCode != 8){   
                    if ($(this).val().length == 2){
                        $(this).val($(this).val() + "-");
                    }else if ($(this).val().length == 5){
                        $(this).val($(this).val() + "-");
                    }
                }
            });   
});