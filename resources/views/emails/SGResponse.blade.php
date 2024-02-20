<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <!-- Email Body -->
    <div style="margin: 0 auto; max-width: 600px; font-family: Arial, sans-serif;">
        <h2 style="color: #333;">Hello, {{ $domain }}</h2>

        <p>Please Configure these settings below to prevent your emails using this engine to go to spams!</p>

        <!-- Dynamic Content -->
        @php
            $spf_host = $response['dns']['mail_cname']['host'];
            $spf_data = $response['dns']['mail_cname']['data'];

            $dkim1_host = $response['dns']['dkim1']['host'];
            $dkim1_data = $response['dns']['dkim1']['data'];

            $dkim2_host = $response['dns']['dkim2']['host'];
            $dkim2_data = $response['dns']['dkim2']['data'];

            $dmarc_host = '_dmarc.' . $domain;
            $dmarc_data = 'v=DMARC1; p=none;';
        @endphp

        <h5>SPF:</h5>
        <p>HOST: {{ $spf_host }}</p>
        <p>VALUE: <strong>{{ $spf_data }}</strong></p>
        <hr>
        <h5>DKIM1:</h5>
        <p>HOST: {{ $dkim1_host }}</p>
        <p>VALUE: <strong>{{ $dkim1_data }}</strong></p>
        <hr>
        <h5>DKIM2:</h5>
        <p>HOST: {{ $dkim2_host }}</p>
        <p>VALUE: <strong>{{ $dkim2_data }}</strong></p>
        <hr>
        <h5>DMARC:</h5>
        <p>HOST: {{ $dmarc_host }}</p>
        <p>VALUE: <strong>{{ $dmarc_data }}</strong></p>

        <!-- Footer -->
        <footer style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #EEE; text-align: center;">
            <p>The email has been sent by ICOA email engine</p>
        </footer>
    </div>
</body>

</html>
