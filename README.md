# Objetivo del proyecto (versión 1.0)

- Construir desde cero un **micro runtime HTTP en PHP**, con fines educativos, que permita comprender el ciclo completo request-response, el uso de sockets, la arquitectura limpia y las decisiones reales de ingeniería, sin pretender reemplazar servidores de producción.

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

❌ NO INCLUYE

· TLS real
· HTTP/2
· Producción
· Alta concurrencia
· Sustituir Nginx/Apache

## Arquitectura inicial(alto nivel)

Capas previstas:
· Domain -> Request, Response
· Application -> Runtime, Lifecycle
· Infrastructure -> Socket, IO, Config, Logger

Separación total de responsabilidades
Funciones cortas
Nada "Dios-clase"

Este proyecto no está diseñado para su uso en producción.

