@extends('layouts.app')

@section('title', 'OLTs')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">OLT Management</h1>
        <a href="{{ route('olts.create') }}" class="btn btn-primary">Add New OLT</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Ports (Used/Total)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($olts as $olt)
                        <tr>
                            <td>{{ $olt->name }}</td>
                            <td>{{ $olt->type }}</td>
                            <td>{{ $olt->used_ports }} / {{ $olt->total_ports }}</td>
                            <td>
                                <span class="badge bg-{{ $olt->status == 'active' ? 'success' : ($olt->status == 'maintenance' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($olt->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('olts.edit', $olt) }}" class="btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('olts.destroy', $olt) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No OLTs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $olts->links() }}
        </div>
    </div>
@endsection
