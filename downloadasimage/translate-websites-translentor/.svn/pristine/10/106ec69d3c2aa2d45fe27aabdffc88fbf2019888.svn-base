"use strict";
jQuery(function ($) {
    $('.translentor_currency_multiple_simple_panel').show(200);

    $('body').on('change', '.translentor_currency_price_col .wc_input_price, .chosen_select', function () {
        translentor_currency_enable_save_variation_changes();
    });
    
});

//https://www.w3schools.com/w3css/w3css_tabulators.asp
function translentor_currency_open_tab(tabName, hash) {
    var i = 0;
    var x = document.getElementsByClassName("translentor_currency_tab");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(tabName + '_' + hash).style.display = "block";

    //***
    jQuery('.translentor_currency_tab_button').removeClass('active');
    jQuery('#' + tabName + '_btn_' + hash).addClass('active');
}

//***

function translentor_currency_add_product_price(post_id, hash) {
    var code = jQuery('#translentor_currency_mselect_' + hash).val();
    if (code) {
        var html = jQuery('#translentor_currency_multiple_simple_tpl').html();
        html = html.replace(/__POST_ID__/gi, post_id);
        html = html.replace(/__HASH__/gi, hash);
        html = html.replace(/__CURR_CODE__/gi, code);
        jQuery('#translentor_currency_mlist_' + hash).append(html);
        //***
        jQuery("#translentor_currency_mselect_" + hash + " option[value='" + code + "']").remove();
        jQuery("#translentor_currency_mselect_" + hash + " option").eq(0).prop('selected', 'selected');
    }
    translentor_currency_enable_save_variation_changes();
}

function translentor_currency_add_all_product_price(post_id, hash) {
    jQuery.each(jQuery("#translentor_currency_mselect_" + hash + " option"), function (i, code) {
        jQuery("#translentor_currency_mselect_" + hash + " option[value='" + code + "']").prop('selected', 'selected');
        translentor_currency_add_product_price(post_id, hash);
    });
}
function translentor_currency_add_fixed_field(post_id, selector, hash) {
    var code = jQuery('#translentor_currency_multiple_simple_select_' + selector + '_' + hash).val();

    if (code) {
        var html = jQuery('#translentor_currency_multiple_simple_tpl_' + selector).html();
        html = html.replace(/__POST_ID__/gi, post_id);
        html = html.replace(/__HASH__/gi, hash);
        html = html.replace(/__CURR_CODE__/gi, code);
        jQuery('#translentor_currency_multiple_simple_list_' + selector + '_' + hash).append(html);
        //***
        jQuery("#translentor_currency_multiple_simple_select_" + selector + '_' + hash + " option[value='" + code + "']").remove();
        jQuery("#translentor_currency_multiple_simple_select_" + selector + '_' + hash + " option").eq(0).prop('selected', 'selected');
    }
    translentor_currency_enable_save_variation_changes();
}

function translentor_currency_add_all_fixed_field(post_id, selector, hash) {
    jQuery.each(jQuery("#translentor_currency_multiple_simple_select_" + selector + "_" + hash + " option"), function (i, code) {
        jQuery("#translentor_currency_multiple_simple_select_" + selector + "_" + hash + " option[value='" + code + "']").prop('selected', 'selected');
        translentor_currency_add_fixed_field(post_id, selector, hash);
    });
}

function translentor_currency_add_select_product_price(hash, code) {
    jQuery('#translentor_currency_mselect_' + hash).append('<option value="' + code + '">' + code + '</option>');
}
function translentor_currency_add_select_fixed_field(hash, code, selector) {
    jQuery('#translentor_currency_mselect_' + selector + '_' + hash).append('<option value="' + code + '">' + code + '</option>');
}

function translentor_currency_remove_li_product_price(hash, code, geo) {
    if (geo) {
        //code is time here
        jQuery('#translentor_currency_li_geo_' + hash + '_' + code).remove();
    } else {
        jQuery('#translentor_currency_li_' + hash + '_' + code).remove();
    }

    translentor_currency_add_select_product_price(hash, code);
    translentor_currency_enable_save_variation_changes();
}
function translentor_currency_remove_li_fixed_field(hash, code, geo, selector) {

    if (geo) {
        //code is time here
        jQuery('#translentor_currency_mlist_geo_' + selector + '_' + hash + ' #translentor_currency_li_geo_' + hash + '_' + code).remove();
    } else {
        jQuery('#translentor_currency_multiple_simple_list_' + selector + '_' + hash + ' #translentor_currency_li_' + hash + '_' + code).remove();
    }

    translentor_currency_add_select_fixed_field(hash, code, selector);
    translentor_currency_enable_save_variation_changes();
}

function translentor_currency_enable_save_variation_changes() {
    //jQuery('.save-variation-changes').removeAttr('disabled');
    jQuery('.form-row textarea').trigger('change');
}

/**************************************/

function translentor_currency_add_group_geo(post_id, hash) {
    var html = jQuery('#translentor_currency_multiple_simple_tpl_geo').html();
    html = html.replace(/__POST_ID__/gi, post_id);
    html = html.replace(/__HASH__/gi, hash);
    var d = new Date();
    var index = d.getTime();
    html = html.replace(/__INDEX__/gi, index);
    jQuery('#translentor_currency_mlist_geo_' + hash).append(html);
    jQuery('#translentor_currency_li_geo_' + hash + '_' + index + ' .translentor_currency_country_select').chosen();
    jQuery('#translentor_currency_li_geo_' + hash + '_' + index + ' .translentor_currency_country_select').trigger("chosen:updated");
    //***
    translentor_currency_enable_save_variation_changes();
}

function translentor_currency_add_group_user_role(post_id, hash) {
    var html = jQuery('#translentor_currency_multiple_simple_tpl_user_role').html();
    html = html.replace(/__POST_ID__/gi, post_id);
    html = html.replace(/__HASH__/gi, hash);
    var d = new Date();
    var index = d.getTime();
    html = html.replace(/__INDEX__/gi, index);
    jQuery('#translentor_currency_mlist_user_role_' + hash).append(html);
    jQuery('#translentor_currency_li_user_role_' + hash + '_' + index + ' select').chosen();
    jQuery('#translentor_currency_li_user_role_' + hash + '_' + index + ' select').trigger("liszt:updated");
    //***
    translentor_currency_enable_save_variation_changes();
}
function translentor_currency_remove_li_user_role_price(hash, code) {

    jQuery('#translentor_currency_li_user_role_' + hash + '_' + code).remove();

    translentor_currency_add_select_product_price(hash, code);
    translentor_currency_enable_save_variation_changes();
}
function translentor_currency_set_geoip_profile(id) {

    var data = jQuery('#' + id).find('.translentor_currency_geoip_profile').val();
    if (data = JSON.parse(data)) {
        jQuery('#' + id).find('select.translentor_currency_country_select').val(data);

        jQuery('#' + id).find('select.translentor_currency_country_select').trigger('change');
        jQuery('#' + id).find('select.translentor_currency_country_select').trigger("chosen:updated");

    }

}