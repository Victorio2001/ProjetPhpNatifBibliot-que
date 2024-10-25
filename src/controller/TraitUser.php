<?php
require_once("../../config/localConfig.php");
use MonApp\model\DTO\Utilisateur;
use MonApp\model\DAO\DAOUtilisateur;
use MonApp\model\DAO\DAORole;
//Lien vers la documentation gitHub "https://github.com/PHPMailer/PHPMailer"
//Video super utilie https://www.youtube.com/watch?v=9tD8lA9foxw
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$DAORole = new DAORole();
$DAOUtilisateur = new DAOUtilisateur();
$Utilisateur = new Utilisateur();
if(isset($_SESSION['userLog'])){
    $user = $_SESSION['userLog'];
    $userMail = $user->getEmailUtilisateur();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UserConnectForm'])) {
    if(hash_equals($_SESSION['tokenUserConnect'], $_POST['tokenUserForm']))
    {
        unset($_SESSION['tokenUserConnect']);
        unset( $_SESSION['userLog']);

        $filters = [
            'mail' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'password' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

        $Utilisateur->setEmailUtilisateur($mail);
        $Utilisateur->setPasswordUtilisateur($password);

        $result = $DAOUtilisateur->getByEmailAndPassword($Utilisateur);
        if($result !== null){
            $_SESSION['userLog'] = $result;
            header('location: ../../src/view/Accueil.php?succes=login');
        }else{
            $message = "Mot de passe ou E-mail incorrect";
            header('location: ../../src/view/Connection.php?error=AddFalse&message=' .$message);
        }
    } else {
        header('location: ../../src/view/ErrorPage.php?error=token');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addUtilisateur'])) {

        $filters = [
            'nomUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'prenomUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'passwordUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'emailUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'compteActif' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'idRole' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

        $MdpHash = password_hash($passwordUtilisateur, PASSWORD_DEFAULT);
        $Utilisateur->setNomUtilisateur($nomUtilisateur);
        $Utilisateur->setPrenomUtilisateur($prenomUtilisateur);
        $Utilisateur->setPasswordUtilisateur($MdpHash);
        $Utilisateur->setEmailUtilisateur($emailUtilisateur);
        $Utilisateur->setCompteActif((bool)$compteActif);
        $Utilisateur->setRole($DAORole->getRoleById((int)$idRole));

        if(strlen($passwordUtilisateur) < 12 ){
            $message = "Le mot de passe doit contenir au moins 12 caractères.";
            header("location: ../../src/view/listeUserPageAdmin.php?error=AddFalse&message=" .$message);
        } elseif (!preg_match('/\d/', $passwordUtilisateur)) {
            $message = "Le mot de passe doit contenir des chiffres";
            header("location: ../../src/view/listeUserPageAdmin.php?error=AddFalse&message=" .$message);
        }elseif (!preg_match('/\W/', $passwordUtilisateur)) {
            $message = "Le mot de passe doit contenir des caractères spéciaux ";
            header("location: ../../src/view/listeUserPageAdmin.php?error=AddFalse&message=" .$message);
        }else{
            $result = $DAOUtilisateur->insertutilisateur($Utilisateur);
            $NameUserAdd =  $Utilisateur->getPrenomUtilisateur();
            if($result !== null){
                $message = "Ajout de l'utilisateur Correct !";
                header("location: ../../src/view/listeUserPageAdmin.php?succes=AddTrue&message=" .$message);
            }else{
                $message = "Ajout de l'utilisateur Incoorrect !";
                header("location: ../../src/view/listeUserPageAdmin.php?error=AddFalse&message=" .$message);
            }
        }


}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['DeleteButton'])) {

    $filters = [
        'DeleteButton' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $result = $DAOUtilisateur->deleteUtilisateur((int)$DeleteButton);
    if($result !== null){
        header('location: ../../src/view/listeUserPageAdmin.php?succes=DeleteTrue');
    }else{
        header('location: ../../src/view/listeUserPageAdmin.php?error=DeleteFalse');
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateButton'])) {
    $filters = [
        'UpdateButton' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $_SESSION['UpdateUser'] = $UpdateButton;

    if($_SESSION['UpdateUser'] !== null){
        header('location: ../../src/view/FormEditUser.php');
    }else{
        header('location: ../../src/view/listeUserPage.php?error=DeleteFalse');
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateUser'])) {

    $filters = [
        'idUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'nomUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'prenomUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'passwordUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'emailUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'compteActif' => FILTER_VALIDATE_BOOLEAN,
        'idRole' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $MdpHash = password_hash($passwordUtilisateur, PASSWORD_DEFAULT);
    $Utilisateur->setIdUtilisateur($idUtilisateur);
    $Utilisateur->setNomUtilisateur($nomUtilisateur);
    $Utilisateur->setPrenomUtilisateur($prenomUtilisateur);
    $Utilisateur->setPasswordUtilisateur($MdpHash);
    $Utilisateur->setEmailUtilisateur($emailUtilisateur);
    $Utilisateur->setCompteActif((bool)$compteActif);
    $Utilisateur->setRole($DAORole->getRoleById((int)$idRole));



    $result = $DAOUtilisateur->updateUtilisateur($Utilisateur);
    if($result !== null){
        $message = "Modification effectuée avec succès.";
        header('location: ../../src/view/listeUserPageAdmin.php?succes=AddTrue&message=' .$message);
    }else{
        $message = "Modification erronée.";
        header('location: ../../src/view/listeUserPageAdmin.php?error=AddFalse&message=' .$message);
    }

}





