<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$response = array();

$nameFile = $_POST['nameFile'];

$file = $_FILES['file']; // Aquí estaba el problema
$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];
$fileError = $file['error'];
$fileType = $file['type'];

$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

$allowed = array('png');

if (in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
        if ($fileSize < 1000000) {
            $fileNameNew = $nameFile . "." . $fileActualExt;
            $fileDestination = $_SERVER['DOCUMENT_ROOT'] . '/INIAP/assets/images/' . $fileNameNew;
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $response['success'] = true;
                $response['message'] = "El archivo se ha subido correctamente.";
            } else {
                $response['success'] = false;
                $response['message'] = "Hubo un error al subir tu archivo.";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "El archivo es demasiado grande.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Hubo un error al subir tu archivo.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "No puedes subir archivos de este tipo.";
}

header('Content-Type: application/json');
echo json_encode($response);
?>
