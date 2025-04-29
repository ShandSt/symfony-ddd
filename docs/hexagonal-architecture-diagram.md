# Hexagonal Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────────────┐
│                               EXTERNAL WORLD                             │
│  ┌───────────────┐                                     ┌───────────────┐ │
│  │   HTTP/Web    │                                     │   Database    │ │
│  │    Client     │                                     │  PostgreSQL   │ │
│  └───────┬───────┘                                     └───────┬───────┘ │
└──────────┼─────────────────────────────────────────────────────┼────────┘
           │                                                     │
           ▼                                                     │
┌──────────────────┐                                             │
│                  │                                             │
│ Presentation     │                                             │
│ Layer            │                                             │
│ (Input Adapters) │                                             │
│                  │                                             │
│ ┌──────────────┐ │                                             │
│ │ Controllers  │ │                                             │
│ └──────┬───────┘ │                                             │
│        │         │                                             │
└────────┼─────────┘                                             │
         │                                                       │
         ▼                                                       │
┌────────────────────────────────────────────────┐              │
│                                                │              │
│   ┌────────────────────────────────────┐       │              │
│   │          Application Layer          │       │              │
│   │                                     │       │              │
│   │    ┌───────────────────────────┐   │       │              │
│   │    │     Application Services   │   │       │              │
│   │    └────────────┬──────────────┘   │       │              │
│   │                 │                  │       │              │
│   └─────────────────┼──────────────────┘       │              │
│                     │                          │              │
│                     ▼                          │              │
│   ┌────────────────────────────────────┐       │              │
│   │           Domain Layer             │       │              │
│   │  ┌────────────┐  ┌─────────────┐   │       │              │
│   │  │   Models   │  │ValueObjects │   │       │              │
│   │  └────────────┘  └─────────────┘   │       │              │
│   │                                     │       │              │
│   └────────────────────────────────────┘       │              │
│                                                │              │
└────────────────────────────────────────────────┘              │
                                                               │
                    ┌─────────────────────────────────────┐    │
                    │                                     │    │
                    │  ┌─────────────────────────────┐    │    │
                    │  │         PORT LAYER           │    │    │
                    │  │                             │    │    │
                    │  │  ┌─────────────────────┐    │    │    │
                    │  │  │    Input Ports      │──┐ │    │    │
                    │  │  └─────────────────────┘  │ │    │    │
                    │  │                           │ │    │    │
                    │  │  ┌─────────────────────┐  │ │    │    │
                    │  │  │    Output Ports     │◀─┘ │    │    │
                    │  │  └──────────┬──────────┘    │    │    │
                    │  │             │               │    │    │
                    │  └─────────────┼───────────────┘    │    │
                    │                │                    │    │
                    └────────────────┼────────────────────┘    │
                                     │                         │
                                     ▼                         ▼
                    ┌─────────────────────────────────────────────┐
                    │                                             │
                    │  Infrastructure Layer (Output Adapters)     │
                    │                                             │
                    │  ┌─────────────────┐  ┌─────────────────┐   │
                    │  │Doctrine Repos   │  │Email/SMS Senders│   │
                    │  └─────────────────┘  └─────────────────┘   │
                    │                                             │
                    └─────────────────────────────────────────────┘
```

## Key Points

1. **Domain and Application Layers** are at the core
2. **Port Layer** defines interfaces:
   - Input Ports (called by controllers)
   - Output Ports (implemented by infrastructure)
3. **Adapters** implement the communication:
   - Input Adapters (controllers, APIs, CLI)
   - Output Adapters (repositories, external services)
4. **Flow of control**:
   - External → Input Adapter → Input Port → Application Service → Domain → Output Port → Output Adapter → External System
5. **Dependencies** always point inward (toward the domain) 