<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Frozen</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
       <div class="gtranslate_wrapper"></div> <script>window.gtranslateSettings = {"default_language":"en","detect_browser_language":true,"wrapper_selector":".gtranslate_wrapper","switcher_horizontal_position":"right","switcher_vertical_position":"top","alt_flags":{"en":"usa","pt":"brazil","es":"colombia","fr":"quebec"}}</script> <script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script>
                    </div>
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
        }
        .modal-header {
            border-bottom: none;
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
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Modal -->
    <div class="modal fade show" tabindex="-1" role="dialog" aria-modal="true" style="display: block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Account Frozen</h5>
                </div>
                <div class="modal-body">
                    <i class="fas fa-user-lock" style="font-size: 50px; color: red; margin-bottom: 20px;"></i>
                    <p>Your account has been frozen. Please contact the administrator for more information.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('dashboard')}}" class="btn btn-primary">Go to Home</a>
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
