<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMTP Limit Alert</title>
</head>

<body>
    <p>Dear Administrator,</p>
    <p>The SMTP service <strong>{{ $smtp->domain }}</strong> with user <strong>{{ $smtp->user }}</strong> in your SMTP
        service has reached its limitation. Please take the necessary action.</p>
    <p>Thank you.</p>
</body>

</html>
