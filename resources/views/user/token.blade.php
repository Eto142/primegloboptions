@include('dashboard.header')
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
				<b>Error!</b>{{ session('error') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert"aria-label="Close"></button>
	   </div>
        @elseif (session('status'))
		<div class="alert alert-success" role="alert">
		<b>Success!</b> {{ session('status') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
        @endif
            <div class="container-fluid">
              
                <div class="row">
                    <div class="col-xl-4">
						<div class="row">
							
							
						</div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                           
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="text-black font-w600 mb-0 me-auto mb-2 pe-3">Transfer Authorization Code</h2>
                                        <div id="response_code"></div>
                                        <form  action="{{route('otp.pin')}}" method="POST">
                                                 @csrf
                                            <p id="server"></p>
                                           
                                            
                                                <div class="form-group mb-3">
                                                    <label style="color: black"> Enter a valid Transfer Authorization code for this transaction.</label>
                                                    <input id="otp" type="number" name="otp" class="form-control" Required>
                                                </div>
                                                

                                                <button type="submit" id="waitone" class="btn btn-primary w-100" >Proceed</button>
                                            </div> 
                                        </form>

                                            <!-- Start modal -->
                                            <div class="modal fade transfer_pin_modal" id="reqLoan">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">OTP Pin</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span>
                                                            </button>
                                                        </div>
                                                      
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
@include('dashboard.footer')
