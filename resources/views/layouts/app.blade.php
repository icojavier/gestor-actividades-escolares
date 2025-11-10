<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Actividades Escolares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .navbar {
            background: linear-gradient(145deg, #0d1b3e, #152a5e) !important;
            box-shadow:
                0 8px 25px rgba(0, 0, 0, 0.4),
                0 0 15px rgba(0, 0, 0, 0.3) inset,
                0 2px 0 rgba(255, 255, 255, 0.1);
            border-bottom: 3px solid rgba(255, 255, 255, 0.15);
            position: relative;
        }
        .navbar::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg,
                rgba(255,255,255,0.1) 0%,
                rgba(255,255,255,0.3) 50%,
                rgba(255,255,255,0.1) 100%);
            border-radius: 0 0 5px 5px;
        }
        .dashboard-card {
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
        }
        .dashboard-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }
        .nav-link {
            border-radius: 8px;
            margin: 0 0.3rem;
            padding: 0.6rem 1.2rem !important;
            font-weight: 700;
            transition: all 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            box-shadow:
                0 4px 8px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.1) inset;
        }
        .nav-link.actividades {
            background: linear-gradient(145deg, #5e35b1, #4527a0) !important;
            color: white !important;
        }
        .nav-link.alumnos {
            background: linear-gradient(145deg, #2e7d32, #1b5e20) !important;
            color: white !important;
        }
        .nav-link.inscripciones {
            background: linear-gradient(145deg, #455a64, #37474f) !important;
            color: white !important;
        }
        .nav-link:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow:
                0 6px 15px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.2) inset;
            filter: brightness(1.1);
        }
        .nav-link.active {
            box-shadow:
                0 0 0 3px rgba(255, 255, 255, 0.4),
                0 6px 15px rgba(0, 0, 0, 0.3);
            transform: scale(1.05);
        }
        .btn-actividades {
            background: linear-gradient(145deg, #5e35b1, #4527a0);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(94, 53, 177, 0.3);
        }
        .btn-alumnos {
            background: linear-gradient(145deg, #2e7d32, #1b5e20);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(46, 125, 50, 0.3);
        }
        .btn-inscripciones {
            background: linear-gradient(145deg, #455a64, #37474f);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(69, 90, 100, 0.3);
        }
        .btn-actividades:hover, .btn-alumnos:hover, .btn-inscripciones:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            filter: brightness(1.1);
        }
        .card-actividades {
            border-left: 6px solid #5e35b1;
            background: linear-gradient(135deg, #f8f9fa, #e8eaf6);
        }
        .card-alumnos {
            border-left: 6px solid #2e7d32;
            background: linear-gradient(135deg, #f8f9fa, #e8f5e8);
        }
        .card-inscripciones {
            border-left: 6px solid #455a64;
            background: linear-gradient(135deg, #f8f9fa, #eceff1);
        }
        .stat-card {
            background: linear-gradient(135deg, #ffffff, #f1f3f4);
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <!-- Casita a la izquierda -->
            <a class="navbar-brand me-3" href="{{ route('dashboard') }}">
                <i class="bi bi-house-fill fs-3"></i>
            </a>

            <!-- Título centrado -->
            <span class="navbar-brand mx-auto fs-2">
                Gestor de Actividades Escolares
            </span>

            <!-- Botones a la derecha -->
            <div class="navbar-nav ms-auto flex-row">
                <a class="nav-link actividades me-3 {{ request()->routeIs('actividades.*') ? 'active' : '' }}"
                   href="{{ route('actividades.index') }}">
                    <i class="bi bi-calendar-event me-2"></i>Actividades
                </a>
                <a class="nav-link alumnos me-3 {{ request()->routeIs('alumnos.*') ? 'active' : '' }}"
                   href="{{ route('alumnos.index') }}">
                    <i class="bi bi-people me-2"></i>Alumnos
                </a>
                <a class="nav-link inscripciones {{ request()->routeIs('inscripciones.*') ? 'active' : '' }}"
                   href="{{ route('inscripciones.create') }}">
                    <i class="bi bi-clipboard-check me-2"></i>Inscripciones
                </a>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="container-fluid py-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
