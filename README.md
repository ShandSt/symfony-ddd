# Notification Service

A microservice built with Symfony 6.4 implementing Domain-Driven Design and Hexagonal Architecture for handling notifications.

## Architecture

### Hexagonal Architecture (Ports and Adapters)

This project follows the Hexagonal Architecture pattern:

- **Domain Layer**: Core business logic that is framework-agnostic
  - Models: Notification entities
  - Value Objects: NotificationType, NotificationStatus
  - Repository Interfaces: Defines persistence interfaces

- **Application Layer**: Use cases that orchestrate the domain
  - Services: NotificationService implements business operations

- **Ports**: Interfaces that define how the application interacts with the outside world
  - Input Ports: Define operations that can be performed on the application (CreateNotificationInterface)
  - Output Ports: Define how the application communicates with external systems (SendNotificationInterface)

- **Adapters**: Implementations of interfaces for specific technologies
  - Input Adapters: Controllers, CLI commands
  - Output Adapters: Repository implementations, notification senders

### Infrastructure

- **Persistence**: Doctrine ORM implementation
- **External Services**: Email adapter using Symfony Mailer

## API Endpoints

- **Create Notification**
  ```
  POST /api/notifications
  Content-Type: application/json
  
  {
    "recipient": "user@example.com",
    "subject": "Test Subject",
    "content": "This is a test notification",
    "type": "email"
  }
  ```

- **Send Notification**
  ```
  POST /api/notifications/{id}/send
  ```

- **Process Queue**
  ```
  POST /api/notifications/process-queue
  ```

## Docker Configuration

The project includes Docker Compose configuration for:
- MariaDB database (port 33068)
- MailHog SMTP server (port 1025) with web UI (port 8025)

## Integration with Main Application

This service can be integrated with the main application via:
1. RESTful API calls
2. Message queue integration using Symfony Messenger

## Getting Started

1. Start the Docker containers:
   ```bash
   docker-compose up -d
   ```

2. Create and migrate the database:
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

3. Start the development server:
   ```bash
   php -S localhost:8001 -t public/
   ```

## Requirements

- PHP 8.2+
- Composer
- Docker and Docker Compose
- MariaDB 10.6

## Project Structure

This project follows Domain-Driven Design principles with the following layers:

- **Domain Layer** (`src/Domain/`): Contains core business logic, entities, and repository interfaces
- **Application Layer** (`src/Application/`): Contains application services that orchestrate domain objects
- **Infrastructure Layer** (`src/Infrastructure/`): Contains implementations of interfaces defined in the domain layer
- **Presentation Layer** (`src/Presentation/`): Contains controllers and handles HTTP requests/responses

## Development

Start the development server:
```bash
php -S localhost:8000 -t public/
```

## Testing

Run the test suite:
```bash
php bin/phpunit
```

## Environment Configuration

- `.env`: Main environment configuration
- `.env.test`: Test environment configuration

## License

This project is licensed under the MIT License. 