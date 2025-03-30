server {
    listen 80;

    server_name proconline.com.br www.proconline.com.br;

    root /var/www/public;

    client_max_body_size 51g;
    client_body_buffer_size 512k;
    client_body_in_file_only clean;

    ssl_certificate /etc/letsencrypt/live/proconline.com.br/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/proconline.com.br/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers 'ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:AES';

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }

    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }

    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
}




server {
    listen 80;
    server_name proconline.com.br www.proconline.com.br;

    root /var/www/html/public;  # Certifique-se de que este é o diretório correto
    index index.php index.html index.htm;

    # Permissões adequadas para acessar os arquivos
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;  # Verifique o caminho do socket PHP-FPM
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Configuração SSL
    listen 443 ssl;
    ssl_certificate /etc/letsencrypt/live/proconline.com.br/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/proconline.com.br/privkey.pem;
}





# funcionando
server {
    listen 80;
    listen 443 ssl;
    server_name proconline.com.br www.proconline.com.br;

    root /var/www/public;

    client_max_body_size 51g;
    client_body_buffer_size 512k;
    client_body_in_file_only clean;

    ssl_certificate /etc/letsencrypt/live/proconline.com.br/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/proconline.com.br/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers 'ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:AES';

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }

    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }

    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
}