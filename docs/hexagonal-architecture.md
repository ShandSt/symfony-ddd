# Hexagonal Architecture in Our Symfony Project

## Overview

Hexagonal Architecture (also known as Ports and Adapters pattern) is a software architectural pattern that allows an application to be equally driven by users, programs, automated tests, or batch scripts, and to be developed and tested in isolation from its eventual run-time devices and databases.

## Structure

Our implementation follows these key components:

1. **Domain Layer** - The core business logic
2. **Ports** - Interfaces that define how the application interacts with the outside world
3. **Adapters** - Implementations of ports that connect the application to external systems
4. **Application Services** - Orchestrators that coordinate domain objects and ports

## Layers

### Domain

This is the heart of our application, containing business logic independent of external concerns:

- `src/Domain/Model/` - Core business entities
- `src/Domain/ValueObject/` - Immutable objects representing domain concepts
- `src/Domain/Event/` - Domain events (if implemented)
- `src/Domain/Exception/` - Domain-specific exceptions

### Ports

Interfaces that define how the application communicates with the outside world:

- `src/Port/Input/` - Defines how the external world can interact with our application
- `src/Port/Output/` - Defines how our application interacts with external systems

### Adapters

Implementations of the ports:

- `src/Infrastructure/` - Contains output adapters (databases, external APIs)
- `src/Presentation/` - Contains input adapters (controllers, CLI commands)

### Application

Services that orchestrate domain objects and ports:

- `src/Application/Service/` - Application services that implement use cases

## Benefits of This Architecture

1. **Separation of Concerns** - Clear boundaries between the domain and infrastructure
2. **Testability** - Easy to test business logic in isolation
3. **Flexibility** - Easily swap implementations (e.g., switch from MySQL to PostgreSQL)
4. **Maintainability** - Well-organized code with clear responsibilities

## Example Flow

1. Request comes in through a Controller (input adapter)
2. Controller calls an Application Service through an Input Port
3. Application Service coordinates domain objects and calls Output Ports
4. Output Adapters implement Output Ports to interact with external systems
5. Response follows the reverse path back to the client

## Dependency Injection Configuration

Dependency injection is configured in `config/services.yaml` to wire interfaces to their implementations.

```yaml
# Example port-adapter bindings
App\Port\Input\UserServiceInterface:
    class: App\Application\Service\UserService

App\Port\Output\UserRepositoryInterface:
    class: App\Infrastructure\Repository\DoctrineUserRepository
    
App\Port\Output\NotificationInterface:
    class: App\Infrastructure\Adapter\EmailAdapter
``` 