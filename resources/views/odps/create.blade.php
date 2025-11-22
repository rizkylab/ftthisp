@extends('layouts.app')

@section('title', 'Create ODP')

@section('content')
    <h1 class="h3 mb-3">Create New ODP</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('odps.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parent OLT</label>
                            <select name="olt_id" class="form-select" required>
                                <option value="">Select OLT</option>
                                @foreach($olts as $olt)
                                    <option value="{{ $olt->id }}">{{ $olt->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Capacity</label>
                                    <input type="number" name="capacity" class="form-control" value="8" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active">Active</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="down">Down</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location (Click on map)</label>
                            <div id="mapPicker" style="height: 300px; width: 100%;" class="mb-2"></div>
                            <input type="hidden" name="coordinates" id="coordinates" required>
                            <small class="text-muted" id="coordDisplay">No location selected</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Save ODP</button>
                        <a href="{{ route('odps.index') }}" class="btn btn-secondary">Cancel</a>
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
