<?php


    use Morningtrain\WP\View\Blade\Blade;

    Blade::directive(
        'username',
        fn() => "<?php mtvd_username(); ?>"
    );

    /**
     * Morningtrain View Directive
     * @ username is useful for rendering the current users display name
     */
    function mtvd_username()
    {
        echo is_user_logged_in() ? wp_get_current_user()->display_name : '';
    }