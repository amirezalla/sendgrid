@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card appointment-detail">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-primary">Total senders<i class="fa fa-circle"></i></p>
                        </div>
                        <div class="setting-list">
                            <ul class="list-unstyled setting-option">
                                <!-- Icons and actions here remain unchanged -->
                                <li>
                                    <div class="setting-light"><i class="icon-layout-grid2"></i></div>
                                </li>
                                <li><i class="icofont icofont-maximize full-card font-white"></i></li>
                                <li><i class="icofont icofont-minus minimize-card font-white"></i></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Main Nav tabs for Modes (SMTP or Code) -->
                    <ul class="nav nav-tabs" id="mainTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="code-tab" data-bs-toggle="tab" data-bs-target="#code"
                                type="button" role="tab" aria-controls="code" aria-selected="true">Code</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="smtp-tab" data-bs-toggle="tab" data-bs-target="#smtp"
                                type="button" role="tab" aria-controls="smtp" aria-selected="false">SMTP</button>
                        </li>
                    </ul>

                    <!-- Tab panes for Modes (SMTP or Code) -->
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="code" role="tabpanel" aria-labelledby="code-tab">
                            <!-- Nested Nav tabs for Languages -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#php-code">PHP</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#python-code">Python</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#javascript-code">JavaScript</button>
                                </li>
                            </ul>
                            <!-- Nested Tab Content for Languages -->
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="php-code">
                                    <div class="mb-3 mt-3">
                                        <h3>/api/createSender</h3>
                                        <pre><code class="language-php">
$url = 'https://sendgrid-hlixxcbawa-uc.a.run.app/api/createSender';
$payload = array(
    'email' => 'user@example.com'
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
                                        </code></pre>
                                    </div>

                                    <div class="mb-3">
                                        <h3>/api/sendEmail</h3>
                                        <pre><code class="language-php">
$url = 'https://sendgrid-hlixxcbawa-uc.a.run.app/api/sendEmail';
$payload = array(
    'to' => 'recipient@example.com',
    'message' => 'Hello, this is a test message.',
    'address' => 'sender@example.com',
    'name' => 'Sender Name',
    'subject' => 'Test Subject'
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

$response = curl_exec($ch);
curl_close($ch);

echo $response;                                        </code></pre>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="python-code">
                                    <div class="mb-3 mt-3">
                                        <h3>/api/createSender</h3>
                                        <pre><code class="language-python">
import requests

url = "https://sendgrid-hlixxcbawa-uc.a.run.app/api/createSender"
payload = {
    'email': 'user@example.com'
}
response = requests.post(url, json=payload)

print(response.text)
                                        </code></pre>
                                    </div>

                                    <div class="mb-3">
                                        <h3>/api/sendEmail</h3>
                                        <pre><code class="language-python">
import requests

url = "https://sendgrid-hlixxcbawa-uc.a.run.app/api/sendEmail"
payload = {
    'to': 'recipient@example.com',
    'message': 'Hello, this is a test message.',
    'address': 'sender@example.com',
    'name': 'Sender Name',
    'subject': 'Test Subject'
}
response = requests.post(url, json=payload)

print(response.text)
                                        </code></pre>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="javascript-code">
                                    <div class="mb-3 mt-3">
                                        <h3>/api/createSender</h3>
                                        <pre><code class="language-javascript">

fetch('https://sendgrid-hlixxcbawa-uc.a.run.app/api/createSender', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        email: 'user@example.com'
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch((error) => {
    console.error('Error:', error);
});
                                        </code></pre>
                                    </div>

                                    <div class="mb-3">
                                        <h3>/api/sendEmail</h3>
                                        <pre><code class="language-javascript">
fetch('https://sendgrid-hlixxcbawa-uc.a.run.app/api/sendEmail', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        to: 'recipient@example.com',
        message: 'Hello, this is a test message.',
        address: 'sender@example.com',
        name: 'Sender Name',
        subject: 'Test Subject'
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch((error) => {
    console.error('Error:', error);
});
                                        </code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="smtp" role="tabpanel" aria-labelledby="smtp-tab">
                            <p>The smtp section configuration is still in progress and will be available as soon as possible
                                in this page</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
