Gestor de Actividades Extraescolares
📋 Descripción del Proyecto
Sistema completo de gestión para actividades extraescolares que permite administrar un catálogo de actividades (robótica, ajedrez, pintura, inglés) y gestionar las inscripciones de alumnos. Desarrollado con Laravel siguiendo arquitectura MVC.

🚀 Características Principales
Módulos Implementados
✅ Módulo 1: Modelo de Datos con 3 tablas (Actividades, Alumnos, Inscripciones)

✅ Módulo 2: CRUD Completo con Laravel

✅ Módulo 3: Vistas Blade con Bootstrap 5

✅ Módulo 4: Validación y Seguridad

✅ Módulo 5: API Pública sin autenticación

✅ Módulo 6: Exportación a PDF

✅ Módulo 7: Sistema de Búsqueda

✅ Módulo 8: Documentación Completa

🛠️ Tecnologías Utilizadas
Backend: Laravel 10, PHP 8.1+

Frontend: Bootstrap 5, Blade Templates

Base de Datos: MySQL

PDF: Laravel DomPDF

Servidor: Apache (XAMPP)

📦 Instalación y Configuración
Prerrequisitos
PHP 8.1 o superior

Composer

MySQL

XAMPP (recomendado para desarrollo)

Paso a Paso de Instalación bash
# 1. Clonar el proyecto
git clone <[url-del-repositorio](https://github.com/icojavier/gestor-actividades-escolares.git)>
cd gestor-actividades

# 2. Instalar dependencias de Composer
composer install

# 3. Renombrar archivo de entorno
cambiar .env.example por .env

# 4. Configurar base de datos en .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestor-actividades
DB_USERNAME=root
DB_PASSWORD=

# 5. Generar clave de aplicación
php artisan key:generate

# 6. Crear base de datos manualmente en XAMPP
# - Abrir http://localhost/phpmyadmin
# - Crear base de datos: 'gestor-actividades'

# 7. Ejecutar migraciones y seeders
php artisan migrate --seed

# 8. Iniciar servidor de desarrollo
php artisan serve
Acceso a la Aplicación
URL Local: http://localhost:8000

Credenciales por defecto: Consultar en DatabaseSeeder.php

🗃️ Estructura de la Base de Datos
Tablas Principales
Actividades
id - Identificador único

nombre - Nombre de la actividad

descripcion - Descripción detallada

dia_semana - Día de la semana

hora_inicio - Formato HH:MM

hora_fin - Formato HH:MM (validación > hora_inicio)

created_at, updated_at - Timestamps

Alumnos
id - Identificador único

nombre_completo - Nombre completo

curso_academico - Dropdown con opciones:

1º Primaria a 6º Primaria

1º ESO a 4º ESO

1º Bachillerato a 2º Bachillerato

edad - Validación: entre 6 y 18 años

created_at, updated_at - Timestamps

Inscripciones
id - Identificador único

alumno_id - FK a alumnos (relación belongsTo)

actividad_id - FK a actividades (relación belongsTo)

created_at, updated_at - Timestamps

📊 Relaciones de Base de Datos
php
// Modelo Actividad
public function alumnos() {
    return $this->belongsToMany(Alumno::class, 'inscripciones');
}

// Modelo Alumno  
public function actividades() {
    return $this->belongsToMany(Actividad::class, 'inscripciones');
}

// Modelo Inscripcion
public function alumno() {
    return $this->belongsTo(Alumno::class);
}

public function actividad() {
    return $this->belongsTo(Actividad::class);
}
🎯 Rutas Disponibles
Rutas Web
text
GET    /                       → Dashboard principal
GET    /actividades            → Listado de actividades
POST   /actividades            → Crear actividad
GET    /actividades/create     → Formulario crear actividad
GET    /actividades/{id}       → Ver actividad específica
PUT    /actividades/{id}       → Actualizar actividad
DELETE /actividades/{id}       → Eliminar actividad
GET    /actividades/{id}/edit  → Formulario editar actividad

GET    /alumnos                → Listado de alumnos
POST   /alumnos                → Crear alumno
GET    /alumnos/create         → Formulario crear alumno
GET    /alumnos/{id}           → Ver alumno específico
PUT    /alumnos/{id}           → Actualizar alumno
DELETE /alumnos/{id}           → Eliminar alumno
GET    /alumnos/{id}/edit      → Formulario editar alumno

POST   /inscripciones          → Crear inscripción
GET    /inscripciones/create   → Formulario inscripción
DELETE /inscripciones/{id}     → Eliminar inscripción

GET    /export/actividades              → Exportar todas las actividades (PDF)
GET    /export/actividad/{id}/alumnos   → Exportar alumnos por actividad (PDF)
GET    /export/alumnos                  → Exportar todos los alumnos (PDF)
GET    /export/alumno/{id}/actividades  → Exportar actividades por alumno (PDF)
API Endpoints
text
GET /api/actividades    → Lista de actividades (JSON)
GET /api/alumnos        → Lista de alumnos (JSON)  
GET /api/estadisticas   → Estadísticas del sistema (JSON)
GET /api/status         → Status de la aplicación (JSON)
🔍 Funcionalidades de Búsqueda
Búsqueda en actividades: Por nombre de actividad

Dropdowns inteligentes: En inscripciones, búsqueda + dropdown de alumnos y actividades

Validación en tiempo real: No permite inscripciones duplicadas

📄 Exportación a PDF
Características de Exportación
Listado completo de actividades

Alumnos inscritos por actividad

Actividades por alumno

Diseño responsive y profesional

Logo institucional (si está configurado)

Uso
bash
# Exportar todas las actividades
http://localhost:8000/export/actividades

# Exportar alumnos de una actividad específica
http://localhost:8000/export/actividad/1/alumnos

# Exportar actividades de un alumno específico
http://localhost:8000/export/alumno/1/actividades
🛡️ Validaciones Implementadas
Actividades
Nombre: requerido, máximo 255 caracteres

Descripción: requerido

Día semana: requerido

Hora inicio: requerido, formato HH:MM

Hora fin: requerido, formato HH:MM, mayor que hora inicio

Alumnos
Nombre completo: requerido, máximo 255 caracteres

Curso académico: requerido, en lista predefinida

Edad: requerido, numérico, entre 6 y 18 años

Inscripciones
Alumno: requerido, existe en BD

Actividad: requerido, existe en BD

No duplicados: mismo alumno no puede inscribirse dos veces en misma actividad

Restricción eliminación: no se puede eliminar actividad con alumnos inscritos

🎨 Interfaz de Usuario
Características
Diseño responsive con Bootstrap 5

Navegación intuitiva

Mensajes de confirmación y error

Formularios con validación visual

Tablas paginadas

Modales para confirmaciones

Vistas Principales
Dashboard: Vista general del sistema

Listados: Tablas con paginación y búsqueda

Formularios: Crear/editar con validación

Detalles: Vista individual de registros

🔧 Comandos Artisan Útiles
bash
# Ejecutar migraciones con datos de prueba
php artisan migrate:fresh --seed

# Ejecutar solo seeders específicos
php artisan db:seed 

# Ver todas las rutas disponibles
php artisan route:list

# Limpiar cache de la aplicación
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Generar PDF de prueba
php artisan tinker
>>> PDF::loadHTML('<h1>Test</h1>')->save('test.pdf');
🐛 Solución de Problemas Comunes
Error: "Base de datos no existe"
bash
# Crear manualmente la BD en phpMyAdmin
# O ejecutar:
mysql -u root -p -e "CREATE DATABASE \`gestor-actividades\`;"
cambiar el nombre al archivo .env.example a .env
editar en .env DB_CONNECTION=mysql y DB_DATABASE=gestor-actividades
php artisan key:generate
Error en migraciones
bash
php artisan migrate:fresh
php artisan db:seed
bash
# Verificar que el servidor esté corriendo
php artisan serve

# Probar directamente en navegador
http://localhost:8000/api/actividades
📝 Estructura de Archivos Importantes
text
app/
├── 📂 Models/
│   ├── ✅ Actividad.php
│   ├── ✅ Alumno.php
│   ├── ✅ Inscripcion.php
│   └── User.php
├── 📂 Http/
│   ├── 📂 Controllers/
│   │   ├── 📂 Api/
│   │   ├── ✅ ActividadController.php
│   │   ├── ✅ AlumnoController.php
│   │   ├── Controller.php
│   │   ├── ✅ InscripcionController.php
│   │   └── ✅ PdfExportController.php
│   └── 📂 Requests/
│       ├── ✅ StoreActividadRequest.php
│       ├── ✅ StoreAlumnoRequest.php
│       ├── ✅ UpdateActividadRequest.php
│       └── ✅ UpdateAlumnoRequest.php
└── 📂 Providers/
    └── AppServiceProvider.php

🗃️ DATABASE/ - Base de Datos
database/
├── 📂 migrations/
│   ├── ✅ 2025_11_07_005521_create_actividades_table.php
│   ├── ✅ 2025_11_07_005741_create_alumnos_table.php
│   ├── ✅ 2025_11_07_005928_create_inscripciones_table.php
│   └── ...tablas de sistema
├── 📂 seeders/
│   ├── ✅ ActividadesTableSeeder.php
│   ├── ✅ AlumnosTableSeeder.php
│   └── ✅ DatabaseSeeder.php
└── 📂 factories/

🎨 RESOURCES/ - Vistas y Assets
resources/
├── 📂 views/
│   ├── 📂 actividades/        # CRUD actividades
│   ├── 📂 alumnos/           # CRUD alumnos
│   ├── 📂 inscripciones/     # Gestión inscripciones
│   ├── 📂 layouts/           # Plantilla base
│   ├── 📂 pdf/               # Vistas para exportación
│   │   ├── ✅ actividad-alumnos.blade.php
│   │   ├── ✅ all-actividades.blade.php
│   │   ├── ✅ all-alumnos.blade.php
│   │   └── ✅ alumno-actividades.blade.php
│   ├── ✅ dashboard.blade.php
│   └── welcome.blade.php
├── 📂 css/
└── 📂 js/

🛣️ ROUTES/ - Rutas de la Aplicación
routes/
├── ✅ web.php    # Rutas web (vistas Blade)
├── ✅ api.php    # Rutas API
└── console.php

👥 Roles y Permisos
El sistema está diseñado para un solo rol de administrador que puede:

Gestionar completamente actividades y alumnos

Realizar inscripciones

Exportar reportes

Acceder a todas las funcionalidades

🔄 Flujo de Trabajo Típico
Crear actividades → Definir horarios y detalles

Registrar alumnos → Completar información académica

Gestionar inscripciones → Asignar alumnos a actividades

Generar reportes → Exportar listados en PDF

Consultar APIs → Obtener datos en formato JSON

¿Problemas con la instalación? Revisa la sección "Solución de Problemas Comunes".
