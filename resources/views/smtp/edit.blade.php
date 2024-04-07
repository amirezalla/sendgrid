@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit SMTP User</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('smtp.update', $smtpUser->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" value="{{ $smtpUser->username }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password (change to update)</label>
                            <input type="password" class="form-control" name="password"
                                placeholder="Leave blank to keep current password">
                        </div>

                        <div class="mb-3">
                            <label for="domain" class="form-label">Domain</label>
                            <input type="text" class="form-control" name="domain" value="{{ $smtpUser->domain }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="max_number" class="form-label">Max Number</label>
                            <input type="number" class="form-control" name="max_number" value="{{ $smtpUser->max_number }}"
                                placeholder="0 for unlimited">
                        </div>

                        <div class="mb-3">
                            <label for="alert" class="form-label">Alert Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="alert" name="alert"
                                value="{{ $smtpUser->alert }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="alert_number" class="form-label">Alert limit <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="alert_number" name="alert_number"
                                value="{{ $smtpUser->alert }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="active" {{ $smtpUser->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $smtpUser->status == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Expires At</label>
                            <input type="date" class="form-control" name="expires_at"
                                value="{{ $smtpUser->expires_at ? $smtpUser->expires_at->toDateString() : '' }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
