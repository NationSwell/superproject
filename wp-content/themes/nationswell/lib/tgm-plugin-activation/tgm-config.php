<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once(get_stylesheet_directory() . '/lib/tgm-plugin-activation/class-tgm-plugin-activation.php');
add_action('tgmpa_register', 'my_theme_register_required_plugins');

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins()
{

    /**
     * Array of plugin arrays. Required keys are name, slug and required.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        array(
            'name' => 'Timber',
            'slug' => 'timber',
            'source' => get_stylesheet_directory() . '/lib/plugins/timber-library.0.15.5.zip',
            'required' => true,
            'version' => '0.15.5',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Advanced Custom Fields',
            'slug' => 'advanced-custom-fields',
            'source' => get_stylesheet_directory() . '/lib/plugins/advanced-custom-fields.zip',
            'required' => true,
            'version' => '4.3.1',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Advanced Custom Fields: Flexible Content Field',
            'slug' => 'acf-flexible-content',
            'source' => get_stylesheet_directory() . '/lib/plugins/acf-flexible-content.zip',
            'required' => true,
            'version' => '1.1.0',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Advanced Custom Fields: Repeater Field',
            'slug' => 'acf-repeater',
            'source' => get_stylesheet_directory() . '/lib/plugins/acf-repeater.zip',
            'required' => true,
            'version' => '1.1.1',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Advanced Custom Fields: Options Page',
            'slug' => 'acf-options-page',
            'source' => get_stylesheet_directory() . '/lib/plugins/acf-options-page.zip',
            'required' => true,
            'version' => '1.2.0',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Codepress Admin Columns',
            'slug' => 'codepress-admin-columns',
            'source' => get_stylesheet_directory() . '/lib/plugins/codepress-admin-columns.2.1.0.zip',
            'required' => true,
            'version' => '2.1.0',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Codepress Admin Columns: Pro',
            'slug' => 'cac-addon-pro',
            'source' => get_stylesheet_directory() . '/lib/plugins/cac-addon-pro-104.zip',
            'required' => true,
            'version' => '1.0.4',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Simple Menu Delete',
            'slug' => 'simple-menu-delete',
            'source' => get_stylesheet_directory() . '/lib/plugins/simple-menu-delete.0.2.zip',
            'required' => true,
            'version' => '0.2',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Wordpress Importer',
            'slug' => 'wordpress-importer',
            'source' => get_stylesheet_directory() . '/lib/plugins/wordpress-importer.0.6.1.zip',
            'required' => true,
            'version' => '0.6.1',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Ad Code Manager',
            'slug' => 'ad-code-manager',
            'source' => get_stylesheet_directory() . '/lib/plugins/ad-code-manager.0.4.1.zip',
            'required' => true,
            'version' => '0.4.1',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Google Analytics',
            'slug' => 'google-analytics-for-wordpress',
            'source' => get_stylesheet_directory() . '/lib/plugins/google-analytics-for-wordpress.4.3.3.zip',
            'required' => true,
            'version' => '4.3.3',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Wordpress SEO',
            'slug' => 'wordpress-seo',
            'source' => get_stylesheet_directory() . '/lib/plugins/wordpress-seo.1.4.19.zip',
            'required' => true,
            'version' => '1.4.19',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'WordPress SEO News',
            'slug' => 'wpseo-news',
            'source' => get_stylesheet_directory() . '/lib/plugins/wpseo-news.zip',
            'required' => true,
            'version' => '1.1.1',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'humans.txt',
            'slug' => 'humanstxt',
            'source' => get_stylesheet_directory() . '/lib/plugins/humanstxt.1.2.5.zip',
            'required' => true,
            'version' => '1.2.5',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Vaultpress',
            'slug' => 'vaultpress',
            'source' => get_stylesheet_directory() . '/lib/plugins/vaultpress.1.4.9.zip',
            'required' => true,
            'version' => '1.4.9',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Optimizely',
            'slug' => 'optimizely',
            'source' => get_stylesheet_directory() . '/lib/plugins/optimizely.1.0.1.zip',
            'required' => true,
            'version' => '1.0.1',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Chartbeat',
            'slug' => 'chartbeat',
            'source' => get_stylesheet_directory() . '/lib/plugins/chartbeat.2.0.3.zip',
            'required' => true,
            'version' => '1.0.1',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
        array(
            'name' => 'Ronik Bit.ly',
            'slug' => 'ronik-bitly',
            'source' => get_stylesheet_directory() . '/lib/plugins/ronik-bitly.zip',
            'required' => true,
            'version' => '1.1.0',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
        ),
    );

    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'tgmpa';

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain' => $theme_text_domain, // Text domain - likely want to be the same as your theme.
        'default_path' => '', // Default absolute path to pre-packaged plugins
        'parent_menu_slug' => 'themes.php', // Default parent menu slug
        'parent_url_slug' => 'themes.php', // Default parent URL slug
        'menu' => 'install-required-plugins', // Menu slug
        'has_notices' => true, // Show admin notices or not
        'is_automatic' => false, // Automatically activate plugins after installation or not
        'message' => '', // Message to output right before the plugins table
        'strings' => array(
            'page_title' => __('Install Required Plugins', $theme_text_domain),
            'menu_title' => __('Install Plugins', $theme_text_domain),
            'installing' => __('Installing Plugin: %s', $theme_text_domain),
            // %1$s = plugin name
            'oops' => __('Something went wrong with the plugin API.', $theme_text_domain),
            'notice_can_install_required' => _n_noop(
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.'
            ),
            // %1$s = plugin name(s)
            'notice_can_install_recommended' => _n_noop(
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.'
            ),
            // %1$s = plugin name(s)
            'notice_cannot_install' => _n_noop(
                'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.',
                'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.'
            ),
            // %1$s = plugin name(s)
            'notice_can_activate_required' => _n_noop(
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.'
            ),
            // %1$s = plugin name(s)
            'notice_can_activate_recommended' => _n_noop(
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.'
            ),
            // %1$s = plugin name(s)
            'notice_cannot_activate' => _n_noop(
                'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.',
                'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.'
            ),
            // %1$s = plugin name(s)
            'notice_ask_to_update' => _n_noop(
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.'
            ),
            // %1$s = plugin name(s)
            'notice_cannot_update' => _n_noop(
                'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.',
                'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.'
            ),
            // %1$s = plugin name(s)
            'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins'),
            'activate_link' => _n_noop('Activate installed plugin', 'Activate installed plugins'),
            'return' => __('Return to Required Plugins Installer', $theme_text_domain),
            'plugin_activated' => __('Plugin activated successfully.', $theme_text_domain),
            'complete' => __('All plugins installed and activated successfully. %s', $theme_text_domain)
            // %1$s = dashboard link
        )
    );

    tgmpa($plugins, $config);

}

?>