<?php
/**
 * Language Utilities for Translentor.
 *
 * @package Translentor
 */

class Translentor_Language_Utils {

	/**
	 * Get all available languages.
	 *
	 * @return array Language code => Language name pairs.
	 */
	public static function get_all_languages() {
		return array(
			'Afrikaans'           => __( 'Afrikaans', translentor_slug ),
			'Albanian'            => __( 'Albanian', translentor_slug ),
			'Arabic'              => __( 'Arabic', translentor_slug ),
			'Azerbaijani'         => __( 'Azerbaijani', translentor_slug ),
			'Bangla'              => __( 'Bangla', translentor_slug ),
			'Basque'              => __( 'Basque', translentor_slug ),
			'Belarusian'          => __( 'Belarusian', translentor_slug ),
			'Bulgarian'           => __( 'Bulgarian', translentor_slug ),
			'Catalan'             => __( 'Catalan', translentor_slug ),
			'Chinese Simplified'  => __( 'Chinese Simplified', translentor_slug ),
			'Chinese Traditional' => __( 'Chinese Traditional', translentor_slug ),
			'Croatian'            => __( 'Croatian', translentor_slug ),
			'Czech'               => __( 'Czech', translentor_slug ),
			'Danish'              => __( 'Danish', translentor_slug ),
			'Dutch'               => __( 'Dutch', translentor_slug ),
			'English'             => __( 'English', translentor_slug ),
			'Esperanto'           => __( 'Esperanto', translentor_slug ),
			'Estonian'            => __( 'Estonian', translentor_slug ),
			'Filipino'            => __( 'Filipino', translentor_slug ),
			'Finnish'             => __( 'Finnish', translentor_slug ),
			'French'              => __( 'French', translentor_slug ),
			'Galician'            => __( 'Galician', translentor_slug ),
			'Georgian'            => __( 'Georgian', translentor_slug ),
			'German'              => __( 'German', translentor_slug ),
			'Greek'               => __( 'Greek', translentor_slug ),
			'Gujarati'            => __( 'Gujarati', translentor_slug ),
			'Haitian Creole'      => __( 'Haitian Creole', translentor_slug ),
			'Hebrew'              => __( 'Hebrew', translentor_slug ),
			'Hindi'               => __( 'Hindi', translentor_slug ),
			'Hungarian'           => __( 'Hungarian', translentor_slug ),
			'Icelandic'           => __( 'Icelandic', translentor_slug ),
			'Indonesian'          => __( 'Indonesian', translentor_slug ),
			'Irish'               => __( 'Irish', translentor_slug ),
			'Italian'             => __( 'Italian', translentor_slug ),
			'Japanese'            => __( 'Japanese', translentor_slug ),
			'Kannada'             => __( 'Kannada', translentor_slug ),
			'Korean'              => __( 'Korean', translentor_slug ),
			'Latin'               => __( 'Latin', translentor_slug ),
			'Latvian'             => __( 'Latvian', translentor_slug ),
			'Lithuanian'          => __( 'Lithuanian', translentor_slug ),
			'Macedonian'          => __( 'Macedonian', translentor_slug ),
			'Malay'               => __( 'Malay', translentor_slug ),
			'Maltese'             => __( 'Maltese', translentor_slug ),
			'Norwegian'           => __( 'Norwegian', translentor_slug ),
			'Persian'             => __( 'Persian', translentor_slug ),
			'Polish'              => __( 'Polish', translentor_slug ),
			'Portuguese'          => __( 'Portuguese', translentor_slug ),
			'Romanian'            => __( 'Romanian', translentor_slug ),
			'Russian'             => __( 'Russian', translentor_slug ),
			'Serbian'             => __( 'Serbian', translentor_slug ),
			'Slovak'              => __( 'Slovak', translentor_slug ),
			'Slovenian'           => __( 'Slovenian', translentor_slug ),
			'Spanish'             => __( 'Spanish', translentor_slug ),
			'Swahili'             => __( 'Swahili', translentor_slug ),
			'Swedish'             => __( 'Swedish', translentor_slug ),
			'Tamil'               => __( 'Tamil', translentor_slug ),
			'Telugu'              => __( 'Telugu', translentor_slug ),
			'Thai'                => __( 'Thai', translentor_slug ),
			'Turkish'             => __( 'Turkish', translentor_slug ),
			'Ukranian'            => __( 'Ukranian', translentor_slug ),
			'Urdu'                => __( 'Urdu', translentor_slug ),
			'Vietnamese'          => __( 'Vietnamese', translentor_slug ),
			'Welsh'               => __( 'Welsh', translentor_slug ),
			'Yiddish'             => __( 'Yiddish', translentor_slug )
		);
	}

	/**
	 * Get language by index.
	 *
	 * @param int $index The language index.
	 * @return string|false Language name or false if not found.
	 */
	public static function get_language_by_index( $index ) {
		$languages = self::get_all_languages();
		$language_names = array_values( $languages );

		if ( isset( $language_names[ $index + 1 ] ) ) {
			return $language_names[ $index + 1 ];
		}
		return false;
	}

	/**
	 * Get language code for a given language name.
	 *
	 * @param string $language_name The language name.
	 * @return string|false The language code or false if not found.
	 */
	public static function get_language_code( $language_name ) {
		return array_search( $language_name, self::get_all_languages(), true );
	}
}
