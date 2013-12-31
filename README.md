nationswell
===========

1. Install Vagrant
    http://www.vagrantup.com/

2. Install Varying Vagrants Vagrant
    https://github.com/10up/varying-vagrant-vagrants

3. npm install grunt dependencies

4. Add this nginx location directive to /etc/nginx/nginx-wp-common.conf directly above `location ~ \.php$ {`

````
location ~ ^/static/\d+/(js|fonts|img|css)/(.*)$ {
  try_files $uri $uri/ /wp-content/themes/nationswell/$1/$2;
}
````

