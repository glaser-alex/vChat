<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <title>VoIPstudio Web Phone - Demo integration</title>
    <script type="text/javascript" src="https://voipstudio.com/webphone/api.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css" />
</head>
<body>

<div class="container" style="display: flex; justify-content: center">
    <div style="flex-basis: 80%; padding: 20px;">
        
        <h2>VoIPstudio Web Phone - Demo integration</h2>
        <div id="login-form" style="display: none; margin: 50px 0 50px 0;">
            <form class="row g-3">
                <div>Enter your VoIPstudio email and password to login:</div>
                <div class="col-sm-5"><input id="email" type="text" name="email" class="form-control" placeholder="E-mail address" /></div>
                <div class="col-sm-5"><input id="password" type="password" name="password" class="form-control" placeholder="Password" /></div>
                <div class="col-sm-2 text-end"><button id="login" type="button" class="btn btn-success">Login</button></div>
            </form>
        </div>

        <div id="phone" style="display: none;">
            <div style="text-align: right;">
                <button id="logout" type="button" class="btn btn-danger pull-right">
                    Logout
                </button>
            </div>
            <div style="padding: 40px 0px;">
                <div id="dial">
                    <h4>Dial</h4>
                    <form class="row g-2">
                    <div class="col-sm-9"><input id="dial-number" type="text" name="number" class="form-control" placeholder="Enter number to dial (eg. #123 to make Test Call)" /></div>
                    <div class="col-sm-2 text-end"><button id="call" type="button" class="btn btn-success">Call</button></div>
                </form>
                </div>
                <div id="ringing" style="display: none;">
                    <h4>Ringing</h4>
                    <div>
                        <button id="answer" type="button" class="btn btn-success pull-right">Answer</button>
                        <button id="reject" type="button" class="btn btn-danger pull-right">Hangup</button>
                    </div>
                </div>
                <div id="connecting" style="display: none;">
                    <h4>Connecting</h4>
                    <div>
                        <button id="cancel" type="button" class="btn btn-danger pull-right">Hangup</button>
                    </div>
                </div>
                <div id="connected" style="display: none;">
                    <h4>Connected</h4>
                    <div>
                        <button id="hold" type="button" class="btn btn-warning pull-right">Hold</button>
                        <button id="unhold" type="button" class="btn btn-warning pull-right" style="display: none;">Unhold</button>
                        <button id="mute" type="button" class="btn btn-warning pull-right">Mute</button>
                        <button id="unmute" type="button" class="btn btn-warning pull-right" style="display: none;">Unmute</button>
                        <button id="hangup" type="button" class="btn btn-danger pull-right">Hangup</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="events" style="margin-top: 20px;">
            <div>Message log</div>
            <div id="log-wrapper" style="max-height: 230px; overflow-y: auto;">
                <div id="log" style="font-size: 10px; background-color: #f5f5f5;"></div>
            </div>
        </div>

    </div>

    <div style="padding: 20px;">
        <iframe id="embedded-softphone" src="https://voipstudio.com/webphone/" allow="microphone" width="300" height="550"></iframe>
    </div>
</div>

<script type="text/javascript">
// WebPhone instance initialised in 'embedded-softphone' IFRAME
var webPhone = __webphone.init(document.getElementById('embedded-softphone'));

// Utils
var getById = document.getElementById.bind(document);
var toggle = function(id, flag) {
    var el = getById(id),
        visible = el.tagName === 'DIV' ? 'block' : 'inline';
    el.style.setProperty('display', flag ? visible : 'none');
};

// Interface
var toggleLoginForm = function(flag) {
    toggle('login-form', flag);
    toggle('phone', !flag);
};
var toggleCallPanel = function(visible) {
    toggle('dial', visible === 'dial');
    toggle('ringing', visible === 'ringing');
    toggle('connecting', visible === 'connecting');
    toggle('connected', visible === 'connected');
};
var toggleHold = function(flag) {
    toggle('hold', flag);
    toggle('unhold', !flag);
};
var toggleMute = function(flag) {
    toggle('mute', flag);
    toggle('unmute', !flag);
};
var logEvent = function(event) {
    var log = getById('log'),
        entry = document.createElement('div'),
        logWrapper = document.getElementById("log-wrapper"),
        msg = document.createTextNode([
            ' [' + (new Date()).toISOString() + '] ',
            event.type + ': ',
            (event.detail) ? JSON.stringify(event.detail) : ''
        ].join(' '));
    entry.appendChild(msg);
    log.appendChild(entry);
    logWrapper.scrollTop = logWrapper.scrollHeight;
};

// Actions
var login = () => {
    webPhone.login(
        getById('email').value,
        getById('password').value,
        credentials => {
            toggleLoginForm(!credentials.logged);
        },
        error => {
            alert(error.message);
        }
    );
};

var logout = () => webPhone.logout();
var answer = () => webPhone.answer();
var hangup = () => webPhone.hangup();
var hold = () => webPhone.hold(() => toggleHold(false));
var unhold = () => webPhone.unhold(() => toggleHold(true));
var mute = () => webPhone.mute(() => toggleMute(false));
var unmute = () => webPhone.unmute(() => toggleMute(true));
var dialNumber = () => webPhone.call(getById('dial-number').value);

// Bind events and actions to WebPhone
webPhone.on('callstate', logEvent);

webPhone.on('ready', function(event) {
    logEvent(event);
    toggleLoginForm(!event.detail.logged);
});
webPhone.on('login', function(event) {
    logEvent(event);
    toggleLoginForm(false);
});
webPhone.on('logout', function(event) {
    logEvent(event);
    toggleLoginForm(true);
});
webPhone.on('ringing', function(event) {
    toggleCallPanel('ringing');
});
webPhone.on('initial', function(event) {
    toggleCallPanel('connecting');
});
webPhone.on('accepted', function(event) {
    toggleCallPanel('connected');
});
webPhone.on('hangup', function(event) {
    toggleCallPanel('dial');
    toggleHold(true);
    toggleMute(true);
});
webPhone.on('hold', function(event) {
    toggleHold(false);
});
webPhone.on('unhold', function(event) {
    toggleHold(true);
});
webPhone.on('timeout', function() {
    console.log('Error: softphone ready event timeout');
});

getById('login').addEventListener('click', login);
getById('logout').addEventListener('click', logout);
getById('call').addEventListener('click', dialNumber);
getById('answer').addEventListener('click', answer);
getById('reject').addEventListener('click', hangup);
getById('cancel').addEventListener('click', hangup);
getById('hold').addEventListener('click', hold);
getById('unhold').addEventListener('click', unhold);
getById('mute').addEventListener('click', mute);
getById('unmute').addEventListener('click', unmute);
getById('hangup').addEventListener('click', hangup);

document.querySelector('#dial > form').addEventListener('submit', event => {
    event.preventDefault();
    dialNumber();
});

</script>
</body></html>