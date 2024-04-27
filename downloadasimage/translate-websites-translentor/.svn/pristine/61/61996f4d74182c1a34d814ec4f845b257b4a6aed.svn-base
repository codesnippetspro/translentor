"use strict";
var translentor_currency_old_currency = null;
function translentor_currency_change_order_data() {
    translentor_currency_old_currency = jQuery('#translentor_currency_order_metabox .translentor_currency_order_currency i').html();
    jQuery('#translentor_currency_order_metabox .translentor_currency_order_currency select').show();
    jQuery('#translentor_currency_order_metabox .translentor_currency_order_currency select').attr('name', 'translentor_currency_order_currency');
    jQuery('#translentor_currency_order_metabox .translentor_currency_order_currency select').val(translentor_currency_old_currency);
    jQuery('.translentor_currency_change_order_curr_button').hide();
    jQuery('.translentor_currency_cancel_order_curr_button').show();
    jQuery('.translentor_currency_recalculate_order_curr_button').show();
}

function translentor_currency_cancel_order_data() {
    jQuery('#translentor_currency_order_metabox .translentor_currency_order_currency select').hide();
    jQuery('#translentor_currency_order_metabox .translentor_currency_order_currency select').attr('name', 'translentor_currency_order_currency2');
    jQuery('.translentor_currency_change_order_curr_button').show();
    jQuery('.translentor_currency_cancel_order_curr_button').hide();
    jQuery('.translentor_currency_recalculate_order_curr_button').hide();
}

function translentor_currency_recalculate_order_data() {
    if (confirm('Are you sure?')) {
        var id = jQuery(".translentor_currency_recalculate_order_curr_button").data('order_id');
        jQuery('.translentor_currency_recalculate_order_curr_button').prop('href', 'javascript:void(0);');
        var data = {
            action: "translentor_currency_recalculate_order_data",
            selected_currency: jQuery("select[name='translentor_currency_order_currency']").val(),
            order_id: id
        };

        jQuery.post(ajaxurl, data, function (data) {
            window.location.reload();
        });
    }
}


