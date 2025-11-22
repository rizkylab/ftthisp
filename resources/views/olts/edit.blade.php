@extends('layouts.app')

@section('title', 'Edit OLT')

@section('content')
    <h1 class="h3 mb-3">Edit OLT: {{ $olt->name }}</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('olts.update', $olt) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $olt->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type/Model</label>
                            <input type="text" name="type" class="form-control" value="{{ $olt->type }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Total Ports</label>
                                    <input type="number" name="total_ports" class="form-control" value="{{ $olt->total_ports }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ $olt->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="maintenance" {{ $olt->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="down" {{ $olt->status == 'down' ? 'selected' : '' }}>Down</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location (Click on map)</label>
                            <div id="mapPicker" style="height: 300px; width: 100%;" class="mb-2"></div>
                            <input type="hidden" name="coordinates" id="coordinates" value="{{ json_encode($olt->coordinates) }}" required>
                            <small class="text-muted" id="coordDisplay">
                                @if($olt->coordinates)
                                    Lat: {{ $olt->coordinates['lat'] }}, Lng: {{ $olt->coordinates['lng'] }}
                                @else
                                    No location selected
                                @endif
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary">Update OLT</button>
                        <a href="{{ route('olts.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var initialLat = {{ $olt->coordinates['lat'] ?? -6.200000 }};
        var initialLng = {{ $olt->coordinates['lng'] ?? 106.816666 }};
        
        var map = L.map('mapPicker').setView([initialLat, initialLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var marker = L.marker([initialLat, initialLng]).addTo(map);

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
