<?php
    if ($_COOKIE['username'] != 'admin') { $_POST = array_map('htmlspecialchars', $_POST); }
    // echo"<pre>"; echo print_r($_POST); echo"</pre>";
    
    if ($_POST['submit']) {
        if (!empty($_POST['message']) || !empty($_FILES["fileToUpload"]["name"])) {
          $date = date('(H:i) ');
          $datei = fopen($dateiname, "a");
          flock($datei, LOCK_EX);
  
          if (!empty($_FILES["fileToUpload"]["name"])) {
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
              // $messagePlaceholder = "File is an image - " . $check["mime"] . ".";
              $uploadOk = 1;
            } else {
              $messagePlaceholder = "File is not an image...";
              $uploadOk = 0;
            }
              
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 9000000) {
              $messagePlaceholder = "Sorry, your file is too large...";
              $uploadOk = 0;
            }
              
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
              $messagePlaceholder = "Sorry, only JPG, JPEG, PNG & GIF files are allowed...";
              $uploadOk = 0;
            }
              
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk != 0) {
              // Check if file already exists / Upload
              if (!file_exists($target_file)) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                  // echo "The file ". htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                } else {
                  $messagePlaceholder = "Sorry, there was an error uploading your file...";
                }
              }
              // If message is empty
              if (empty($_POST['message'])) {
                fputs($datei, "<div class='messageDIV messageMitImg' style='background: ".$backgroundColor."'><span class='messageTime'>".$date."</span>".$username."<br><img src='../uploads/".$_FILES['fileToUpload']['name']."' width='250'></div>\n\n");
              } else {
                fputs($datei, "<div class='messageDIV messageMitImg' style='background: ".$backgroundColor."'><span class='messageTime'>".$date."</span>".$username."<br><img src='../uploads/".$_FILES['fileToUpload']['name']."' width='250'><br>".$_POST['message']."</div>\n\n");
              }
            }         
          } else {
            fputs($datei, "<div class='messageDIV' style='background: ".$backgroundColor."'><span class='messageTime'>".$date."</span>".$username." ".$_POST['message']."</div>\n\n");
          }
          flock($datei, LOCK_UN);
          fclose($datei);
        }
      }
?>