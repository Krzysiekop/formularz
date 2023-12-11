<?php

$successful  = 0 ;
$errorAlert = "";

//sprawdzam czy podano wymagane dane i pliki
if (isset($_POST['first_name']) && isset($_POST['surname']) && isset($_POST['birthDate']) && isset($_POST['email']) &&
    isset($_POST['school'])  && $_FILES["cv"] && $_FILES["motivation"] ) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['surname'];
    $birthDate = $_POST['birthDate'];
    $email = $_POST['email'];
    $school = $_POST['school'];

    //Tworzę stringa ze staży
    if (isset($_POST['nazwa'])) {
        $internshipsCounter = count($_POST['nazwa']);

        for ($i = 0; $i < $internshipsCounter; $i++) {
            $internships[] = $_POST['nazwa'][$i] . ',' . $_POST['od'][$i] . ',' . $_POST['do'][$i];
        }
        $internshipString = implode('|', $internships);
    }
    else{
        $internshipString = null;
    }
//obsługa cv
    if (isset($_FILES["cv"])) {
        $errors = array();
        $file_nameCV = $_FILES['cv']['name'];

        $file_sizeCV = $_FILES['cv']['size'];
        $file_tmpCV = $_FILES['cv']['tmp_name'];
        $file_typeCV = $_FILES['cv']['type'];
        $file_explodeCV = explode('.', $_FILES['cv']['name']);
        $file_extCV = strtolower(end($file_explodeCV));


        $extensions = array("pdf", "jpg", "doc");

        if (in_array($file_extCV, $extensions) === false) {
            $errorAlert .= "extension not allowed, please choose a JPEG or PNG file.";
        }

        if (empty($errors) == true) {
            move_uploaded_file($file_tmpCV, "D:/" . $file_nameCV);

        } else {

            $successful = 0;
        }
    }

//obsługa LM
    if (isset($_FILES["motivation"])) {
        $errors2 = array();
        $file_nameMot = $_FILES['motivation']['name'];

        $file_sizeMot = $_FILES['motivation']['size'];
        $file_tmpMot = $_FILES['motivation']['tmp_name'];
        $file_typeMot = $_FILES['motivation']['type'];
        $file_explodeMot = explode('.', $_FILES['motivation']['name']);
        $file_extMot = strtolower(end($file_explodeMot));

        $extensions = array("pdf", "jpg", "doc");

        if (in_array($file_extMot, $extensions) === false) {
            $errors2[] = "extension not allowed, please choose a JPEG or PNG file.";
        }

        if (empty($errors2) == true) {
            move_uploaded_file($file_tmpMot, "D:/" . $file_nameMot);

        } else {

            $successful = 0;
        }
    }

//Obsługa ewentualnego CV 2
    if (isset($_FILES["cv2"])) {
        $errors3 = array();
        $file_nameCV2 = $_FILES['cv2']['name'];

        $file_sizeCV2 = $_FILES['cv2']['size'];
        $file_tmpCV2 = $_FILES['cv2']['tmp_name'];
        $file_typeCV2 = $_FILES['cv2']['type'];
        $file_explodeCV2 = explode('.', $_FILES['cv2']['name']);
        $file_extCV2 = strtolower(end($file_explodeCV2));

        $extensions = array("pdf", "jpg", "doc");

        if (in_array($file_extCV2, $extensions) === false) {
            $errorAlert .= "extension not allowed, please choose a JPEG or PNG file.";
        }

        if (empty($errors3) == true) {
            move_uploaded_file($file_tmpCV2, "D:/" . $file_nameCV2);

        } else {
            $successful = 0;
        }
    } else {
        $file_nameCV2 = null;
    }

    //Twoje dane bazy danych
    $servername = "localhost";
    $username = "root";
    $password = "";

    //zapisuję dane do bazy
    try {
        $conn = new PDO("mysql:host=$servername;dbname=kandydat", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO `candidate`(`id`, `name`, `surname`, `birthDate`, `email`, `education`, `cv`, `motivationLetter`, `cv2`, `internships`)
VALUES (:id,:first_name,:last_name, :birthDate,:email ,:education,:cv,:motivationLetter,:cv2,:internshipString)";

        $query_run = $conn->prepare($query);

        $data = [
            ":id" => '',
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':birthDate' => $birthDate,
            ':email' => $email,
            ':education' => $school,
            ":cv" => $file_nameCV,
            ":motivationLetter" => $file_nameMot,
            ":cv2" => $file_nameCV2,
            ":internshipString" => $internshipString,
        ];
        $query_execute = $query_run->execute($data);

        if ($query_execute) {

        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
else{
    $errorAlert .=  'Brak wymaganych danych lub dołączonych plików';
    $successful = 0;
}

if ($successful = 0){
    echo $errorAlert;
}else{
    echo 'Dziękujemy za wypełnienie formularza';
}
