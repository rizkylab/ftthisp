@extends('layouts.app')

@section('title', 'Log Fault')

@section('content')
    <h1 class="h3 mb-3">Log New Fault</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('fault_logs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Cause of Fault</label>
                            <input type="text" name="cause" class="form-control" required placeholder="e.g. Fiber Cut, Connector Broken">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="open">Open</option>
                                <option value="in_progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Photo Evidence</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location (Click on map)</label>
                            <div id="mapPicker" style="height: 300px; width: 100%;" class="mb-2"></div>
                            <input type="hidden" name="location" id="location" required>
                            <small class="text-muted" id="coordDisplay">No location selected</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Log Fault</button>
                        <a href="{{ route('fault_logs.index') }}" class="btn btn-secondary">Cancel</a>
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
            document.getElementById('location').value = JSON.stringify(coord);
            document.getElementById('coordDisplay').innerText = `Lat: ${e.latlng.lat.toFixed(5)}, Lng: ${e.latlng.lng.toFixed(5)}`;
        });
    });
</script>
@endpush
