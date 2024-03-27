@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">SMTP Users</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Domain</th>
                                <th>Usage/Limit</th>
                                <th>Status</th>
                                <th>Expires At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($smtpUsers as $user)
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->password }}</td>
                                    <td>{{ $user->domain }}</td>
                                    <td>{{ $user->usage }}/{{ $user->max_number == 0 ? 'Unlimited' : $user->max_number }}
                                    </td>
                                    <td>{{ $user->status }}</td>
                                    <td>{{ optional($user->expires_at)->toDateString() }}</td>
                                    <td>
                                        <a href="{{ route('smtp.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('smtp.destroy', $user->id) }}" method="POST"
                                            style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $smtpUsers->links() }} <!-- Pagination links -->
                </div>
            </div>
        </div>
    </div>
@endsection
