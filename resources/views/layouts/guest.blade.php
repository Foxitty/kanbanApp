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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

    <div class="auth-wrapper">
        <div class="text-center mb-4">
            <div class="d-flex align-items-center justify-content-center gap-2">
                <div class="logo-box">K</div>
                <span class="logo-text">
                    KANBAN<span style="color: var(--primary-color)">APP</span>
                </span>
            </div>
        </div>

        <div class="auth-container">
            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>