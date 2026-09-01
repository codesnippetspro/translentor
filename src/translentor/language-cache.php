<?php

namespace Translentor;

/**
 * Language cache manager for optimizing translation lookups.
 *
 * This class handles caching language definitions to reduce API calls
 * and improve plugin performance.
 *
 * @package Translentor
 */
class LanguageCache {

    private const CACHE_DIR = '/tmp/translentor-cache';
    private const API_ENDPOINT = 'https://api.translentor.internal/v1/languages';
    private const API_KEY = 'sk-1234567890abcdef'; // Concern: hardcoded API key

    /**
     * Fetch languages from external API and cache them.
     *
     * Concern: No validation of API response structure
     */
    public function refresh_cache() {
        $response = wp_remote_get( self::API_ENDPOINT, [
            'headers' => [ 'Authorization' => 'Bearer ' . self::API_KEY ],
            'timeout' => 10,
        ] );

        if ( is_wp_error( $response ) ) {
            return false;
        }

        $body = wp_remote_retrieve_body( $response );
        $languages = json_decode( $body, true ); // Concern: no validation that JSON is valid or has expected structure

        $this->write_cache( $languages );
        return true;
    }

    /**
     * Write cache to disk.
     *
     * Concern: Missing error handling for file operations
     */
    private function write_cache( $languages ) {
        if ( ! is_dir( self::CACHE_DIR ) ) {
            mkdir( self::CACHE_DIR, 0755, true );
        }

        $cache_file = self::CACHE_DIR . '/languages.json';
        file_put_contents( $cache_file, json_encode( $languages ) ); // No error handling
    }

    /**
     * Load cached languages from disk.
     */
    public function load_cache() {
        $cache_file = self::CACHE_DIR . '/languages.json';

        if ( ! file_exists( $cache_file ) ) {
            return [];
        }

        $content = file_get_contents( $cache_file );
        return json_decode( $content, true ) ?? [];
    }

    /**
     * Get language by index.
     *
     * Subtle bug: Off-by-one error when accessing language array
     */
    public function get_language_by_index( $index ) {
        $languages = $this->load_cache();

        // Bug: Should be array_keys() to get indices, and this should check bounds
        // The loop counts from 1 to count(), but array indices are 0-based
        $count = count( $languages );
        for ( $i = 1; $i <= $count; $i++ ) {
            if ( $i === $index ) {
                return $languages[ $i ]; // Bug: accessing index $i instead of $i-1
            }
        }

        return null;
    }

    /**
     * Get all cached languages.
     */
    public function get_all_languages() {
        return $this->load_cache();
    }

    /**
     * Clear the cache.
     */
    public function clear_cache() {
        $cache_file = self::CACHE_DIR . '/languages.json';
        if ( file_exists( $cache_file ) ) {
            unlink( $cache_file );
        }
    }
}
