<?php



function translentor_full_trim( $string, $args = array()  ) {

    if((is_array($string)) || (is_object($string))){
        return "";
    }

	if ( !isset( $args['numerals']) ) {
		if ( function_exists( 'get_option' ) ) {
			$opt = get_option( 'translentor_advanced_settings', false );
			if ( isset( $opt["enable_numerals_translation"] ) ) {
				$args['numerals'] = $opt["enable_numerals_translation"];
			} else {
				$args['numerals'] = "no";
			}
		} else {
			$args['numerals'] = "no";
		}
	}


	$prefixes = array( "\xc2\xa0", "&nbsp;" );
	do{

	    $previous_iteration_string = $string;

        $string = trim($string, " \t\n\r\0\x0B");


		foreach( $prefixes as $prefix ) {
			$prefix_length = strlen($prefix);
			if (substr($string, 0, $prefix_length) == $prefix) {
				$string = substr($string, $prefix_length);
			}
			if (substr($string, -$prefix_length, $prefix_length) == $prefix) {
				$string = substr($string, 0, -$prefix_length);
			}
		}
	}while( $string != $previous_iteration_string );

	if ($args['numerals'] === "yes") {
		$filter_string = " \t\n\r\0\x0B\xA0�.,/`~!@#\$€£%^&*():;-_=+[]{}\\|?/<>'\"";
	} else {
		$filter_string = " \t\n\r\0\x0B\xA0�.,/`~!@#\$€£%^&*():;-_=+[]{}\\|?/<>1234567890'\"";
	}

	if ( strip_tags( $string ) === '' || trim ($string, $filter_string) === '' ){
		$string = '';
	}
	return $string;
}

function translentor_sort_dictionary_by_original( $dictionaries, $type, $group, $languageForId ){
	$array = array();
	foreach( $dictionaries as $language => $dictionary ){
		if ( isset( $dictionary['translentor-default-language'] ) && $dictionary['translentor-default-language'] == true ){
			continue;
		}
		foreach( $dictionary as $string ) {
			if ( isset( $string->original ) ){
				$found = false;
				$string->editedTranslation = $string->translated;
				foreach( $array as $key => $row ){
					if ( $row['original'] == $string->original ){
						if ( !isset( $string->domain ) || ( isset( $string->domain ) && $string->domain == $row['description'] ) ) {
							$array[ $key ]['translationsArray'][ $language ] = $string;
							unset( $array[ $key ]['translationsArray'][ $language ]->original );
							$found = true;

							if ( isset($string->domain) ){
								$array[ $key ]['description'] = $string->domain;
							}
							if ( $language == $languageForId ){
								$array[ $key ][ 'dbID' ] = $string->id;
							}
							break;
						}
					}
				}
				if ( ! $found ){
					$new_entry = array(
						'type'              => $type,
						'group'         => $group,
						'translationsArray' => array( $language  => $string ),
						'original'          => $string->original
					);
					unset($string->original);

					if ( isset( $string->domain ) ){
						$new_entry['description'] = $description = $string->domain;
					}
					if ( $language == $languageForId ){
						$new_entry['dbID'] = $string->id;
					}
					if ( isset( $new_entry['translationsArray'][$language]->block_type ) ){
						$new_entry['blockType'] = $new_entry['translationsArray'][$language]->block_type;
					}

					$array[] = $new_entry;
				}
			}
		}
	}
	return $array;
}

function translentor_is_valid_language_code( $language_code ){
 
    if ( empty($language_code) || preg_match('/[^A-Za-z0-9\-_]/i', $language_code ) ) {
        return false;
    }else{
        return true;
    }
}
