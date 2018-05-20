<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    $usrrr = "";
    if(!empty($_GET["user"]))
        $usrrr = $_GET["user"];
    elseif(!empty($_POST["postuser"]))
        $usrrr = $_POST["postuser"];
    else
        $usrrr = $_SESSION['user'];
    
    $_SESSION['user'] = $usrrr;
?>
<html>
    <head>
        <title>Загрузка файла на сайт</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
        <link rel="stylesheet" href="main.css">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
        <!-- Helping out oldtimers -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <!-- Google Maps -->
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <!-- Google fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

        
        <script src="script.js"></script>
        <script>
        function copyToClipboard(elementId) {
            // Create an auxiliary hidden input
            var aux = document.createElement("input");

            // Get the text from the element passed into the input
            aux.setAttribute("value", document.getElementById(elementId).innerHTML);

            // Append the aux input to the body
            document.body.appendChild(aux);

            // Highlight the content
            aux.select();

            // Execute the copy command
            document.execCommand("copy");

            // Remove the input from the body
            document.body.removeChild(aux);
        }
        </script>
        <?php
        function isImage($path){
            $a = getimagesize($path);
            $image_type = $a[2];

            if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
            {
                return true;
            }
            return false;
        }
        ?>
    </head>
    <body>
        <?php if($usrrr == "Admin"){ ?>
        <form method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <input type="text" name="name" placeholder="Задайте имя файлу иначе файл загрузится со случайным номером"/>
                        <label for="file">Загрузка фотографии</label>
                        <input type="file" class="form-control-file" id="file" aria-describedby="fileHelp">
                        <small id="fileHelp" class="form-text text-muted">Загрузите новый файл или скопируйте ссылку на файл из существующего списка.</small>
                      </div>
        </form>
	<div class="form-group" id="photo-content">
          <?php 
          $fullPath = "./upload";
          $files = scandir($fullPath);
          $id = 0;
          foreach($files as $file) {
                $pathSrc = './file.png';
                if(isImage("./upload/".$file)) $pathSrc = "./upload/".$file;
                else $pathSrc = './file.png';
                //
          	if($file=="."||$file=="..") continue;
                
                $idn = "file".$id;
          ?>            
		  	<div class="banner-item <?php if($row["banner"]==$file) echo "active-banner"?>">
		  		<span class="banner-rem-btn" data-filename="<?php echo $file?>">x</span>
		  		<div>
                                    <h6 id='<?php echo $idn; ?>' style='width:100%;position:absolute;top:0%;overflow-x: hidden;opacity:0.0'><?php echo $_SERVER['SERVER_NAME']?>/resources/files/upload/<?php echo $file?></h6>
                                    <h6 style='width:100%;position:absolute;top:30%;overflow-x: hidden;background-color: rgba(255,255,255,0.8)'><?php echo $file?></h6>
                                    <button style='position:absolute;bottom:0%;background-color: rgba(255,255,255,0.7)' onclick="copyToClipboard('<?php echo $idn; ?>')">Копировать ссылку</button>
                                    <img src="<?php echo $pathSrc?>"/>
		  		</div>
                                <a class="btn btn-success" style='width:80%;margin-top:2px;' href='./upload/<?php echo $file?>' download='<?php echo $file?>'>Скачать</a>
		  	</div>
		  <?php $id++; }?>
	</div>
        <?php }else{ ?>
        <h4>Чтобы пользоваться данным разедом вам необходимо войти через данные администратора.</h4>
        <?php } ?>
    </body>
</html>