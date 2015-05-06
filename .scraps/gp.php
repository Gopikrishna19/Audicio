<script>
    var clientId = '993932107238-22c457mg8i3i9acfupf4fa9kc7dqiu7t.apps.googleusercontent.com';
    var scopes = 'https://www.googleapis.com/auth/plus.login email';


    function handleClientLoad() {
        window.setTimeout(checkAuth, 1);
    }

    function checkAuth() {        
        gapi.auth.authorize({ client_id: clientId, scope: scopes, immediate: true }, handleAuthResult);
    }

    function handleAuthResult(authResult) {
        var authorizeButton = document.getElementById('authorize-button');
        if (authResult && !authResult.error) {
            authorizeButton.style.visibility = 'hidden';
            makeApiCall();
        } else {
            authorizeButton.style.visibility = '';
            authorizeButton.onclick = handleAuthClick;
        }
    }

    function handleAuthClick(event) {
        gapi.auth.authorize({ client_id: clientId, scope: scopes, immediate: false }, handleAuthResult);
    }

    function makeApiCall() {
        gapi.client.load('plus', 'v1').then(function () {
            var request = gapi.client.plus.people.get({
                'userId': 'me'
            });
            request.then(function (resp) {
                console.log(resp.result.emails[0].value);
            }, function (reason) {
                console.log('Error: ' + reason.result.error.message);
            });
        });
    }

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//apis.google.com/js/client:platform.js?onload=checkAuth";
        fjs.parentNode.insertBefore(js, fjs);
    } (document, 'script', 'gapi-js'));
</script>
<button id="authorize-button">Sign in with Google</button>
<div class="hi"></div>