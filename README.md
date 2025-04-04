# Symfony DDD Application

A Domain-Driven Design (DDD) application built with Symfony 6.4 and MariaDB.

## Project Structure

This project follows Domain-Driven Design principles with the following layers:

- **Domain Layer** (`src/Domain/`): Contains core business logic, entities, and repository interfaces
- **Application Layer** (`src/Application/`): Contains application services that orchestrate domain objects
- **Infrastructure Layer** (`src/Infrastructure/`): Contains implementations of interfaces defined in the domain layer
- **Presentation Layer** (`src/Presentation/`): Contains controllers and handles HTTP requests/responses

## Requirements

- PHP 8.2+
- Composer
- Docker and Docker Compose
- MariaDB 10.6

## Installation

1. Clone the repository:
   ```bash
   git clone git@github.com:ShandSt/symfony_ddd.git
   cd symfony_ddd
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Start the Docker containers:
   ```bash
   docker-compose up -d
   ```

4. Create the databases:
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:database:create --env=test
   ```

5. Run migrations:
   ```bash
   php bin/console doctrine:migrations:migrate -n
   ```

## Development

Start the development server:
```bash
php -S localhost:8000 -t public/
```

## API Endpoints

### Users

- **Create User**
  ```
  POST /api/users
  Content-Type: application/json
  
  {
    "email": "user@example.com",
    "name": "User Name"
  }
  ```

- **Get User**
  ```
  GET /api/users/{id}
  ```

## Testing

Run the test suite:
```bash
php bin/phpunit
```

## Docker Configuration

The project includes Docker Compose configuration for MariaDB databases:

- Main database: `symfony_ddd` (port 33066)
- Test database: `soil_v3_test` (port 33067)

## Environment Configuration

- `.env`: Main environment configuration
- `.env.test`: Test environment configuration

## License

This project is licensed under the MIT License. 