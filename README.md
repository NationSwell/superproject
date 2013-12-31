nationswell
===========

-----
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

1. Install virtualbox https://www.virtualbox.org/

2. Install Vagrant
    http://www.vagrantup.com/

3. Install the vagrant-hostsupdater plugin `vagrant plugin install vagrant-hostsupdater`

4. `git clone https://github.com/10up/varying-vagrant-vagrants nationswell`

5. `cd nationswell/www/wordpress-default`

6. `git clone https://github.com/ronik-design/nationswell.git`

7. `cd nationswell`

8. `mv .git ..`

9. `cd ..`

10. `git reset HEAD --hard`

11. `rm -rf nationswell`

12. `cd wp-content/themes/nationswell` npm install grunt dependencies

13. From `wp-content/themes/nationswell` run `grunt` then `grunt watch`

14. `vagrant up --provision` the provision flag only needs to be used the first time you vagrant up

15. Wordpress Export from Staging or Produciton http://local.wordpress.dev/wp-admin/export.php.

16. Import the Export file into you local. Make sure to check download images and attachments during the import, otherwise you will not have any images. http://local.wordpress.dev/wp-admin/admin.php?import=wordpress

17. Go to http://local.wordpress.dev/wp-admin/admin.php?page=acf-options. Click 'Save Options'. Then fill out any unconfigured options needed on the options page

18. `vagrant ssh`, then access `/etc/nginx/nginx-wp-common.conf`

19. Add this nginx location directive to nginx-wp-common.conf directly above `location ~ \.php$ {`

````
location ~ ^/static/\d+/(js|fonts|img|css)/(.*)$ {
  try_files $uri $uri/ /wp-content/themes/nationswell/$1/$2;
}
````

