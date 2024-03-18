@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card appointment-detail">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-primary">Total senders<i class="fa fa-circle"></i></p>
                        </div>
                        <div class="setting-list">
                            <ul class="list-unstyled setting-option">
                                <!-- Icons and actions here remain unchanged -->
                                <li>
                                    <div class="setting-light"><i class="icon-layout-grid2"></i></div>
                                </li>
                                <li><i class="icofont icofont-maximize full-card font-white"></i></li>
                                <li><i class="icofont icofont-minus minimize-card font-white"></i></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">Consider that this list is just for single senders (These may go to spam
                        if the domain is not authenticated).
                        <br>
                        You can send emails from any senders of authenticated domains! <a class="btn btn-sm"
                            href="/domains/list">See the list</a>
                    </div>
                    <div class="accordion" id="senderAccordion">
                        @foreach ($data as $index => $sender)
                            <div class="mb-3">

                                <div class="d-flex w-100 justify-content-between">
                                    <span>{{ $sender['from']['email'] }}</span>
                                    @if ($sender['verified']['status'])
                                        <span class="badge bg-success">Valid</span>
                                    @else
                                        <span class="badge bg-danger">Not Valid</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-3">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
