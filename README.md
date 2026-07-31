# To do List con PHP + PostgreSQL

Aplicación web de lista de tareas hecha con HTML, CSS, PHP y PostgreSQL, las tareas se guardan en la base de datos y persisten al recargar la página.
Parte del código fue reciclado de la tarea del otro To do List (del módulo de JavaScript)

## Funcionalidades

- Agregar tareas nuevas (botón o tecla Enter).
- Marcar tareas como completadas (clic sobre el texto).
- Eliminar tareas.
- Al recargar la página, las tareas se restauran desde la base de datos.

## Estructura del proyecto

```
todo-php/
├── index.php           → Página principal (PHP renderiza las tareas al cargar)
├── styles.css          → Estilos de la interfaz
├── script.js           → Lógica del cliente (fetch a la API)
├── config/
│   └── db.php          → Conexión PDO a PostgreSQL (require_once)
└── api/
    ├── tareas.php      → GET  — devuelve todas las tareas
    ├── agregar.php     → POST — inserta una nueva tarea
    ├── eliminar.php    → POST — elimina una tarea por ID
    └── completar.php   → POST — actualiza el estado completada
```

### 2. Crear la tabla en PostgreSQL

Abre **pgAdmin**, selecciona la base de datos **PHP** y ejecuta el contenido:

```sql
CREATE TABLE IF NOT EXISTS tareas (
  id          SERIAL        PRIMARY KEY,
  texto       VARCHAR(255)  NOT NULL,
  completada  SMALLINT      NOT NULL DEFAULT 0,
  created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```