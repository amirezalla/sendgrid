@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card appointment-detail">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-primary">Total domains<i class="fa fa-circle"></i></p>
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
                    <div class="accordion" id="domainAccordion">
                        @foreach ($data as $index => $domain)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                                        aria-controls="collapse{{ $index }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <span>{{ $domain['subdomain'] }}.{{ $domain['domain'] }} </span>
                                            @if ($domain['valid'])
                                                <span class="badge bg-success">Valid</span>
                                            @else
                                                <span class="badge bg-danger">Not Valid</span>
                                            @endif
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $index }}" data-bs-parent="#domainAccordion">
                                    <div class="accordion-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Cname</th>
                                                    <th>Host</th>
                                                    <th>Data</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($domain['dns'] as $dns)
                                                    <tr>
                                                        <td>{{ $dns['type'] }}</td>
                                                        <td>{{ $dns['host'] }}</td>
                                                        <td>{{ $dns['data'] }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td>text</td>
                                                    <td>_dmarc.{{ $domain['domain'] }}</td>
                                                    <td>v=DMARC1; p=none;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
