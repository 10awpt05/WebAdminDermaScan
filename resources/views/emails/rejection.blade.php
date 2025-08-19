<!DOCTYPE html>
<html>
<head>
    <title>Registration Rejection</title>
</head>
<body>
    <p>Dear {{ $user['clinicName'] ?? 'Clinic' }},</p>

    <p>We regret to inform you that your clinic registration has been rejected.</p>

    <p><strong>Reason for rejection:</strong></p>
    <blockquote>{{ $reason }}</blockquote>

    <p>If you believe this is an error or would like to re-apply, please contact us.</p>

    <p>Best regards,<br>DermaScanAI Admin</p>
</body>
</html>
