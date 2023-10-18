
@php

       $initiatedCount =  \App\Models\Payout::where('status','initiated')->count();
       $completedCount =  \App\Models\Payout::where('status','completed')->count();
       $cancelledCount = \App\Models\Payout::where('status','cancelled')->count();

@endphp

<div class="row">
    <div class="col-xl-3 col-sm-6 col-12 mb-4">
        <a href="{{route('payouts.index',['status' => 'initiated'])}}">
            <div class="card {{request('status') === 'initiated' ? 'active' : ''}}">
                <div class="card-body">
                    <div class="d-flex justify-content-between px-md-1">
                        <div id="pending_orders">
                            <h3 class="text-primary">{{$initiatedCount}}</h3>
                            <p class="mb-0" style="color: black">Initiated Payout</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-list text-primary fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 mb-4">
        <a href="{{ route('payouts.completed',['status' => 'completed']) }}" class="text-decoration-none">
            <div class="card {{request('status') === 'completed' ? 'active' : ''}}">
                <div class="card-body">
                    <div class="d-flex justify-content-between px-md-1">
                        <div id="accepted_orders">
                            <h3 class="text-primary">{{$completedCount}}</h3>
                            <p class="mb-0" style="color: black">Completed Payout</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-list text-primary fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    

    <div class="col-xl-3 col-sm-6 col-12 mb-4">
        <a href="{{route('payouts.cancelled',['status' => 'cancelled'])}}">
            <div class="card {{request('status') === 'cancelled' ? 'active' : ''}}">
                <div class="card-body">
                    <div class="d-flex justify-content-between px-md-1">
                        <div id="delivered_orders">
                            <h3 class="text-primary">{{$cancelledCount}}</h3>
                            <p class="mb-0" style="color: black">Cancelled Payout</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-list text-primary fa-3x"></i>
                        </div>
                    </div>
                    <div class="px-md-1">
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>