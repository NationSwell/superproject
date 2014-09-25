#!/bin/sh

echo "Commencing WordPress NationSwell theme setup"

if hash composer 2>/dev/null; then
    composer install
else
    echo >&2 "Composer is required Aborting."
    exit 1;
fi

if hash wp 2>/dev/null; then
    echo "Activating Plugins"
    wp plugin activate timber-library
    wp plugin activate codepress-admin-columns
    wp plugin activate wp-author-slug
    wp plugin activate wordpress-seo
    wp plugin activate co-authors-plus
    wp plugin activate automatic-facebook-cache-cleaner
    wp plugin activate advanced-custom-fields
    wp plugin activate acf-flexible-content
    wp plugin activate acf-repeater
    wp plugin activate acf-gallery
    wp plugin activate acf-options-page
    wp plugin activate wordpress-importer
    wp plugin activate simple-menu-delete

    echo "Activating NationSwell Theme"

    wp theme activate nationswell
else
    echo >&2 "WP-CLI is required Aborting."
    exit 1;
fi