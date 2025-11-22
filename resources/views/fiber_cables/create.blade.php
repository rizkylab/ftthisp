@extends('layouts.app')

@section('title', 'Create Fiber Cable')

@section('content')
    <h1 class="h3 mb-3">Create New Fiber Cable</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('fiber_cables.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Core Count</label>
                                    <select name="core_count" class="form-select">
                                        <option value="4">4 Core</option>
                                        <option value="8">8 Core</option>
                                        <option value="12">12 Core</option>
                                        <option value="24">24 Core</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Color</label>
                                    <input type="color" name="color" class="form-control form-control-color" value="#000000" title="Choose your color">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="normal">Normal</option>
                                        <option value="degraded">Degraded</option>
                                        <option value="cut">Cut</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Length (Meters)</label>
                                    <input type="number" name="length_meters" id="length_meters" class="form-control" step="0.01" required>
                                    <small class="text-muted">Calculated automatically from map drawing</small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Draw Path (Click multiple points)</label>
                                    <div id="mapPicker" style="height: 500px; width: 100%;" class="mb-2"></div>
                                    <input type="hidden" name="coordinates" id="coordinates" required>
                                    <button type="button" class="btn btn-sm btn-warning mt-2" id="clearMap">Clear Map</button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Fiber Cable</button>
                        <a href="{{ route('fiber_cables.index') }}" class="btn btn-secondary">Cancel</a>
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

        var latlngs = [];
        var polyline = L.polyline([], {color: 'red'}).addTo(map);

        map.on('click', function(e) {
            latlngs.push(e.latlng);
            polyline.setLatLngs(latlngs);
            
            updateCoordinates();
            calculateLength();
        });

        document.getElementById('clearMap').addEventListener('click', function() {
            latlngs = [];
            polyline.setLatLngs([]);
            updateCoordinates();
            document.getElementById('length_meters').value = 0;
        });

        function updateCoordinates() {
            var coords = latlngs.map(function(ll) {
                return {lat: ll.lat, lng: ll.lng};
            });
            document.getElementById('coordinates').value = JSON.stringify(coords);
        }

        function calculateLength() {
            var totalDistance = 0;
            for (var i = 0; i < latlngs.length - 1; i++) {
                totalDistance += latlngs[i].distanceTo(latlngs[i + 1]);
            }
            document.getElementById('length_meters').value = totalDistance.toFixed(2);
        }
    });
</script>
@endpush
