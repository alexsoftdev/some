# Задача

Необходимо создать API сервис, который предоставит нужные эндпоинты для системы обработки жалоб клиентов ОСББ.

Сущность жалобы состоит из следующих полей:
- title - заголовок, строка до 150 символов, без спецсимволов
- text - текст проблемы, строка до 3000 символов, символы любые
- client_id - ID клиента, который подает жалобу
- in_work - флаг взятия в работу
- created_at - дата создания
- updated_at - дата последнего обновления, при создании сущности created_at = updated_at

Сущность клиента состоит из
- id
- name - строка 200 символов
- address - строка 1000 символов

Разрботать API эндпоинты, которые позволят:
1. создавать клиента
2. жалобу от клиента
3. получать список жалоб по клиенту
4. взять в работу конкретную жалобу (должно обновить флаг in_work и вернуть объект жалобы)

Авторизация не требуется

# Решение

В папке проекта:

```
docker-compose up -d ( предварительно лучше потушить локальный mysql и nginx, если таковые имеются )
docker-compose exec php composer install
docker-compose exec php bin/console do:mi:mi
```
Приложение готово к использованию.

Добавляем клиента:
```
curl -H "Content-Type: application/json" -X POST -d '{"name":"Gary Oldman","address":"5th element"}' http://localhost/client/
```
{"id":1, ...

Добавляем заявку №1 по клиенту
```
curl -H "Content-Type: application/json" -X POST -d '{"client_id": 1, "title":"stones have been stolen","text":"i am very dissapointed"}' http://localhost/complaint/
```
{"id":1, ...

Добавляем заявку №2 по клиенту
```
curl -H "Content-Type: application/json" -X POST -d '{"client_id": 1, "title":"stones have been stolen","text":"i am very dissapointed"}' http://localhost/complaint/
```
{"id":2, ...

Добавляем заявку №3 по клиенту
```
curl -H "Content-Type: application/json" -X POST -d '{"client_id": 1, "title":"stones have been stolen","text":"i am very dissapointed"}' http://localhost/complaint/
```
{"id":3, ...

Добавляем заявку №4 по клиенту
```
curl -H "Content-Type: application/json" -X POST -d '{"client_id": 1, "title":"stones have been stolen","text":"i am very dissapointed"}' http://localhost/complaint/
```
{"id":4, ...

```
curl "http://localhost/complaint/?client_id=1"
```
[{"id":4,"created_at":"2021-02-25T21:43:50+00:00","in_work":false,"title":"stones have been stolen","text":"i am very dissapointed"},{"id":3,"created_at":"2021-02-25T21:42:56+00:00","in_work":false,"title":"stones have been stolen","text":"i am very dissapointed"},{"id":2,"created_at":"2021-02-25T21:42:35+00:00","in_work":false,"title":"stones have been stolen","text":"i am very dissapointed"},{"id":1,"created_at":"2021-02-25T21:39:48+00:00","in_work":true,"title":"stones have been stolen","text":"i am very dissapointed"}]

```
curl "http://localhost/complaint/?client_id=1&limit=1"
```
[{"id":4,"created_at":"2021-02-25T21:43:50+00:00","in_work":false,"title":"stones have been stolen","text":"i am very dissapointed"}]

```
curl "http://localhost/complaint/?client_id=1&limit=1&offset=2"
```
[{"id":2,"created_at":"2021-02-25T21:42:35+00:00","in_work":false,"title":"stones have been stolen","text":"i am very dissapointed"}]

```
curl -X POST http://localhost/complaint/1/take
```
{"id":1,"created_at":"2021-02-25T21:42:35+00:00","in_work":true,"title":"stones have been stolen","text":"i am very dissapointed"}]

```
curl http://localhost/complaint/1
```
{"id":1,"created_at":"2021-02-25T21:42:35+00:00","in_work":true,"title":"stones have been stolen","text":"i am very dissapointed"}]
