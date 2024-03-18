<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <!-- Email Body -->
    <div style="margin: 0 auto; max-width: 600px; font-family: Arial, sans-serif;">
        <!-- Dynamic Content -->
        <p>{!! $message !!}</p>
        <!-- You can pass dynamic content to your email template with variables like $content -->

        <!-- Footer -->
        <footer style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #EEE; text-align: center;">
            <p>The email has been sent by ICOA email engine</p>
        </footer>
    </div>
</body>

</html>
