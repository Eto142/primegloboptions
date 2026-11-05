<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warning: Money Laundering</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .modal-dialog {
            margin: 100px auto;
        }
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: 2px solid red;
        }
        .modal-header {
            border-bottom: none;
            background-color: #dc3545;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .modal-footer {
            border-top: none;
        }
        .modal-backdrop {
            opacity: 0.8 !important;
        }
        .modal-body {
            text-align: center;
            padding: 2rem;
        }
        .modal-title {
            font-weight: bold;
        }
        .btn-danger {
            width: 100%;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .icon-warning {
            color: #dc3545;
            font-size: 50px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Modal -->
    <div class="modal fade show" tabindex="-1" role="dialog" aria-modal="true" style="display: block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning: Money Laundering Activity Detected</h5>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation-triangle icon-warning"></i>
                    <p>Suspicious activities have been detected on your account, indicating potential money laundering. Please contact the administrator immediately for further assistance.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('dashboard')}}" class="btn btn-danger">Go to Home</a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('body').append('<div class="modal-backdrop fade show"></div>');
        });
    </script>
</body>
</html>
