<?php
class AdminSettings{
    public static function translentor_system_requirement() {
        $php_version        = phpversion();
        $max_execution_time = ini_get('max_execution_time');
        $memory_limit       = ini_get('memory_limit');
        $post_limit         = ini_get('post_max_size');
        $uploads            = wp_upload_dir();
        $upload_path        = $uploads['basedir'];
        $yes_icon           = '<span class="valid"><i class="dashicons-before dashicons-yes"></i></span>';
        $no_icon            = '<span class="invalid"><i class="dashicons-before dashicons-no-alt"></i></span>';

        $environment = self::environment_info();


    ?>
        <ul class="swt-system-status swt-grid-small ">
            <li>
                <div>

                    <span class="mlabel">PHP Version: </span>

                    <?php
                    if (version_compare($php_version, '7.0.0', '<')) {
                        echo $no_icon;
                        echo '<span class="label" title="Min: 7.0 Recommended" swt-tooltip>Currently: ' . $php_version . '</span>';
                    } else {
                        echo $yes_icon;
                        echo '<span class="label">Currently: ' . $php_version . '</span>';
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="mlabel">Max execution time: </span>

                    <?php
                    if ($max_execution_time < '90') {
                        echo $no_icon;
                        echo '<span class="label" title="Min: 90 Recommended" swt-tooltip>Currently: ' . $max_execution_time . '</span>';
                    } else {
                        echo $yes_icon;
                        echo '<span class="label">Currently: ' . $max_execution_time . '</span>';
                    }
                    ?>
                </div>
            </li>
            <li>
                <div>
                    <span class="mlabel">Memory Limit: </span>

                    <?php
                    if (intval($memory_limit) < '812') {
                        echo $no_icon;
                        echo '<span class="label" title="Min: 812M Recommended" swt-tooltip>Currently: ' . $memory_limit . '</span>';
                    } else {
                        echo $yes_icon;
                        echo '<span class="label">Currently: ' . $memory_limit . '</span>';
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="mlabel">Max Post Limit: </span>

                    <?php
                    if (intval($post_limit) < '32') {
                        echo $no_icon;
                        echo '<span class="label" title="Min: 32M Recommended" swt-tooltip>Currently: ' . $post_limit . '</span>';
                    } else {
                        echo $yes_icon;
                        echo '<span class="label">Currently: ' . $post_limit . '</span>';
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="mlabel">Uploads folder writable: </span>

                    <?php
                    if (!is_writable($upload_path)) {
                        echo $no_icon;
                    } else {
                        echo $yes_icon;
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="mlabel">MultiSite: </span>

                    <?php
                    if ($environment['wp_multisite']) {
                        echo $yes_icon;
                        echo '<span class="label">MultiSite</span>';
                    } else {
                        echo $no_icon;
                        echo '<span class="label">No MultiSite </span>';
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="mlabel">GZip Enabled: </span>

                    <?php
                    if ($environment['gzip_enabled']) {
                        echo $yes_icon;
                    } else {
                        echo $no_icon;
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="mlabel">Debug Mode: </span>
                    <?php
                    if ($environment['wp_debug_mode']) {
                        echo $yes_icon;
                        echo '<span class="label">Currently Turned On</span>';
                    } else {
                        echo $no_icon;
                        echo '<span class="label">Currently Turned Off</span>';
                    }
                    ?>
                </div>
            </li>

        </ul>
    <?php
    }
    public static function environment_info(){

		// Figure out cURL version, if installed.
		$curl_version = '';
		if ( function_exists( 'curl_version' ) ) {
			$curl_version = curl_version();
			$curl_version = $curl_version['version'] . ', ' . $curl_version['ssl_version'];
		}


		// WP memory limit.
		$wp_memory_limit = self::display_numbers(WP_MEMORY_LIMIT);
		if ( function_exists( 'memory_get_usage' ) ) {
			$wp_memory_limit = max( $wp_memory_limit, self::display_numbers( @ini_get( 'memory_limit' ) ) );
		}


		return array(
			'home_url'                  => get_option( 'home' ),
			'site_url'                  => get_option( 'siteurl' ),
			'version'                   => translentor_VERSION,
			'wp_version'                => get_bloginfo( 'version' ),
			'wp_multisite'              => is_multisite(),
			'wp_memory_limit'           => $wp_memory_limit,
			'wp_debug_mode'             => ( defined( 'WP_DEBUG' ) && WP_DEBUG ),
			'wp_cron'                   => ! ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ),
			'language'                  => get_locale(),
			'external_object_cache'     => wp_using_ext_object_cache(),
			'php_version'               => phpversion(),
			'php_post_max_size'         => self::display_numbers( ini_get( 'post_max_size' ) ),
			'php_max_execution_time'    => ini_get( 'max_execution_time' ),
			'php_max_input_vars'        => ini_get( 'max_input_vars' ),
			'curl_version'              => $curl_version,
			'suhosin_installed'         => extension_loaded( 'suhosin' ),
			'max_upload_size'           => wp_max_upload_size(),
			'default_timezone'          => date_default_timezone_get(),
			'fsockopen_or_curl_enabled' => ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ),
			'soapclient_enabled'        => class_exists( 'SoapClient' ),
			'domdocument_enabled'       => class_exists( 'DOMDocument' ),
			'gzip_enabled'              => is_callable( 'gzopen' ),
			'mbstring_enabled'          => extension_loaded( 'mbstring' ),
		);

	}
    public static function display_numbers( $size ) {
		$l    = substr( $size, -1 );
		$ret  = substr( $size, 0, -1 );
		$byte = 1024;

		switch ( strtoupper( $l ) ) {
			case 'P':
			$ret *= 1024;
			case 'T':
			$ret *= 1024;
			case 'G':
			$ret *= 1024;
			case 'M':
			$ret *= 1024;
			case 'K':
			$ret *= 1024;
		}
		return $ret;
	}

}
?>