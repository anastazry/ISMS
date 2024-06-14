<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 600px; margin: 0 auto; }
        .header { background-color: #f2f2f2; padding: 10px; text-align: center; }
        .content { margin: 15px 0; }
        .footer { background-color: #f2f2f2; padding: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Incident Reported</h2>
        </div>

        <div class="content">
            <p><strong>Report Number:</strong> {{ $incident->reportNo }}</p>
            <p><strong>Title:</strong> {{ $incident->incident_title }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($incident->incident_date)->format('F d, Y') }}</p>
            <p><strong>Time:</strong> {{ $incident->incident_time }}</p>
            <p><strong>Location:</strong> {{ $incident->incident_location }}</p>
            <p><strong>Description:</strong> {{ $incident->incident_desc }}</p>
            @if ($incident->incident_image)
                <img src="{{ asset('storage/' . $incident->firstImage) }}" alt="Incident Image" class="w-12 h-10">
            @endif
            <!-- Add more details as needed -->
        </div>

        <div class="footer">
            <p>Thank you for your attention.</p>
        </div>
    </div>
</body>
</html>
