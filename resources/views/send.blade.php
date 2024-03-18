@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card appointment-detail">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-primary">Send Email<i class="fa fa-circle"></i></p>
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

                    <div class="preview">
                        @if (session('success'))
                            <div class="alert alert-success">
                                The email has been sent to the reciepents!:
                            </div>
                        @endif

                    </div>
                </div>
                <div class="card-body">
                    <form action="/mail/send" method="POST" id="emailForm">
                        @csrf

                        <div class="form-group">
                            <label for="from">From Email:</label>
                            <input type="email" name="from" id="from" class="form-control" required>
                        </div>

                        <div class="form-group" id="batchRecipientsGroup">
                            <label for="recipients">Recipients Emails:</label>
                            <div id="emailTags" class="email-tags"></div>
                            <input type="text" id="recipients" class="form-control"
                                placeholder="Enter emails and press Enter">
                            <input type="hidden" name="recipients" id="hiddenRecipients">
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject:</label>
                            <input type="text" name="subject" id="subject" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea name="message" id="message" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('message');
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recipientsInput = document.getElementById('recipients');
            const emailTagsDiv = document.getElementById('emailTags');
            const hiddenRecipientsInput = document.getElementById('hiddenRecipients');

            function refreshHiddenRecipients() {
                const emails = Array.from(emailTagsDiv.querySelectorAll('.email-tag span')).map(tag => tag
                    .textContent);
                hiddenRecipientsInput.value = emails.join(',');
            }

            recipientsInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ',') {
                    event.preventDefault();
                    const email = recipientsInput.value.trim().replace(',', ''); // Remove spaces and commas
                    if (email) { // Simple validation
                        const tag = document.createElement('div');
                        tag.classList.add('email-tag');

                        const span = document.createElement('span');
                        span.textContent = email;

                        const removeBtn = document.createElement('a');
                        removeBtn.innerHTML = '&times;';
                        removeBtn.href = 'javascript:void(0);';
                        removeBtn.classList.add('remove-tag');
                        removeBtn.onclick = function() {
                            tag.remove();
                            refreshHiddenRecipients();
                        };

                        tag.appendChild(span);
                        tag.appendChild(removeBtn);
                        emailTagsDiv.appendChild(tag);

                        // Clear the input
                        recipientsInput.value = '';

                        // Update the hidden input
                        refreshHiddenRecipients();
                    }
                }
            });
        });
    </script>
    <style>
        .email-tags {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
            padding: 5px;
            border-radius: 5px;
        }

        .email-tag {
            background-color: #88bcf457;
            color: rgb(0, 0, 0);
            padding: 2px 5px;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 3px;
            font-size: 14px;
        }

        .email-tag span {
            margin-right: 10px;
        }

        .remove-tag {
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        .remove-tag:hover {
            color: #f00;
        }
    </style>
@endsection
