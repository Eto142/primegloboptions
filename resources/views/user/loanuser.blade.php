@include('user.header')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <style>
        .content-body {
            padding: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
        }
        .form-head h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: 500;
        }
        .form-control {
            height: calc(2.5rem + 2px);
        }
        .btn-submit {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="content-body">
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @elseif (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif



<div class="container form-container">
    <div class="form-head mb-4">
        <h2 class="text-center">Upload Documents</h2>
    </div>
    <form action="{{route('user.loans.continue.loan')}}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Add this for CSRF protection -->

        <input type="hidden" class="form-control" name="amount" value="{{ $data['amount'] }}"/>
        <input type="hidden" class="form-control" name="reason" value="{{ $data['reason'] }}"/>
         <input type="hidden" class="form-control" name="email" value=" {{ Auth::user()->email}}"/>

        <div class="form-group">
            <label for="license">
                <i class="fa fa-id-card"></i> Driver's License:
            </label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" id="license" name="license" class="custom-file-input" accept="image/*" required>
                    <label class="custom-file-label" for="license">Choose file</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="photoID">
                <i class="fa fa-address-card"></i> Photo ID:
            </label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" id="photoID" name="photoID" class="custom-file-input" accept="image/*" required>
                    <label class="custom-file-label" for="photoID">Choose file</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="selfie">
                <i class="fa fa-camera"></i> Selfie:
            </label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" id="selfie" name="selfie" class="custom-file-input" accept="image/*" required>
                    <label class="custom-file-label" for="selfie">Choose file</label>
                </div>
            </div>
        </div>

        @if (Auth::check() && Auth::user()->country === 'United States')
        <div class="form-group">
            <label for="ssn">
                <i class="fa fa-user-secret"></i> SSN:
            </label>
            <input type="text" id="ssn" name="ssn" class="form-control" placeholder="Enter SSN">
        </div>
        @endif
        
         @if (Auth::check() && Auth::user()->country === 'United States')
        <div class="form-group">
            <label for="ssn">
                <i class="fa fa-credit-score"></i> Credit Score:
            </label>
            <input type="number" id="ssn" name="credit_score" class="form-control" placeholder="Enter Credit Score">
        </div>
        @endif

        <button type="submit" class="btn btn-primary btn-submit">
            <i class="fa fa-cloud-upload"></i> Submit
        </button>
    </form>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="vendor/chart.js/Chart.bundle.min.js"></script>

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>

    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>
    <script src="js/demo.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--<script src="js/styleSwitcher.js"></script>-->
    <script src="./js/app/app.js"></script>
  
    <script>
        (function($) {
            var table = $('#example5').DataTable({
                searching: false,
                paging: true,
                select: false,
                //info: false,         
                lengthChange: false

            });
            $('#example tbody').on('click', 'tr', function() {
                var data = table.row(this).data();

            });
        })(jQuery);
    </script>


</body>

</html>