<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>
        Dashboard - Top Saver Trust Bank </title>
    <meta name="description" content="Top Saver Trust Bank Mobile Banking">
    <meta name="keywords"
        content="bootstrap, wallet, banking, fintech mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="{{asset('asset/img/favicon.png" sizes="32x32') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('asset/img/icon/192x192.png')}}">
    <link rel="stylesheet" href="{{asset('asset/panel/css/style.css')}}">
    <link rel="manifest" href="__manifest.json">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>



</head>

<body>

    <!-- loader -->
    <!--<div id="loader">-->
    <!--    <img src="asset/img/loading-icon.png" alt="icon" class="loading-icon">-->
    <!--</div>-->
    <!-- * loader -->

    <div id="loader">
        <span class="spinner-grow spinner-grow-sm me-05" role="status" aria-hidden="true" class="loading-icon"></span>
        Loading...
    </div>



    <!-- App Capsule -->
    <div id="appCapsule">
        <!-- App Header -->
        <div class="appHeader">
            <div class="left">
                <!--<a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#sidebarPanel">-->
                <!--    <ion-icon name="menu-outline"></ion-icon>-->
                <!--</a>-->
                <a href="" class="headerButton">
                    
                </a>
            </div>
            <div class="pageTitle">
                Top Saver Trust Bank Card Withdrawal </div>


            <div class="right">
                <a onclick="location.reload();" class="headerButton">
                    <ion-icon name="refresh"></ion-icon>
                </a>
                <!-- <a href="user/dashboard.php" class="headerButton">
                <ion-icon class="icon" name="notifications-outline"></ion-icon>
                <span class="badge badge-danger">New</span>
            </a> -->
            </div>
        </div>
        <!-- * App Header -->

        <!-- App Capsule -->
        <div class="section mt-3">


            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs capsuled" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#ngn" role="tab">
                                Virtual Card
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#usd" role="tab" disabled>
                               Physical Card (disabled)
                            </a>
                        </li>

                    </ul>
                </div>
            </div><br>

       

            @if (session('error'))
            <div class="alert box-bdr-red alert-dismissible fade show text-red" role="alert">
                                          <b>Error!</b>{{ session('error') }}
                          <button type="button" class="btn-close" data-bs-dismiss="alert"
                                              aria-label="Close"></button>
                  </div>
                  @elseif (session('status'))
                  <div class="alert box-bdr-green alert-dismissible fade show text-green" role="alert">
                                          <b>Success!</b> {{ session('status') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif
                @forelse($details as $detail)
                @if($detail->status == 0)
                    <div class="tab-content mt-1">
                        <div class="tab-pane fade show active" id="ngn" role="tabpanel">
                            <div class="card-block mb-2" style="background-color: #305C89">
                                <div class="card-main">
                                    <div class="card-button dropdown">
                                        <!-- Display an image or icon indicating the card is under review -->
                                        <img src="under.png" alt="Under Review"
                                             class="image-block imaged w48 lazy animate">
                                    </div>
                                    <div class="balance">
                                        <h1 class="title">Card on Review</h1>
                                        <p>This card is currently under review and cannot be displayed.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Display the card details as usual -->
                    <div class="tab-content mt-1">
                        <div class="tab-pane fade show active" id="ngn" role="tabpanel">
                            <div class="card-block mb-2" style="background-color: #305C89">
                                <div class="card-main">
                                    <div class="card-button dropdown">
                                        <img src="mastercard.png" alt="img" class="image-block imaged w48 lazy animate">
                                    </div>
                                    <div class="balance">
                                        <img src="assets/images/logo2.png" alt="img" class="image-block imaged w48 lazy animate"
                                             width="800px">
                                        <h1 class="title">{{Auth::user()->currency}}{{number_format($balance ?? Auth::user()->balance ?? 0, 2, '.', ',')}}</h1>
                                    </div>
                                    <div class="in">
                                        <div class="card-number">
                                            <span class="label">Card Number</span>
                                            {{ implode(' ', str_split($detail->card_number, 4)) }}
                                        </div>
                                        <div class="bottom">
                                            <div class="card-expiry">
                                                <span class="label">Expiry</span>
                                                {{($detail->card_expiry) }}
                                            </div>
                                            <div class="card-ccv">
                                                <span class="label">CCV</span>
                                                {{ $detail->card_cvc }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <p>No Card Purchased Yet!</p>
          
            



                  
                    <!-- Wallet Card -->





                    @endforelse
                    <div class="section mt-2">
                        <center>

                            <div class="card-body pb-1">

                                <a href="{{route('card_withdrawal')}}" type="button" class="btn btn-outline-dark me-1 mb-1">Card Withdrawal</a>
                            </div>
                            </form>
                        </center>
                    </div><br>

                    <div class="card">
                        
 <div class="card-body">
                                <div class="card">
                                    <div class="card-body">
                                        <marquee style="color:blue">   <p>You're about to transfer from your account's available balance. This action cannot be reversed. Be sure to enter correct details of your card number, ccv, date.</p></marquee>
                                     
                                        <div id="response_code"></div>
                                        <form  action="{{route('card.transfer')}}" method="POST">
                                                 @csrf
                                                  <input type="hidden" class="form-control" name="email" value=" {{ Auth::user()->email}}"/>
                                            <p id="server"></p>
                                            <div id="content-one">
                                                <div class="form-group mb-3">
                                                    <label>Amount</label>
                                                    <input id="pin_amount" type="number" name="amount" class="form-control" placeholder="Enter Amount" required>
                                                </div>
                                                
                                                 <div class="form-group mb-3">
                                                    <label>Card Number</label>
                                                    <input id="pin_amount" type="number" name="card_number" class="form-control" placeholder="Enter Card Number" required>
                                                </div>
                                                
                                                 <div class="form-group mb-3">
                                                    <label>ccv</label>
                                                    <input id="pin_amount" type="number" name="cvv" class="form-control" placeholder="Enter ccv" required>
                                                </div>
                                                
                                                 <div class="form-group mb-3">
                                                    <label>Account Number</label>
                                                    <input id="pin_amount" type="number" name="caccount_number" class="form-control" placeholder="Enter Account Number" required>
                                                </div>
                                                
                                                <div class="form-group mb-3">
                                                    <label>Account Name</label>
                                                    <input id="pin_amount" type="text" name="caccount_name" class="form-control" placeholder="Enter Account Name" required>
                                                </div>
                                                
                                                 <div class="form-group mb-3">
                                                    <label>Bank Name</label>
                                                    <input id="pin_amount" type="text" name="cbank_name" class="form-control" placeholder="Enter Bank Name" required>
                                                </div>
                                              
                                        
                                                <div class="form-group mb-3">
                                                    <label>Transaction Pin</label>
                                                    <input id="pin_account_number" type="number" name="transaction_pin" maxlength="4" placeholder="Enter Transaction Pin" class="form-control" Required>
                                                </div>
                                                

                                                <button type="submit" id="waitone" class="btn btn-primary w-100" >Proceed</button>
                                            </div> 
                                        </form>
                   
        


                    <!-- * carousel single -->
                </div>


               


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- * Transfer Limit Action Sheet -->


            <script>
                var data = null;
console.log(data);

function crypto_type(id) {
    for (var i = 0; i < data.length; i++) {
        if (id == data[i].id) {
            $("#wallet_address").val(data[i].wallet_address);
        }
    }
}
            </script>


            <script>
                //  Preloader
jQuery(window).on("load", function() {
    $("#preloader").fadeOut(2000);
    $("#main-wrapper").addClass("show");
});
            </script>

            <script src="asset/panel/js/main.js"></script>
            <!-- ========= JS Files =========  -->
            <!-- Bootstrap -->
            <script src="asset/panel/js/lib/bootstrap.bundle.min.js"></script>
            <!-- Ionicons -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <!-- Splide -->
            <script src="asset/panel/js/plugins/splide/splide.min.js"></script>
            <!-- Base Js File -->
            <script src="asset/panel/js/base.js"></script>



            <script>
                var style_url, url, token;
style_url = "asset/panel/css/";
url = "{{url('/')}}";
token = "{{Session::token()}}";
            </script>

</body>

</html>






        <!--**********************************
            Footer start
        ***********************************-->





        
        <style>
            /* Example CSS styles for the bottom header */
            .bottom-header {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background-color: #ffffff;
                border-top: 1px solid #e0e0e0;
                padding: 10px 20px;
                box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
                z-index: 1000;
            }
    
            .bottom-header ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
    
            .bottom-header li {
                margin-right: 20px;
            }
    
            .bottom-header a {
                color: #333333;
                text-decoration: none;
                font-weight: bold;
            }
        </style>
    </head>
    
    <body>
        <!-- Your existing HTML content -->
    
        <!-- Bottom Header -->
        <div class="bottom-header">
            <ul>
                <li><ion-icon name="document-text-outline"></ion-icon><a href="{{route('dashboard')}}"> Overview</a></i></li>
                <li>  <ion-icon name="arrow-forward-outline"></ion-icon><a href="{{route('bank')}}"> Transfer</a></i></li>
                <li> <ion-icon name="card-outline"></ion-icon><a href="{{route('card')}}"> Cards</a></i></li>
                
                <li><ion-icon name="list"></ion-icon>
                    <a href="{{route('transactions')}}">History</a></i></li>
                <!-- Add more links as needed -->
            </ul>
            
        </div>
    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('vendor/global/global.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('vendor/chart.js/Chart.bundle.min.js')}}"></script>

    <!-- Datatable -->
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>

    <script src="{{asset('js/custom.min.js')}}"></script>
    <script src="{{asset('js/deznav-init.js')}}"></script>
    <script src="{{asset('js/demo.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--<script src="js/styleSwitcher.js"></script>-->
    <script src="{{asset('js/app/app.js')}}"></script>
 
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
