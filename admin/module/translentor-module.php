<div class="header">
    <div class="logo">
        <img src="http://home-run.co.uk/wp-content/uploads/2023/07/logo.png" alt="Logo">
    </div>
    <div class="tabs">
        <div class="tab active" data-tab="tab1">Dashboard</div>
        <div class="tab" data-tab="tab2">General</div>
        <div class="tab" data-tab="tab3">Translentor</div>
        <div class="tab" data-tab="tab4">Widgets</div>
        <div class="tab" data-tab="tab5">Extensions</div>
    </div>
</div>
<div class="tab-content active" id="tab1">
    <div class="dashboard">
        <div class="all-widgets-section">
            <h2 class="dashboard-title">Widgets</h2>
            <div class="all-widgets-wrap">
                <aside class="chart vert">
                    <canvas id="widgetscanPie" width="300" height="200" data-values='10, 2, 100'>
                    </canvas>
                    <ol class="legend">
                        <li class="key one">Used</li>
                        <li class="key two">UnUsed</li>


                    </ol>
                </aside>
            </div>
        </div>
        <div class="active-progress-section">
            <h2 class="dashboard-title">Extensions</h2>
            <div class="active-progress-wrap">
                <aside class="chart vert">
                    <canvas id="activecanPie" width="300" height="200" data-values='10, 2, 100'>
                    </canvas>
                    <ol class="legend">
                        <li class="key one">Active</li>
                        <li class="key two">Unactive</li>


                    </ol>
                </aside>
            </div>
        </div>
        <div class="system-requirment-section">
            <h2 class="dashboard-title">System Requirement</h2>
            <?php AdminSettings::translentor_system_requirement() ?>
        </div>
        <div class="change-log-section">
            <h2 class="dashboard-title">Change Log</h2>
            <?php 
        $myfile = fopen(translentor_DIR."change-log.txt", "r") or die("Unable to open file!");
        // Output one line until end-of-file
        echo '<p style="height:200px;overflow:auto;">';
        while(!feof($myfile)) {
          echo fgets($myfile) . "<br>";
        }
        echo '</p>';
        fclose($myfile);
        ?>
        </div>
        <div class="request-section">

            <h2 class="dashboard-title">Missing Any Feature?</h1>
                <p class="swt-request-description">Are you in need of a feature that’s not available in our plugin?
                    Feel free to do a feature request from here,</p>
                <a class="swt-request-button" target="_blank" rel="" href="https://translentor.com/contact/">Request Feature</a>

        </div>
    </div>
</div>

<div class="global-switch-section">
    <h2>Global Control</h2><br>
    <p>Use the Toggle Button to Activate or Deactivate all at once.</p>
    <label class="global-switch-label">Global Switch:</label>
    <label class="switch global-switch">
        <input id="globalSwitch" name="globalSwitch" type="checkbox" class="switch-input"
            value="<?php echo get_option('globalSwitch') == 'yes' ? 'yes' : 'no'; ?>">
        <span class="slider"></span>
    </label>
    <div class="lds-dual-ring"></div>
</div>
<form method="post">
    <div class="tab-content" id="tab2">

        <H1>DeepL API Settings <p class="dsettings">Will show here when you enabled deepl</p></H1>
        <div class="form-table deeplsettings">
            <div class="widget-section">
                <h3>Free Or Pro</h3>
                <p></p>
                <label class="switch">
                    <input name="fp_enable" id="fp_enable" type="checkbox" class="switch-input"
                        value="<?php echo get_option('fp_enable') == 'yes' ? 'yes' : 'no'; ?>">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="widget-section">
                <div class="free">

                    <input name='free_key' id='free_key' class="effect-9" type="text"
                        placeholder="Deepl Api Key For Free">
                    <span class="focus-border">
                        <i></i>
                    </span>

                </div>
                <div class="pro">

                    <input name='pro_key' id='pro_key' class="effect-9" type="text" placeholder="Deepl Api Key For Pro">
                    <span class="focus-border">
                        <i></i>
                    </span>
                </div>

            </div>

        </div>
        <div class="sm-submit-button">
            <?php submit_button(); ?>
        </div>


        <?php
    if (isset($_POST['submit_button'])) {
        // Your code for handling form submission goes here
    }
    ?>
    </div>

    <div class="tab-content translentor " id="tab3">
        <h2>Translentor Settings</h2>

        <div class="form-table">
            <div class="widget-section">
                <h3>Google Translation</h3>
                <p>Try Free Google Translation.</p>
                <label class="switch">
                    <input name="google_translation" id="google_translation" type="checkbox" class="switch-input"
                        value="<?php echo get_option('google_translation') == 'yes' ? 'yes' : 'no'; ?>">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="widget-section">
                <h3>DeepL Translation</h3>
                <p>You can translate your website using DeepL with api key. You can put api key from general settings.
                </p>
                <label class="switch">
                    <input name="deepl_translation" id="deepl_translation" type="checkbox" class="switch-input"
                        value="<?php echo get_option('deepl_translation') == 'yes' ? 'yes' : 'no'; ?>">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="widget-section">
                <h3>Manual Translation</h3>
                <p>With this option you can translate manually using editor.</p>
                <label class="switch">
                    <input name="manual_translation" id="manual_translation" type="checkbox" class="switch-input"
                        value="<?php echo get_option('manual_translation') == 'yes' ? 'yes' : 'no'; ?>">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="sm-submit-button">
            <?php submit_button(); ?>
        </div>
        <!-- </form> -->

        <?php
    if (isset($_POST['submit_button'])) {
        // Your code for handling form submission goes here
    }
    ?>
    </div>

    <div class="tab-content translentor settings" id="tab4">
        <h2>Widgets Settings</h2>
        <!-- <form method="post"> -->
        <div class="form-table">
            <div class="widget-section dropdown_tab">
                <h3>Translentor Drop Down</h3>
                <p>Language Drop Down for Website with unique styles Elementor Page Builder.</p>
                <label class="switch">
                    <input name="dropdown" id="dropdown" type="checkbox" class="switch-input"
                        value="<?php echo get_option('dropdown') == 'yes' ? 'yes' : 'no'; ?>">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="widget-section popup_tab">
                <h3>Translentor Popup</h3>
                <p>Language Popup for Website with unique styles Elementor Page Builder.</p>
                <label class="switch">
                    <input name="popup" id="popup" type="checkbox" class="switch-input"
                        value="<?php echo get_option('popup') == 'yes' ? 'yes' : 'no'; ?>">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="widget-section bottomsheet_tab">
                <h3>Translentor Bottom Sheet</h3>
                <p>Language Bottom Sheet for Website with unique styles Elementor Page Builder.</p>
                <label class="switch">
                    <input name="bottomsheet" id="bottomsheet" type="checkbox" class="switch-input"
                        value="<?php echo get_option('bottomsheet') == 'yes' ? 'yes' : 'no'; ?>">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="sm-submit-button">
            <?php submit_button(); ?>
        </div>
        <!-- </form> -->

        <?php
    if (isset($_POST['submit_button'])) {
        // Your code for handling form submission goes here
    }
    ?>
    </div>

    <div class="tab-content extension settings" id="tab5">
        <h2>Extensions Settings</h2>
        <!-- <form method="post"> -->
        <div class="form-table">
            <div class="widget-section">
                <h3>Clickable Column Extension</h3>
                <p>Make Elementor Columns clickable with realtime links.</p>
                <label class="switch">
                    <input name="clickablecolumn" id="clickablecolumn" type="checkbox" class="switch-input"
                        value="<?php echo get_option('clickablecolumn') == 'yes' ? 'yes' : 'no'; ?>">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="widget-section">
                <h3>Download As Image Extension</h3>
                <p>Download Elementor custom design As Image.</p>
                <label class="switch">
                    <input name="downloadasimage" id="downloadasimage" type="checkbox" class="switch-input"
                        value="<?php echo get_option('downloadasimage') == 'yes' ? 'yes' : 'no'; ?>">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="sm-submit-button">
            <?php submit_button(); ?>
        </div>


        <?php
    if (isset($_POST['submit_button'])) {
        // Your code for handling form submission goes here
    }
    ?>
    </div>
</form>
<script>
// Your JavaScript code for initializing and handling UI interactions goes here
</script>
<?php
if (isset($_POST['submit'])) {
    if (get_option('globalSwitch') !=='') {   
        if (get_option('globalSwitch') === 'yes') {
            update_option('google_translation', 'yes');
            // update_option('deepl_translation','yes');
            // update_option('manual_translation','yes');
            update_option('dropdown','yes');
            update_option('popup','yes');
            update_option('bottomsheet','yes');
            update_option('clickablecolumn', 'yes');
            update_option('downloadasimage', 'yes');
            // /delete_option('globalSwitch');
        } else if(get_option('globalSwitch') === 'no'){
            update_option('google_translation', 'yes');
            update_option('deepl_translation','no');
            update_option('manual_translation','no');
            update_option('dropdown','yes');
            update_option('popup','no');
            update_option('bottomsheet','no');
            update_option('clickablecolumn', 'no');
            update_option('downloadasimage', 'no');
            update_option('globalSwitch', '');
        }
    } else {
        // Handle individual options if the global switch is not selected
        if (isset($_POST['google_translation'])) {
            update_option('google_translation', 'yes');
        } else {
            update_option('google_translation', 'no');
        }

        if (isset($_POST['deepl_translation'])) {
            update_option('deepl_translation', 'yes');
            if(isset($_POST['fp_enable']))
            {
              update_option('fp_deepl','pro');
            }else{
              update_option('fp_deepl','free');
            }
            if($_POST['free_key'] !='')
            {
              update_option('deepl_key',sanitize_text_field($_POST['free_key']));
            }
            if($_POST['pro_key'] !='')
            {
              update_option('deepl_key',sanitize_text_field($_POST['pro_key']));
            }
        } else {
            update_option('deepl_translation', 'no');
        }
        if (isset($_POST['manual_translation'])) {
            update_option('manual_translation', 'yes');
        } else {
            update_option('manual_translation', 'no');
        }
    

        if (isset($_POST['dropdown'])) {
            update_option('dropdown', 'yes');
        } else {
            update_option('dropdown', 'no');
        }
        if (isset($_POST['popup'])) {
            update_option('popup', 'yes');
        } else {
            update_option('popup', 'no');
        }
        if (isset($_POST['bottomsheet'])) {
            update_option('bottomsheet', 'yes');
        } else {
            update_option('bottomsheet', 'no');
        }

        if (isset($_POST['clickablecolumn'])) {
            update_option('clickablecolumn', 'yes');
        } else {
            update_option('clickablecolumn', 'no');
        }


        if (isset($_POST['downloadasimage'])) {
            update_option('downloadasimage', 'yes');
        } else {
            update_option('downloadasimage', 'no');
        }

    }
}
$translentor_admin_params= array(
    'google_translation' =>get_option('google_translation'),
    'deepl_translation' =>get_option('deepl_translation'),
    'manual_translation'=>get_option('manual_translation'),
    'dropdown' =>get_option('dropdown'),
    'popup' =>get_option('popup'),
    'clickablecolumn' =>get_option('clickablecolumn'),
    'bottomsheet' =>get_option('bottomsheet'),
    'downloadasimage' =>get_option('downloadasimage'),
    'globalSwitch' => get_option('globalSwitch'),
    'fp_deepl'=> get_option('fp_deepl'),
    'deepl_key' => get_option('deepl_key'),
    'ajax_url'     => admin_url( 'admin-ajax.php' ),
);
wp_localize_script( 'translentor_admin_js', 'translentor_admin_params', $translentor_admin_params );



?>