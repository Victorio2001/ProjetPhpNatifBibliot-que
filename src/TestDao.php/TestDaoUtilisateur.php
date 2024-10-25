<?php
require_once '../../config/localConfig.php';
use MonApp\model\DAO\DAOUtilisateur;
use MonApp\model\DAO\DAORole;
$DAORole = new DAORole();


echo 'GetAllUtilisateur';
$DaoUtilisateur = new DAOUtilisateur();
$repoUsers = $DaoUtilisateur->getAllUtilisateur();
var_dump($repoUsers);


echo 'GetUserById';
$repoUser = $DaoUtilisateur->getUtilisateurById(-1);
var_dump($repoUser);


echo 'getUtilisateurByName';
$repoUserName = $DaoUtilisateur->getUtilisateurByName("a");
var_dump($repoUserName);


echo 'InserUtilisateur';
$monUser = new \MonApp\model\DTO\Utilisateur();
try{
    $MdpHash = password_hash("root", PASSWORD_DEFAULT);
    $monUser->setPrenomUtilisateur("Root");
    $monUser->setNomUtilisateur("Root");
    $monUser->setPasswordUtilisateur($MdpHash);
    $monUser->setEmailUtilisateur("root@gmail.com");
    $monUser->setCompteActif(true);
    $monUser->setRole($DAORole->getRoleById((int)-1));
    $insertUser = $DaoUtilisateur->insertutilisateur($monUser);
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe");
}


echo 'ConnectionUser';
$monUserConnecter = new \MonApp\model\DTO\Utilisateur();
$monUserConnecter->setPasswordUtilisateur('root');
$monUserConnecter->setEmailUtilisateur('root@gmail.com');
$result = $DaoUtilisateur->getByEmailAndPassword($monUserConnecter);
if($result !== null){
    echo' <br> <p style="color:green">Connection Parfaite</p>';
    unset($_SESSION['userConnecter']);
    $_SESSION['userConnecter'] = $result;
    $user = $_SESSION['userConnecter'];
    $userRole = $user->getRole()->getNomRole();
    switch ($userRole) {
        case "gestionnaire":
            echo'<p style="color:green">Tu es gestionnaire</p>';
            echo "<br>";
            break;
        case "formateur":
            echo'<p style="color:green">Tu es formateur.</p>';
            echo "<br>";
            break;
        case "etudiant":
            echo'<p style="color:green">Tu es étudiant.</p>';
            echo "<br>";
            break;
    }
}else{
    echo' <br> <p style="color:red">Connection Echouer</p>';
}


echo 'UpdateUtilisateur';
$monUserUpdate = new \MonApp\model\DTO\Utilisateur();
try{
    $MdpHash = password_hash("root", PASSWORD_DEFAULT);
    $monUserUpdate->setPrenomUtilisateur("RootUpdated");
    $monUserUpdate->setNomUtilisateur("Root");
    $monUserUpdate->setPasswordUtilisateur($MdpHash);
    $monUserUpdate->setEmailUtilisateur("root@gmail.com");
    $monUserUpdate->setCompteActif(true);
    $monUserUpdate->setRole($DAORole->getRoleById(-1));
    $monUserUpdate->setIdUtilisateur(21);
    var_dump($monUserUpdate);
    $updatetUser = $DaoUtilisateur->updateUtilisateur($monUserUpdate);
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Update)");
}

echo 'DeleteUtilisateur';
try {
    $DaoUtilisateur = new DAOUtilisateur();
    $repoUsers = $DaoUtilisateur->deleteUtilisateur(5000);
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Delete)");
}








