<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KanbanApp</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #6366f1;
        }

        .logo-box {
            background: var(--primary-color);
            color: white;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: 800;
        }

        .logo-text {
            font-weight: 800;
            letter-spacing: -0.5px;
            font-size: 1.25rem;
        }

        #theme-master-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s;
        }

        #theme-master-toggle:hover {
            transform: scale(1.1);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .btn-xs {
            padding: 0.1rem 0.4rem;
            font-size: 0.75rem;
        }
    </style>

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>
</head>

<body class="bg-body-tertiary">

    <button id="theme-master-toggle" title="Alternar Tema">
        <span id="theme-icon">🌙</span>
    </button>

    <div class="min-vh-100 d-flex flex-column">

        <nav class="navbar navbar-expand-lg border-bottom sticky-top bg-body py-3">
            <div class="container-fluid px-4">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none text-white">
                    <div class="logo-box">K</div>
                    <span class="logo-text">
                        KANBAN<span style="color: var(--primary-color)">APP</span>
                    </span>
                </a>

                <div class="ms-auto">
                    @include('layouts.navigation')
                </div>
            </div>
        </nav>

        <main class="flex-grow-1 p-0"> {{-- Ajustado para ocupar melhor o espaço --}}
            {{ $slot }}
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>