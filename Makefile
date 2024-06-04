run:
	docker compose down && docker compose up

connectdb:
	docker exec -it postgresql psql -U root  -d db

