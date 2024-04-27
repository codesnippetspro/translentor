
<!-- Main Page  -->
<form method="post" >
    <h2>Modules</h2>
    <div class="form-table">
   
            <div class="translentor_table_row">
                <th scope="row"><label>Translentor</label></th>
                
                <label class="switch">
                <input name="translentor" id='translentor' type="checkbox"
                    value=<?php echo get_option('translentor')=='yes'?'yes':'no'; ?>>
                <span class="slider"></span>
            </label>
              
            </div>
            <div class="translentor_table_row">
                <th scope="row"><label>Woomentor Currency</label></th>
  
                <label class="switch">
                <input name="woomentorcurrency" id='woomentorcurrency' type="checkbox"
                    value=<?php echo get_option('woomentorcurrency')=='yes'?'yes':'no'; ?>>
                <span class="slider"></span>
            </label>
              
            </div>
            <div class="translentor_table_row">
                <th scope="row"><label>Text Highlight</label></th>
            
                <label class="switch">
                <input name="texthightlight" id='texthightlight' type="checkbox"
                    value=<?php echo get_option('texthightlight')=='yes'?'yes':'no'; ?>>
                <span class="slider"></span>
            </label>
             
            </div>
            <div class="translentor_table_row">
                <th scope="row"><label>Icon Stroke</label></th>
           
                <label class="switch">
                <input name="iconstroke" id='iconstroke' type="checkbox"
                    value=<?php echo get_option('iconstroke')=='yes'?'yes':'no'; ?>>
                <span class="slider"></span>
            </label>
              
            </div>

            <div class="translentor_table_row">
                <th scope="row"><label>Clickable Column Extension</label></th>
           
                <label class="switch">
                <input name="clickablecolumn" id='clickablecolumn' type="checkbox"
                    value=<?php echo get_option('clickablecolumn')=='yes'?'yes':'no'; ?>>
                <span class="slider"></span>
            </label>
              
            </div>
       
            <div class="translentor_table_row">
                <th scope="row"><label>Gradient Button</label></th>
           
                <label class="switch">
                <input name="gradientbutton" id='gradientbutton' type="checkbox"
                    value=<?php echo get_option('gradientbutton')=='yes'?'yes':'no'; ?>>
                <span class="slider"></span>
            </label>
              
            </div>

    </div>
    <div class="sm-submit-button" style="padding-left: 10px">
        <?php submit_button(); ?>
    </div>
</form>
<?php


if(isset($_POST['submit']))
{
   

    if(isset($_POST['translentor']))
    {
     update_option('translentor','yes');
     
    }else{
      update_option('translentor','no');
     
    }
  
    if(isset($_POST['woomentorcurrency']))
    {
     update_option('woomentorcurrency','yes');
    }else{
      update_option('woomentorcurrency','no');
    }
  
    if(isset($_POST['texthightlight']))
    {
     update_option('texthightlight','yes');
    }else{
      update_option('texthightlight','no');
    }
    if(isset($_POST['iconstroke']))
    {
      update_option('iconstroke','yes');
    }else{
      update_option('iconstroke','no');
    }
    if(isset($_POST['clickablecolumn']))
    {
      update_option('clickablecolumn','yes');
    }else{
      update_option('clickablecolumn','no');
    }
    if(isset($_POST['gradientbutton']))
    {
      update_option('gradientbutton','yes');
    }else{
      update_option('gradientbutton','no');
    }
    if (class_exists( 'WooCommerce' )){
        update_option('WooCommerce_active','yes');
    }else{
        update_option('WooCommerce_active','no');
        update_option('woomentorcurrency','no');
    }
}

?>
<script>
    jQuery(document).ready(function() {

    var translentor = "<?php echo  get_option('translentor'); ?>";
    var woomentorcurrency = "<?php echo  get_option('woomentorcurrency'); ?>";
    var WooCommerce_active="<?php echo get_option('WooCommerce_active') ?>";
    var texthightlight = "<?php echo  get_option('texthightlight'); ?>";
    var iconstroke="<?php echo  get_option('iconstroke'); ?>";
    var clickablecolumn="<?php echo get_option('clickablecolumn'); ?>";
    var gradientbutton="<?php echo get_option('gradientbutton'); ?>";
    console.log(translentor);
    console.log(woomentorcurrency);
    console.log(texthightlight);
    console.log(iconstroke);
    console.log(clickablecolumn);
    console.log(gradientbutton);
    if (translentor === 'yes') {
        jQuery("#translentor").attr('checked', 'checked');
    } 

    if (woomentorcurrency === 'yes' && WooCommerce_active=='yes') {
        jQuery("#woomentorcurrency").attr('checked', 'checked');
    
    }  if (texthightlight === 'yes') {
        jQuery("#texthightlight").attr('checked', 'checked');
       
    } 
     if (iconstroke === 'yes') {
        jQuery("#iconstroke").attr('checked', 'checked');
       
    } 
    
 if(clickablecolumn=='yes')
 {
    jQuery("#clickablecolumn").attr('checked','checked');
 }
if(gradientbutton=='yes')
{
    jQuery('#gradientbutton').attr('checked','checked');
}
});
    </script>