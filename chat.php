<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <title>vChat</title>
</head>
<body>
<?php
    if ($_SERVER['SERVER_NAME'] != 'vchat.alex-glaser.de' && $_SERVER['SERVER_NAME'] != 'alex-glaser.de') {
      error_reporting(E_ALL && ~E_WARNING);
      $_COOKIE['username'] = 'admin';
    }

    if ($_COOKIE['username'] == 'admin') {
      $username = "<b style='color: #31a2d6'>alex</b>";
      $backgroundColor = "#31A2D630";
    } else if ($_COOKIE['username'] == 'valentina') {
      $username = "<span style='color: pink'><b>valentina</b>❀</span>";
      $backgroundColor = "#EA91A130";
    } else {
      header("Location: ./login"); 
    }

    $messagePlaceholder = 'Schreibe eine Nachricht...';
?>
<nav>
    <div class="logo"><a href="./"><img src="./img/flower.png" alt="logo" width="30"></a></div>
    <div><a class="fa fa-home" href="https://www.alex-glaser.de/home"></a></div>
    <div><a class="fa fa-gamepad" href="https://www.alex-glaser.de/games"></a></div>
    <div><a class="fa fa-comment-o" href="https://www.alex-glaser.de/kontakt"></a></div>
    <div><a class="fa fa-refresh" href="./" accesskey="r"></a></div>
    <?php if ($_COOKIE['username'] == 'admin'): ?>
      <div><a class="fa fa-trash" href="?action=clearChat"></a></div>
    <?php endif; ?>
    <div><a class="fa fa-sign-out" href="../login/logout.php"></a></div>
</nav>

<div class="sidebar">
  <div class="vChat">
    <div><b style="color: var(--prim);">vChat </b><span style="color: transparent;">❀</span></div>
  </div>
  <div class="release">
    <h2 style="margin-block: 0.5em;">Release Notes</h2>
    <?php
      include "./inc/release.html";
    ?>
  <emoji-picker class="light display-none"></emoji-picker>
  </div>
</div>

<main>

  <div class="angemeldetAls">Angemeldet als: <?php echo $username ?><span style="color: transparent;">❀</span></div>

  <div id="chatBoxDIV" class="chatBoxDIV">
    <div id="content">
      <?php
        $dateiname = "./chat.txt";
        if (file_exists($dateiname)) { echo file_get_contents($dateiname); }

        if ($_GET['action'] == 'clearChat') {
          file_put_contents($dateiname, '');
        }
      ?>
    </div>
  </div>
  <form class="messageForm" action="" method="post" enctype="multipart/form-data">
    <label for="fileToUpload" class="fa fa-upload"></label>
    <input id="fileToUpload" type="file" name="fileToUpload">
    <label id="toggle-emoji-picker" class="fa fa-smile-o emoji-picker"></label>
    <div id="MessageInput"><input id="message" type="text" name="message" placeholder="<?php echo $messagePlaceholder; ?>"></div>
    <input type="submit" name="submit" value="Senden">
  </form>

</main>

<?php
  $tag = date('j'); $monat = date('n'); $jahr = date('y');
  echo "<div class='version'>© $jahr Alexander Glaser v.$tag.$monat.$jahr</div>";

  include "./inc/auswerten.php";
?>

<script type="text/javascript">

// zum Debuggen
document.querySelector('emoji-picker').addEventListener('emoji-click', (event) => {
  console.log(event.detail.unicode);
  document.querySelector('#message').value += event.detail.unicode;
});

let emojiPicker = document.querySelector('#toggle-emoji-picker');
emojiPicker.onclick = function() {
  document.querySelector('emoji-picker').classList.toggle('display-none');
}

// jQuery Document
$(document).ready(function(){

  function scrollToBottom()
  {
    var chatBoxDIV = document.getElementById('chatBoxDIV');
    chatBoxDIV.scrollTop = chatBoxDIV.scrollHeight;
  }

  function refreshScreen()
  {
    if (screen.width <= '900') {
      setInterval(loadChat, 500);
      $('.emoji-picker').css("display", "none");
      $('#MessageInput').html('<input type="text" name="message" id="message" placeholder="<?php echo $messagePlaceholder; ?>">');
      var message = document.getElementById('message');
      var chatBoxDIV = document.getElementById('chatBoxDIV');
      var html = document.querySelector("html");
      message.addEventListener('focusin', (event) => {
        chatBoxDIV.style.height = "88%";
        document.querySelector("html").style.height = "130%";
        scrollToBottom();
      });
      message.addEventListener('focusout', (event) => {
        chatBoxDIV.style.height = "88%";
        document.querySelector("html").style.height = "90vh";
      });
    } else {
      setInterval(loadChat, 100);
        $('.emoji-picker').css("display", "block");
      $('#MessageInput').html('<input type="text" name="message" id="message" placeholder="<?php echo $messagePlaceholder; ?>" autofocus>');
    }
  }

  function loadChat()
  {
    var alt_text = $("#content").html();
    $.ajax({
      url: "chat.txt",
      cache: false,
      success: function(html){		
        $("#content").html(html);
        var neu_text = $("#content").html();
        if (alt_text != neu_text) {
          scrollToBottom();
        }
      },
    });
  }

  var timeout = false;
  window.addEventListener('resize', function()
  {
    clearTimeout(timeout);
    // timeout = setTimeout(refreshScreen, 500);
    refreshScreen();
  });

  refreshScreen();

});
</script>

</body>
</html>