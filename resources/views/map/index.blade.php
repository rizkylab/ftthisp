@extends('layouts.app')

@section('title', 'GIS Map')

@section('content')
    <div class="row h-100">
        <div class="col-12 h-100">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Network Map</h5>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 80vh; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var map = L.map('map').setView([-6.200000, 106.816666], 13); // Default Jakarta

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var oltLayer = L.layerGroup().addTo(map);
        var odpLayer = L.layerGroup().addTo(map);
        var fiberLayer = L.layerGroup().addTo(map);
        var customerLayer = L.layerGroup().addTo(map);

        var layersControl = L.control.layers(null, {
            "OLTs": oltLayer,
            "ODPs": odpLayer,
            "Fiber Cables": fiberLayer,
            "Customers": customerLayer
        }).addTo(map);

        // Icons
        var oltIcon = L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color:red;width:15px;height:15px;border-radius:50%;border:2px solid white;'></div>",
            iconSize: [15, 15],
            iconAnchor: [7, 7]
        });

        var odpIcon = L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color:blue;width:12px;height:12px;border-radius:50%;border:2px solid white;'></div>",
            iconSize: [12, 12],
            iconAnchor: [6, 6]
        });

        var customerIcon = L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color:green;width:10px;height:10px;border-radius:50%;border:2px solid white;'></div>",
            iconSize: [10, 10],
            iconAnchor: [5, 5]
        });


        fetch('{{ route("map.data") }}')
            .then(response => response.json())
            .then(data => {
                // OLTs
                data.olts.forEach(olt => {
                    if(olt.coordinates && olt.coordinates.lat) {
                        L.marker([olt.coordinates.lat, olt.coordinates.lng], {icon: oltIcon})
                            .bindPopup(`<b>OLT: ${olt.name}</b><br>Status: ${olt.status}`)
                            .addTo(oltLayer);
                    }
                });

                // ODPs
                data.odps.forEach(odp => {
                    if(odp.coordinates && odp.coordinates.lat) {
                        L.marker([odp.coordinates.lat, odp.coordinates.lng], {icon: odpIcon})
                            .bindPopup(`<b>ODP: ${odp.name}</b><br>Capacity: ${odp.used_core}/${odp.capacity}`)
                            .addTo(odpLayer);
                        
                        // Draw line to OLT if exists
                        if(odp.olt && odp.olt.coordinates) {
                             L.polyline([
                                [odp.coordinates.lat, odp.coordinates.lng],
                                [odp.olt.coordinates.lat, odp.olt.coordinates.lng]
                            ], {color: 'blue', weight: 1, dashArray: '5, 10'}).addTo(map);
                        }
                    }
                });

                // Fiber Cables
                data.fibers.forEach(fiber => {
                    if(fiber.coordinates && Array.isArray(fiber.coordinates)) {
                        var latlngs = fiber.coordinates.map(c => [c.lat, c.lng]);
                        var color = fiber.status === 'cut' ? 'red' : (fiber.status === 'degraded' ? 'orange' : 'green');
                        
                        L.polyline(latlngs, {color: color, weight: 3})
                            .bindPopup(`<b>Fiber: ${fiber.name}</b><br>Cores: ${fiber.core_count}<br>Status: ${fiber.status}`)
                            .addTo(fiberLayer);
                    }
                });

                // Customers
                data.customers.forEach(cust => {
                    if(cust.coordinates && cust.coordinates.lat) {
                        L.marker([cust.coordinates.lat, cust.coordinates.lng], {icon: customerIcon})
                            .bindPopup(`<b>Customer: ${cust.name}</b><br>Status: ${cust.status}`)
                            .addTo(customerLayer);
                            
                         // Draw line to ODP if exists
                        if(cust.odp && cust.odp.coordinates) {
                             L.polyline([
                                [cust.coordinates.lat, cust.coordinates.lng],
                                [cust.odp.coordinates.lat, cust.odp.coordinates.lng]
                            ], {color: 'green', weight: 1}).addTo(map);
                        }
                    }
                });
            });
    });
</script>
@endpush
