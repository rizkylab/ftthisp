@extends('layouts.app')

@section('title', 'Create Customer')

@section('content')
    <h1 class="h3 mb-3">Create New Customer</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer ID</label>
                            <input type="text" name="customer_id_string" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Connected ODP</label>
                            <select name="odp_id" class="form-select" required>
                                <option value="">Select ODP</option>
                                @foreach($odps as $odp)
                                    <option value="{{ $odp->id }}">{{ $odp->name }} ({{ $odp->used_core }}/{{ $odp->capacity }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="online">Online</option>
                                        <option value="offline">Offline</option>
                                        <option value="trouble">Trouble</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Signal Level (dBm)</label>
                                    <input type="number" name="signal_level_dbm" class="form-control" step="0.01">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location (Click on map)</label>
                            <div id="mapPicker" style="height: 300px; width: 100%;" class="mb-2"></div>
                            <input type="hidden" name="coordinates" id="coordinates" required>
                            <small class="text-muted" id="coordDisplay">No location selected</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Customer</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var map = L.map('mapPicker').setView([-6.200000, 106.816666], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var marker;

        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            
            var coord = {lat: e.latlng.lat, lng: e.latlng.lng};
            document.getElementById('coordinates').value = JSON.stringify(coord);
            document.getElementById('coordDisplay').innerText = `Lat: ${e.latlng.lat.toFixed(5)}, Lng: ${e.latlng.lng.toFixed(5)}`;
        });
    });
</script>
@endpush
