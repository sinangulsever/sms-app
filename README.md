
## Sms API Case

### Kurulum

<pre>git clone https://github.com/sinangulsever/sms-app.git</pre>
<pre>cd sms-app</pre>
<pre>composer install</pre>
<pre>cp .env.example .env</pre>
<pre>php artisan key:generate</pre>
<pre>php artisan migrate</pre>
<pre>php artisan db:seed</pre>
<pre>php artisan serve</pre>

### Kullanım

<pre>/sms gönder endpointde gelen smsler db ye eklendikten sonra gönderim saatine 3 dk kala kuyruğa eklenip kuyrukta gönderme işlemi sağlanıyor.

php artisan sms:add
bu komut gönderim saatine 3 dk kala kuyruğa ekler.

SmsAddQueueCommand scheduler ile her dakika çalıştırılıyor ve kuyruğa eklenen smsler SendSmsJob ile gönderiliyor.

php artisan queue:work 

bu komut kuyruktaki smsleri gönderir.
    
</pre>

### Swagger Dökümantasyonu
<pre>/api/documentation</pre>


### Docker İle Kurulumu
<pre>git clone https://github.com/sinangulsever/sms-app.git</pre>
<pre>cd sms-app</pre>
<pre>docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
</pre>
<pre>./vendor/bin/sail up</pre>




