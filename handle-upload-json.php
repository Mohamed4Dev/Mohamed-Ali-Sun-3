<?php
session_start();

if (isset($_POST['submit'])) {
    $file = $_FILES['json'];

    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);



    //validation 
    /* 
        Rules 
            1 - upload can't be empty
            2 - no errors 
            3 - extention must be .json
    */
    $errors = [];

    if ($fileError != 0) {
        $errors[] = "Error uploading file";
    } elseif ($ext != "json") {
        $errors[] = "file extention must be json";
    }


    //if validate --> rename then --> move --> read
    if (empty($errors)) {
        //rename
        $randomStr = uniqid();
        $fileNewName = "$randomStr.$ext";

        //move destination
        $fileNewNameS = "uploads/$fileNewName"; // file new name on my (S)server
        move_uploaded_file($fileTmpName, $fileNewNameS);

        //read the submitted input file 
        $openedFile = fopen($fileNewNameS, "r");
        $fileSize = filesize($fileNewNameS);
        $fileRead = fread($openedFile, $fileSize);

        $_SESSION['sucess'] = "File uploaded successfully";
        //from json to php (json decode)
        $jsonObj = json_decode($fileRead, true);
        // store json array in session 
        $_SESSION['jsonData'] = $jsonObj;
        //redirect to display.php
        header("location: display.php");
        //done using opened file then --> close it.
        fclose($fileNewNameS);
    } else {
        // store errors in sessionError array
        $_SESSION['errors'] = $errors;
        //redirect to upload.php
        header("location: upload-json.php");
    }
}
