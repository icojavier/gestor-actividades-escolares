### README.md

```markdown
# Gestor de Actividades Escolares

Sistema web desarrollado con Laravel para la gestión de actividades extraescolares, alumnos e inscripciones.

## Características

- ✅ Gestión completa de actividades extraescolares
- ✅ Gestión completa de alumnos
- ✅ Sistema de inscripciones
- ✅ Exportación de reportes en PDF
- ✅ API RESTful pública
- ✅ Búsqueda y filtros
- ✅ Validación de datos
- ✅ Interfaz responsive con Bootstrap 5

## Requisitos del Sistema

- PHP 8.1 o superior
- Composer
- MySQL 5.7 o superior
- Extensiones PHP: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## Instalación

1. **Clonar el proyecto**
   ```bash
   git clone [url-del-repositorio]
   cd gestor-actividades
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Configurar entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar base de datos**
   Editar el archivo `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gestor-actividades
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Ejecutar migraciones y seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Instalar DomPDF para exportación PDF**
   ```bash
   composer require barryvdh/laravel-dompdf
   ```

7. **Iniciar servidor de desarrollo**
   ```bash
   php artisan serve
   ```

8. **Acceder a la aplicación**
   Abrir: http://localhost:8000

## Base de Datos

### Estructura de Tablas

- **actividades**: Almacena las actividades extraescolares
- **alumnos**: Almacena la información de los alumnos
- **inscripciones**: Tabla pivote para las relaciones muchos a muchos

### Seeders

El sistema incluye datos de prueba:
- 4 actividades predefinidas (Robótica, Ajedrez, Pintura, Inglés)
- 5 alumnos de ejemplo

## Uso del Sistema

### Gestión de Actividades
- Crear, editar, ver y eliminar actividades
- Validación de horarios (hora final > hora inicial)
- Días de la semana predefinidos

### Gestión de Alumnos  
- Registrar alumnos con validación de edad (6-18 años)
- Cursos académicos predefinidos
- Control de eliminación (no se puede eliminar si tiene inscripciones)

### Inscripciones
- Inscribir alumnos en actividades
- Evitar inscripciones duplicadas
- Desinscribir alumnos

### Exportación PDF
- Reporte de todas las actividades
- Reporte de alumnos por actividad

### API Pública
- GET `/api-test/actividades` - Lista todas las actividades
- GET `/api-test/status` - Estado del sistema

## Estructura del Proyecto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ActividadController.php
│   │   ├── AlumnoController.php
│   │   └── InscripcionController.php
│   └── Requests/
├── Models/
│   ├── Actividad.php
│   ├── Alumno.php
│   └── Inscripcion.php
database/
├── migrations/
└── seeders/
resources/
└── views/
    ├── layouts/
    ├── actividades/
    ├── alumnos/
    ├── inscripciones/
    └── pdf/
```

## Tecnologías Utilizadas

- **Backend**: Laravel 10, PHP 8.2
- **Frontend**: Bootstrap 5, Blade Templates
- **Base de Datos**: MySQL with Eloquent ORM
- **PDF**: DomPDF
- **Validación**: Laravel Form Requests

## Desarrollador

Sistema desarrollado como proyecto educativo para gestión escolar.

## Licencia

MIT License
```

## Resumen de Funcionalidades Implementadas

✅ **Módulo 1**: Modelo de Datos con 3 tablas y relaciones  
✅ **Módulo 2**: CRUD completo con controladores resource  
✅ **Módulo 3**: Vistas Blade con Bootstrap 5  
✅ **Módulo 4**: Validación y seguridad con FormRequest  
✅ **Módulo 5**: API pública sin autenticación  
✅ **Módulo 6**: Exportación a PDF con DomPDF  
✅ **Módulo 7**: Búsqueda en listado de actividades  
✅ **Módulo 8**: Documentación completa  

**¡El proyecto está completo y funcionando!** 🎉