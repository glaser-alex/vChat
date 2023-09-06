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
    <div><a class="fa fa-refresh" href="./"></a></div>
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
  </div>
</div>

<main>

  <div class="angemeldetAls">Angemeldet als: <?php echo $username ?><span style="color: transparent;">❀</span></div>

  <div id="chatBoxDIV" class="chatBoxDIV">
    <div id="content">
      <?php
        $dateiname = "./chat.txt";
        if (file_exists($dateiname)) { echo file_get_contents($dateiname); }
      ?>
    </div>
  </div>
  <form class="messageForm" action="" method="post" enctype="multipart/form-data">
    <label for="fileToUpload">Upload</label>
    <input id="fileToUpload" type="file" name="fileToUpload">
    <span id="MessageInput"></span>
    <input type="submit" name="submit" value="Senden">
  </form>

</main>

<?php
  $tag = date('j'); $monat = date('n'); $jahr = date('y');
  echo "<div class='version'>© $jahr Alexander Glaser v.$tag.$monat.$jahr</div>";

  include "./inc/auswerten.php";
?>

<script type="text/javascript">

// jQuery Document
$(document).ready(function(){

  function scrollToBottom() {
    // var content = $("#content");
    // content[0].scrollIntoView({
    //   behavior: 'auto',
    //   block: 'end',
    //   inline: 'end'
    // });
    console.log("true");
    var chatBoxDIV = document.getElementById('chatBoxDIV');
    chatBoxDIV.scrollTop = chatBoxDIV.scrollHeight;
  }

  if (screen.width <= '900') {
    setInterval(loadLog, 500);
    $('#MessageInput').html('<input type="text" name="message" id="message" placeholder="<?php echo $messagePlaceholder; ?>">');
    const message = document.getElementById('message');
    const chatBox = document.getElementById('chatBoxDIV');
    message.addEventListener('focusin', (event) => {
      chatBox.style.height = "40vh";
      scrollToBottom();
    })
    message.addEventListener('focusout', (event) => {
      chatBox.style.height = "70vh";
    })
  } else {
    setInterval(loadLog, 10000);
    $('#MessageInput').html('<input type="text" name="message" id="message" placeholder="<?php echo $messagePlaceholder; ?>" autofocus>');
  }

  //Load the file containing the chat log
  function loadLog(){
    var alt_text = $("#content").html();
    $.ajax({
      url: "chat.txt",
      cache: false,
      success: function(html){		
        if (alt_text != html) {
          console.log("alt: \n" + alt_text);
          console.log("neu: \n" + html);
          $("#content").html(html); //Insert chat log into the #chatBox div
          scrollToBottom();
        }
      },
    });
  }
});
</script>
</body>
</html>