<?php

use core_privacy\local\metadata\null_provider;

/**
 * Data privacy provider
 */
class provider implements null_provider {
    /**
     * Get the language string identifier
     *
     * @return string Explaination why the plugin stores no user data
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
