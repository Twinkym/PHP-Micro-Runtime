# Objetivo del proyecto (versión 1.0)

- Construir desde cero un **micro runtime HTTP en PHP**, con fines educativos, que permita comprender el ciclo completo request-response, el uso de sockets, la arquitectura limpia y las decisiones reales de ingenieria, sin pretender reemplazar servidores de producción.

## Alcance (qué Sí / No)

✅ INCLUYE
· Socket TCP
· Request/Response
· Parser HTTP básico
· Configuración externa
· Logs
· Tests
· Documentación
· CI básico

❌ NO INCLUYR
· TLS real
· HTTP/2
· Producción
· Alta concurrencia
· Sustituir Ngix/Apache

## Arquitectura inicial(alto nivel)

Capas previstas:
· Domain -> Request, Response
· Application -> Runtime, Lifecycle
· Infrastructure -> Socket, IO, Config, Logger

Separación total de resposabilidades
Funciones cortas
Nada "Dios-clase"

