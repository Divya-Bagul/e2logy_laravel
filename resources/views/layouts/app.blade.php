<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Employee Management')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f7fa; }
        .page-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            padding: 1.5rem;
        }
        .employee-name-link {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }
        .employee-name-link:hover { text-decoration: underline; }
        .btn-edit {
            background: #fff;
            border: 1px solid #dee2e6;
            color: #495057;
        }
        .btn-delete {
            background: #fff;
            border: 1px solid #dee2e6;
            color: #dc3545;
        }
        .filter-row .form-control,
        .filter-row .form-select { font-size: 0.875rem; }
        .pagination-custom .page-link { color: #495057; }
        .pagination-custom .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        /* Scrollable responsive employee modal */
        .employee-modal-dialog {
            width: 100%;
            max-width: 480px;
            margin: 1rem auto;
        }
        .employee-modal-content {
            max-height: calc(100vh - 2rem);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .employee-modal-form {
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 2rem);
            overflow: hidden;
        }
        .employee-modal-body {
            overflow-y: auto;
            overflow-x: hidden;
            flex: 1 1 auto;
            -webkit-overflow-scrolling: touch;
            padding-right: 0.25rem;
        }
        .employee-modal-body::-webkit-scrollbar {
            width: 6px;
        }
        .employee-modal-body::-webkit-scrollbar-thumb {
            background-color: #ced4da;
            border-radius: 3px;
        }

        @media (max-width: 576px) {
            .container { padding-left: 0.75rem; padding-right: 0.75rem; }
            .page-card { padding: 1rem; }
            .employee-modal-dialog {
                max-width: 100%;
                margin: 0;
                min-height: 100%;
            }
            .employee-modal-content,
            .employee-modal-form {
                max-height: 100vh;
                min-height: 100vh;
                border-radius: 0;
            }
            .employee-modal-body {
                max-height: none;
            }
        }

        @media (min-width: 577px) and (max-height: 700px) {
            .employee-modal-content,
            .employee-modal-form {
                max-height: calc(100vh - 1rem);
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
