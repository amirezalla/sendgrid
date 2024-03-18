@extends('layouts.app') {{-- Extend the layout --}}


@section('content')
    <form action="/senders/add" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card appointment-detail">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1">
                                <p class="square-after f-w-600 header-text-primary">Adding sender<i class="fa fa-circle"></i>
                                </p>
                                {{-- <h4>{{ count($data) }} Domains</h4> --}}
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
                        @if (session('warning'))
                            <div class='p-10 alert alert-info'>{{ session('warning') }}</div>
                        @elseif(session('error'))
                            <div class='p-10 alert alert-danger'>{{ session('error') }}</div>
                        @endif

                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="email" placeholder="a.allahverdi@domain.it"
                                required>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>


                    </div>
                </div>
            </div>
        </div>


    </form>
@endsection
