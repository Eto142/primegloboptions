@include('dashboard.header')
<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll">

<!-- Main header ends -->

<!-- Content wrapper start -->
<div class="content-wrapper">
<div class="card">
										<div class="card-header">
											<div class="card-title">Recent Transaction Activities</div>
										</div>
										<div class="card-body">
										
												
												
												
                        @forelse($details as $details)
													<div class="activity-block d-flex position-relative">
                          <div class="m-2">
															<h5>{{$details->transaction_ref}}</h5>
															<p class="m-0">{{ \Carbon\Carbon::parse($details->transaction_created_at)->format('D, M j, Y g:i A') }}</p>
															<p style="color:blue">{{$details->transaction_description}}</p>
														
														</div>
											
														<div class="m-2 ">
															
															<b>Amount</b>
                              @if($details->transaction_type == 'Debit')
															<h5 style="color:red">-{{Auth::user()->currency}}{{$details->transaction_amount}}</h5>
                              @elseif($details->transaction_type == 'Credit')
                              <h5 style="color:green">+{{Auth::user()->currency}}{{$details->transaction_amount}}</h5>
                              @endif
                              @if($details->transaction_status == '1')
                              <p style="color:green">Completed</p>
                              @else
                              <p style="color:red">Pending</p>
                              @endif
														
														</div>
                            
														<div class="m-3 ">
															<h5>{{$details->transaction_type}}</h5>
                              <form  action="{{route('view.invoice', $details->transaction_id)}}" method="POST">
                                              @csrf
                              <input type="hidden" name="type" value="{{$details->transaction}}" class="form-control" style="color:blue" placeholder="Enter Amount" />
                              <a href="{{route('view.invoice', $details->transaction_id)}}" type="submit" class="badge shade-blue">View Details</a>
                              </form>
															
														</div>
													</div>
                          @empty
                      <div class="card-header">
											<div class="card-title">No Transaction</div>
										</div>
                          @endforelse
													
											
										</div>
									</div>

                  </div>
									</div>
@include('dashboard.footer')
