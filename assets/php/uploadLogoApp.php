<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'svg');

    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){ 
                $fileNameNew = "Logo.".$fileActualExt; 
                $fileDestination = $_SERVER['DOCUMENT_ROOT'].'/INIAP/assets/images/'.$fileNameNew;
                if(move_uploaded_file($fileTmpName, $fileDestination)){
                    echo 'El archivo se ha subido correctamente.';
                    header("Location: /INIAP/index.php?uploadsuccess"); // Redirecciona a la página principal después de la subida
                }else{
                    echo "Hubo un error al subir tu archivo.";
                }
            }else{
                echo "El archivo es demasiado grande.";
            }
        }else{
            echo "Hubo un error al subir tu archivo.";
        }
    }else{
        echo "No puedes subir archivos de este tipo.";
    }
} else {
    echo "No se recibió ninguna petición POST.";
}
?>
