
## Sms API Case

### Kurulum

<pre>git clone </pre>
<pre>cd sms-app</pre>
<pre>composer install</pre>


### Docker İle Kurulumu
<pre>docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
</pre>

Projeyi ayağa kaldırma

<pre>./vendor/bin/sail up</pre>

Artisan komut örneği

<pre>./vendor/bin/sail artisan make:controller TestController</pre>


