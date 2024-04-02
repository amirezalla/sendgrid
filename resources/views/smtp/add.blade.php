@extends('layouts.app') {{-- Extend the layout --}}

@section('content')
    <form action="{{ route('smtp.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add SMTP User</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="domain" class="form-label">Domain <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="domain" name="domain" required>
                        </div>

                        <div class="mb-3">
                            <label for="max_number" class="form-label">Max Number</label>
                            <input type="number" class="form-control" id="max_number" name="max_number"
                                placeholder="0 for unlimited">
                        </div>

                        <div class="mb-3">
                            <label for="alert" class="form-label">Alert Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="alert" name="alert" required>
                        </div>

                        <div class="mb-3">
                            <label for="alert_number" class="form-label">Alert limit <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="alert_number" name="alert_number" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Expires At</label>
                            <input type="date" class="form-control" id="expires_at" name="expires_at">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
