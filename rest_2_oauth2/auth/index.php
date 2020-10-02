<?php

require_once('./google/settings.php');

$gauth_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me')
                . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL)
                . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';

$html =<<<HTML
<html>
<body>
</br>
<div class="row">
    <div class="col s12 m6">
        <a class="oauth-container btn darken-4 white black-text" href="$gauth_url" style="text-transform:none">
            <div class="left">
                <img width="20px" style="margin-top:7px; margin-right:8px" alt="Google sign-in"
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
            </div>
            Login with Google
        </a>
    </div>
</div>

<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
</body>
</html>
HTML;

echo $html;
