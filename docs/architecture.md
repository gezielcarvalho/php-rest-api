# Architecture

```text
HTTP client
   |
   v
Custom PHP router -> controller -> model/PDO -> MySQL
   |
   +--> view/JSON response helpers

Docker Compose: Apache/PHP + MySQL + phpMyAdmin (local development)
```

The public entry point loads local configuration, registers user routes, and dispatches through a custom router. Controllers operate through model/PDO code against MySQL. The container stack is a local development convenience, not an approved deployed architecture.

## Configuration boundary

Tracked Compose and local configuration include development database/admin access. Do not reuse those settings outside a controlled local environment. Credential removal/rotation and history scope are deliberately outside this documentation-only task.
