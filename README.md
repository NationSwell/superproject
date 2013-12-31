NationSwell
===========

#### Dependencies

1. git `http://git-scm.com/book/en/Getting-Started-Installing-Git`

2. ruby

3. npm

4. brew `http://brew.sh/`

5. grunt `http://gruntjs.com/installing-grunt`

6. fontforge
   ````
   brew install fontforge ttfautohint
   npm install grunt-webfont --save-dev
   ````

-----

#### Setup

1. Install Vagrant
    http://www.vagrantup.com/

2. Install the vagrant-hostsupdater plugin `vagrant plugin install vagrant-hostsupdater`

2. `git clone https://github.com/10up/varying-vagrant-vagrants nationswell`

3. `cd nationswell/www/wordpress-default`

4. `git clone https://github.com/ronik-design/nationswell.git`

5. `cd nationswell`

6. `mv .git ..`

7. `cd ..`

8. `git reset HEAD --hard`

9. `rm -rf nationswell`

10. `cd wp-content/themes/nationswell` npm install grunt dependencies

11. From `wp-content/themes/nationswell` run `grunt` then `grunt watch`

11. Wordpress Export from Staging or Produciton http://local.wordpress.dev/wp-admin/export.php.

12. Import the Export file into you local. Make sure to check download images and attachments during the import, otherwise you will not have any images. http://local.wordpress.dev/wp-admin/admin.php?import=wordpress

13. Go to http://local.wordpress.dev/wp-admin/admin.php?page=acf-options. Click 'Save Options'. Then fill out any unconfigured options needed on the options page

14. Add this nginx location directive to /etc/nginx/nginx-wp-common.conf directly above `location ~ \.php$ {`

````
location ~ ^/static/\d+/(js|fonts|img|css)/(.*)$ {
  try_files $uri $uri/ /wp-content/themes/nationswell/$1/$2;
}
````

