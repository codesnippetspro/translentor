"use strict";

function translentor_currency_recalculate_all_orders_data() {
    if (confirm('This operation could not be back')) {
        jQuery('.translentor_currency_recalculate_all_orders_curr_button').prop('href', 'javascript:void(0);');

        var data_count = {
            action: "translentor_currency_all_order_ids"
        };
        jQuery('.translentor_currency_ajax_preload').show();
        jQuery.post(ajaxurl, data_count, function (ids) {

            var orders = JSON.parse(ids);
            if (orders.length) {
                translentor_currency_recalculate_all_orders_data_do(0, orders);
            }
        });

    }
}
function translentor_currency_recalculate_all_orders_data_do(start, orders) {
    var count_orders = orders.length;
    var step = 10;
    var orders_ids = orders.slice(start, start + step);
    jQuery.ajax({
        method: "POST",
        url: ajaxurl,
        data: {
            action: 'translentor_currency_recalculate_orders_data',
            order_ids: orders_ids
        },
        success: function (dat) {
            if ((start + step) > count_orders) {
                jQuery('.translentor_currency_ajax_preload').hide();
                alert("Finish");
                window.location.reload();
            } else {
                translentor_currency_recalculate_all_orders_data_do(start + step, orders)
            }
        },
        error: function () {
            alert("Something wrong!");
        }
    });

}


