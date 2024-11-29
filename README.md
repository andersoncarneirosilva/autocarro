
# Setup Docker Para Projetos Laravel (8, 9 ou 10)

### Passo a passo
Clonar repositório das config docker
```sh
git clone https://github.com/andersonseidler/setup-docker-laravel.git
```

Clonar os arquivos do Laravel
```sh
git clone https://github.com/andersonseidler/laravel.git laradoc
```


Copie os arquivos docker-compose.yml, Dockerfile e o diretório docker/ para a pasta laradoc
```sh
cp -rf setup-docker-laravel/* laradoc/
```
```sh
cd laradoc/
```


Criar uma cópia do arquivo .env
```sh
cp .env.example .env
```


Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME="Portal Laradoc"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=dblaradoc
DB_USERNAME=root
DB_PASSWORD=root

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
FILESYSTEM_DISK=public
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379


```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acessar o container
```sh
docker-compose exec app bash
```


Instalar as dependências do projeto
```sh
composer install
```

Caso não execute o composer install, execute as dependências primeiro.


Gerar a key do projeto Laravel
```sh
php artisan key:generate
```

Executar as migrations dentro do container app

```sh
php artisan migrate
```

Rodas as Seeders necessárias
```sh
php artisan db:seed UserSeeder
```

Criar um link para a pasta storage na public. Caso já exista, desconsidere o comando.
```sh
php artisan storage:link
```
Utilizar o comando para dar permissão ao user
```sh
sudo chown -R "${USER:-$(id -un)}" .
```
Acessar o projeto
[http://localhost:8989](http://localhost:8989)# proconline
