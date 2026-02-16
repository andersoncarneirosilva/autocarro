docker logs -f evolution_api

docker compose logs -f evolution-api

docker inspect evolution_api --format='{{.State.Health.Log}}'

# 1. Derruba tudo
docker compose down

# 2. Limpa as pastas físicas (onde o erro 'C' se esconde)
sudo rm -rf ./evolution_instances/*
sudo rm -rf ./evolution_store/*

# 3. Garante permissão total de escrita para a v1.8.2
sudo chmod -R 777 ./evolution_instances ./evolution_store

docker compose up -d

docker compose up -d evolution-api
# Espere 5 segundos e rode o push (o caminho na v1.8.2 é dist/prisma/schema.prisma)
docker exec -it evolution-api npx prisma db push --schema=dist/prisma/schema.prisma --accept-data-loss