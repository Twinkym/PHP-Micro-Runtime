# PHP Micro Runtime HTTP

## 🎯 Propósito del proyecto

PHP Micro Runtime es un **micro runtime HTTP escrito desde cero en PHP**, con fines **educativos**, cuyo objetivo es comprender en profundidad:

- El ciclo completo **request -> response**
- El uso real de **sockets TCP**
- La separación de responsabilidades mediante **arquitectura limpia**
- Las decisiones técnicas que normalmente abstraen los frameworks

> ⚠️ Este proyecto **no está diseñado para uso en producción**
> y **no pretende reemplazar** servidores como Nginx o Apache

---

## 📦 Alcance del proyecto (qué Sí / No)

### ✅ INCLUYE:
- Socket TCP
- Runtime con loop controlado
- Dominio HTTP (`Request` / `Response`)
- Parser HTTP básico
- Routing mínimo
- Configuración externa
- Tests unitarios (PHPUnit)
- Documentación
- Base para CI

### ❌ NO INCLUYE:
- TLS real
- HTTP/2
- Uso en producción
- Alta concurrencia
- Sustitución de servidores web reales (`Nginx` o `Apache`)

---

## 🧱 Arquitectura (alto nivel)

El proyecto está organizado siguiendo una **arquitectura por capas**, con separación estricta de responsabilidades

### Capas
- **Domain**
  - `Request` 
  - `Response`

- **Application**
  - `Runtime`
  - `Router`

- **Infrastructure**
  - `TcpSocket`
  - IO de bajo nivel

### Principios aplicados
- Separación total de responsabilidades
- Funciones y métodos cortos
- Sin clase "Dios"
- Código fácilmente testeable

---

### 🚥 Estado actual

✔️ Runtime HTTP funcional
✔️ Respuestas HTTP/1.1 válidas
✔️ Routing básico con 404
✔️ Tests unitarios en verde
✔️ Arquitectura estable y extensible

---

## ▶️ Cómo ejecutar el runtime

```bash
php bin/runtime
```

En otra terminal:

```bash
curl http://127.0.0.1:8080/
```

---

## 🧪 Ejecutar los tests

```bash
vendor/bin/phpunit
```

---

## 📌 Notas finales
Este proyecto forma parte de un proceso de aprendizaje avanzado orientado a:
- entender qué hay debajo de los frameworks
- mejorar criterio arquitectónico
- escribir código simple, explícito y probado

---

## 🧩 Diagramas

### Arquitectura por capas
```
┌─────────────────────────┐
│ Infrastructure          │
│                         │
│ TcpSocket               │
│ (sockets TCP, IO)       │
└────────────▲────────────┘
             │
┌────────────┴────────────┐
│ Application             │
│                         │
│ Runtime                 │
│ Router                  │
└────────────▲────────────┘
             │
┌────────────┴────────────┐
│ Domain                  │
│                         │
│ Request                 │
│ Response                │
└─────────────────────────┘
```
> Principio Clave:
>
> Las capas superiores no dependen de las inferiores.

---

### 🔁 Flujo request -> response
```
Client (curl / browser)
         │
         ▼
   TcpSocket.accept()
         │
         ▼
       Runtime
         │
         ▼
    Request::fromRaw()
         │
         ▼
       Router
         │
         ▼
     Response
         │
         ▼
  Response::toHttpString()
         │
         ▼
      Client
```

> Este flujo es lineal, explicito y testeable.

---

## 🧠 Decisiones técnicas

### ¿Por qué no usar un framework?
Porque el objetivo de proyecto es **entender lo que abstraen** los frameworks:
- sockets.
- ciclo de vida del servidor.
- parsing HTTP.
- Routing básico.

---

### ¿Por qué arquitectura por capas?
Para:
- separar responsabilidades.
- facilitar el testing.
- permitir refactor sin miedo.
- evitar clases monolíticas.

---

### ¿Por qué tests unitarios y no de integración?
Porque:
- El objetivo es validar **comportamiento del dominio**.
- Los sockets y el runtime se consideran infraestructura.
- Los tests deben ser rápidos, deterministas y simples.

--- 

### ¿Por qué routing explícito?
Porque:
- Evita magia.
- Hace visibles las decisiones.
- facilita el aprendizaje.
-  Refleja cómo funcionan los  routers internamente.

---

## 🛣️ Roadmap

### Posibles mejoras futuras
- Headers configurables en `Response`.
- Soporte básico para JSON.
- Middlewares simples.
- Logging estructurado.
- Manejo básico de errores.
- Señales de parada del runtime.

---

### Explicitamente fuera de alcance
- HTTP/2.
- TLS.
- Concurrencia real.
- Uso en producción.