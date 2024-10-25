<?php
require_once '../../config/localConfig.php';
use MonApp\model\DAO\DAOAuteur;
$DaoAuteur = new DAOAuteur();
$repoAuteur = $DaoAuteur->getAllAuteur();

?>

<?php foreach ($repoAuteur as $Auteur): ?>
    <tr>
        <td><?php echo $Auteur->getPrenomAuteur(); ?></td>
        <td><?php echo $Auteur->getNomAuteur(); ?></td>
        <td><?php echo $Auteur->getIdAuteur(); ?></td>
    </tr>
<?php endforeach; ?>