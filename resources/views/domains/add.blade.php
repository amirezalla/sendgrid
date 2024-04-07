@extends('layouts.app') {{-- Extend the layout --}}

@section('content')
    <form action="{{ route('smtp.add') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card appointment-detail">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1">
                                <p class="square-after f-w-600 header-text-primary">Adding domain<i class="fa fa-circle"></i>
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
                        <div class="card">

                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @elseif(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="mb-3">
                                    <label for="domainInput" class="form-label">Domain <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="domain" placeholder="example.com"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="emailInput" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email"
                                        placeholder="a.allahverdi@icoa.it" required>
                                    <div class="form-text">To notify about the settings on domain.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="subdomainInput" class="form-label">Subdomain</label>
                                    <input type="text" class="form-control" name="subdomain" placeholder="blog">
                                </div>

                                <div class="mb-3">
                                    <label for="ipsInput" class="form-label">IP Addresses</label>
                                    <input type="text" class="form-control" name="ips"
                                        placeholder="192.168.1.1, 192.168.1.2">
                                    <div class="form-text">Add IP addresses that will be included in the custom SPF record,
                                        separated by commas.</div>
                                </div>

                                <div class="mb-3">
                                    <input type="checkbox" class="form-check-input" name="custom_spf">
                                    <label class="form-check-label" for="custom_spf">Use custom SPF</label>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="default">
                                    <label class="form-check-label" for="defaultCheck">Use as default authenticated
                                        domain</label>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="automatic_security">
                                    <label class="form-check-label" for="automaticSecurityCheck">Allow automatic management
                                        of SPF
                                        records and DKIM keys</label>
                                </div>

                                <div class="mb-3">
                                    <label for="customDkimSelectorInput" class="form-label">Custom DKIM Selector</label>
                                    <input type="text" class="form-control" name="custom_dkim_selector"
                                        placeholder="XYZ">
                                    <div class="form-text">Accepts three letters or numbers.</div>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
    </form>
@endsection
