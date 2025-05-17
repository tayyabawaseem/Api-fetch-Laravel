<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Ride</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-color: #f8f9fa;
        }

        .center-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .booking-form {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .form-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        .form-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .form-group {
            position: relative;
            margin-bottom: 15px;
        }

        .form-control {
            padding-left: 35px;
        }

        .btn-search {
            background-color: #c18f3f;
            color: white;
            font-weight: bold;
        }

        .btn-search:hover {
            background-color: #a87730;
        }
    </style>
</head>
<body>

<div class="center-container">
    <div class="booking-form">
        <div class="form-title">One Way Transfer(s)</div>

        <form method="POST" action="/lookup">
            @csrf

            <div class="form-group">
                <span class="form-icon"><i class="bi bi-geo-alt"></i></span>
                <input type="text" class="form-control" name="pickup_location" placeholder="From (Address, airport, hotel...)" required>
            </div>

            <div class="form-group">
                <span class="form-icon"><i class="bi bi-geo-alt-fill"></i></span>
                <input type="text" class="form-control" name="dropoff_location" placeholder="To (Address, airport, hotel...)" required>
            </div>

            <div class="row">
                <div class="col-6 form-group">
                    <span class="form-icon"><i class="bi bi-calendar"></i></span>
                    <input type="date" class="form-control" name="pickup_date" required>
                </div>
                <div class="col-6 form-group">
                    <span class="form-icon"><i class="bi bi-clock"></i></span>
                    <input type="time" class="form-control" name="pickup_time" required>
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="return_trip" id="returnTrip">
                <label class="form-check-label" for="returnTrip">Add Return</label>
            </div>

            <div class="form-group">
                <span class="form-icon"><i class="bi bi-people"></i></span>
                <input type="number" class="form-control" name="passenger_count" min="1" value="1" required placeholder="Passengers">
            </div>

            <button type="submit" class="btn btn-search w-100">
                <i class="bi bi-search"></i> Search
            </button>
        </form>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
