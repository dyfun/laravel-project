Proje Postman dökümanı ve koleksiyonu proje dosyası içerisinde yer almaktadır.

# 1. Uygulama Gereksinimleri
- Composer [*](https://getcomposer.org/)
- Mysql 8.0+ [*](https://dev.mysql.com/downloads/mysql/8.0.26.html)
- PHP 8.1+ [*](https://www.php.net/releases/)
- Nginx [*](https://www.nginx.com/)

# 2. Uygulama Kurulum
### 2.1. Sunucu Kurulumu
- Mevcut işletim sisteminize uygun yazılımları yükleyin: (Ubuntu)
    ```
    # PHP
    sudo apt install php8.1
    sudo apt install php8.1-fpm php8.1-common php8.1-opcache php8.1-cli
    sudo apt install php8.1-gd php8.1-curl php8.1-mysql
    sudo apt install php8.1-xml
    sudo apt install php8.1-mbstring
    sudo apt install zip unzip php8.1-zip

    ```
    - Eğer `Couldn't find any package by glob 'php8.1'` hatası alırsanız aşağıda ki adımları izleyiniz.
    ````
    sudo apt update
    sudo apt install lsb-release ca-certificates apt-transport-https software-properties-common -y
    sudo add-apt-repository ppa:ondrej/php
    ````
    
    ```
    # Composer
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php 
    sudo mv composer.phar /usr/local/bin/composer
    
    # Nginx Web Server
    sudo apt install nginx
    systemctl enable nginx
    
    # Mysql Database
    sudo apt install mysql-server
    sudo mysql_secure_installation
    systemctl start mysql
    systemctl enable mysql

    ```
- __PHP Ayarları:__
    ```shell
    nano /etc/php/8.1/cli/php.ini
    ```
    ```
    upload_max_filesize = 100M
    post_max_size = 100M
    max_file_uploads = 50
    max_execution_time = 60
    memory_limit = 1024M
    expose_php = off
    opcache.max_accelerated_files = 50000
    ```

- __Nginx Ayarları:__
    ```
    nano /etc/nginx/sites-available/task-project
    ```
    ```
    server {
        listen 80;
        root /var/www/task-project/public;
        index index.php index.html index.htm index.nginx-debian.html;
        server_name _;

        location / {
           try_files $uri /index.php$is_args$args;
        }
    
        location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            #fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
            fastcgi_pass 127.0.0.1:9000;
        }
    }
    ```
    ```
    sudo ln -s /etc/nginx/sites-available/task-project /etc/nginx/sites-enabled/
    sudo nginx -t
    sudo systemctl restart nginx
    ```
### 2.2. Uygulamayı Yükleyin
- Uygulama dosyalarını __"/var/www/task-project"__ dizinine kopyalayın ve yeni .env dosyası oluşturup gerekli ayarları girin.
    ```shell
    cd /var/www/task-project
    cp .env.example .env
    nano .env
    ```

- **Kurulumu Başlatın:**
    ```shell
    sudo chown -R www-data:www-data storage
    chmod -R 755 storage
    composer install
    php artisan migrate
    php artisan db:seed
    ```

- **Test Yapın:**
- Test yapabilmek için .env ayarlarını test olacak şekilde girin.
    ```shell
    php artisan test --filter UserTest
    php artisan test --filter SubscriptionTest
    php artisan test --filter TransactionTest
    ```
# 3. Periyodik Görevler
Arkaplan da çalışacak olan görevler için aşağıdaki komutları çalıştırın.
  ```shell
  crontab -e
  ```
  ```
  0 * * * * cd /var/www/task-project && php artisan schedule:run >> /d>
  ```

# 4. Öneri
Blogumda[*](https://tayfunguler.org/blog) Laravel ile ilgili içerikler bulabilirsiniz.
