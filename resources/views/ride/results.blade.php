<!DOCTYPE html>
<html>
<head>
    <title>Ride Results</title>
</head>
<body>
    <h2>Available Vehicles</h2>

    @if(isset($vehicles['results']))
        @foreach($vehicles['results'] as $vehicle)
            <div style="border:1px solid #ccc; margin:10px; padding:10px;">
                <strong>{{ $vehicle['vehicleType'] ?? 'Vehicle' }}</strong><br>
                Rate: ${{ $vehicle['rate'] ?? 'N/A' }}<br>
            </div>
        @endforeach
    @else
        <p>No vehicles found.</p>
    @endif

    <a href="/">← Back</a>
</body>
</html>
