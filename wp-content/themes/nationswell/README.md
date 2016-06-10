NationSwell (Custom Theme)
===========

http://gruntjs.com/getting-started

Assuming that the Grunt CLI has been installed and that the project has already been configured with a package.json and a Gruntfile, it’s very easy to start working with Grunt:

* Change to the theme root directory.
* Install project dependencies with `npm install`.
* Run Grunt with `grunt`.

That's really all there is to it. Installed Grunt tasks can be listed by running `grunt --help`.


1. `grunt` then `grunt watch`
2. Wordpress Export from Staging or Production http://nationswell.com/wp-admin/export.php.
3. Import the export file into your local Wordpress install. Make sure to specify to download images and attachments during the import, otherwise posts will lack images.
   http://local.wordpress.dev/wp-admin/admin.php?import=wordpress
4. Go to http://local.wordpress.dev/wp-admin/admin.php?page=acf-options. Click 'Save Options'. Then fill out any un-configured options needed and re-save.
5. `vagrant ssh`, then access `/etc/nginx/nginx-wp-common.conf`
6. Add this nginx location directive to nginx-wp-common.conf directly above `location ~ \.php$ {`
````
location ~ ^/static/\d+/(js|fonts|img|css)/(.*)$ {
  try_files $uri $uri/ /wp-content/themes/nationswell/$1/$2;
}
````
7. Restart nginx `sudo /etc/init.d/nginx restart`

8. Install and Activate Wordpress Plugins and NationSwell theme 
```
cd /vagrant/www/wordpress-default`
chmod +x init.sh
./init.sh
```