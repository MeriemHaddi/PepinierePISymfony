<?php
$uploads_dir = '';
if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {
echo  "File ".  $_FILES['userfile']['name']  ." uploaded successfully to 
$uploads_dir/$dest.\n";
$dest=  $_FILES['userfile'] ['name'];
if (!file_exists(dirname(__FILE__)."/img/".$_GET['dir']."/".$_GET['id'])) {
    mkdir(dirname(__FILE__)."/img/".$_GET['dir']."/".$_GET['id'], 0777, true);
}
move_uploaded_file ($_FILES['userfile'] ['tmp_name'], dirname(__FILE__)."/img/".$_GET['dir']."/".$_GET['id']."/$dest");
} else {
echo "Possible file upload attack: ";
echo "filename '". $_FILES['userfile']['tmp_name'] . "'.";
print_r($_FILES);
}
?>