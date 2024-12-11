<!DOCTYPE html>
<html>
<head>
    <title>Donation Receipt</title>
</head>
<body>
    <h1>Thank you for your donation!</h1>
    <p>Dear {{ $donation->user->name }},</p>
    <p>We appreciate your generous donation to {{ $donation->charity->name }}.</p>
    <p><strong>Donation Details:</strong></p>
    <ul>
        <li>Donation Amount: ${{ $donation->amount }}</li>
        <li>Date: {{ $donation->created_at->format('F j, Y') }}</li>
    </ul>
    <p>Thank you for your support!</p>
    <p>Sincerely,</p>
    <p>{{ config('app.name') }} Team</p>
</body>
</html>
