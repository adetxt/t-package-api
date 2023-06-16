## Getting Started

### Quick Start

- Run `docker compose up -d`

NB:
- you may need to wait a minute until the app totally up
- you can change public port mapping and ENVAR in `docker-compose.yaml`

### Manual

- Run `cp ./.env.example ./.env`
- Adjust the db credentials inside `.env` file
- Run `php artisan serve`

## API DOC

[https://documenter.getpostman.com/view/18749474/2s93sgYB4P](https://documenter.getpostman.com/view/18749474/2s93sgYB4P)

## Test

```shell
php artisan test
```
