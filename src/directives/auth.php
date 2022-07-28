<?php

    use Morningtrain\WP\View\Blade\Blade;

    Blade::if(
        'auth',
        'mtvd_auth'
    );

    /**
     * Morningtrain View Directive
     * @ auth is useful for making conditional views with user capabilities
     *
     * @see https://developer.wordpress.org/reference/functions/is_user_logged_in/
     * @see https://developer.wordpress.org/reference/functions/current_user_can/
     *
     * @param string|null $capability If supplied current user MUST have this capability else a simple is_user_logged_in() is used
     * @return bool
     */
    function mtvd_auth(?string $capability = null): bool
    {
        return $capability === null ? is_user_logged_in() : current_user_can($capability);
    }