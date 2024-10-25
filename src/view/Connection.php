<?php
require_once '../../config/localConfig.php';
$tokenUserForm = bin2hex(random_bytes(15));
$_SESSION['tokenUserConnect'] = $tokenUserForm;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Connection</title>
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        #wrapper {
            padding-bottom: 60px;
        }
    </style>
</head>

<body id="page-top">
<div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include '../../public/inc/topBar.php' ?>
            <div class="container mt-5">
                <section class="">
                    <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: #F5F5F5">
                            <div class="row gx-lg-5 align-items-center">
                                <div class="col-lg-6 mb-5 mb-lg-0">
                                    <h1 class="my-5 display-3 fw-bold ls-tight">
                                        Bienvenue sur Biblio'Olen,<br />
                                        <span style="color: #4682B4" >votre passerelle vers le savoir ! </span>
                                    </h1>
                                    <p style="color: #4682B4">
                                        Notre Bibliothèque se situe dans la célèbre école nommé l'ort,
                                        une école où le savoir se transmet depuis des décennies.
                                        Retrouver nous sur nôtre site <a href="https://ort-france.fr/lyon"> web ici.</a>
                                    </p>
                                </div>

                                <div class="col-lg-6 mb-5 mb-lg-0">

                                    <?php
                                    //https://getbootstrap.com/docs/4.0/components/alerts/
                                    //https://openclassrooms.com/forum/sujet/afficher-l-erreur-en-get
                                    if (isset($_GET['succes'])) {
                                        $succes = $_GET['succes'];
                                        if ($succes == 'AddTrue') {
                                            $message = $_GET['message'];
                                            echo ' <div style=" text-align: center" class="alert alert-success" role="alert">
                                                       '.$message.'
                                                   </div>';
                                        }
                                    }
                                    if (isset($_GET['error'])) {
                                        $error = $_GET['error'];
                                        if ($error == 'AddFalse') {
                                            $message = $_GET['message'];
                                            echo ' <div style="text-align: center" class="alert alert-danger" role="alert">
                                                      '.$message.'
                                                   </div>';
                                        }
                                    }
                                    ?>
                                    <div class="card">
                                        <div class="card-body py-5 px-md-5">
                                            <form action="../../src/controller/TraitUser.php" method="post">
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="mail">Votre E-mail</label>
                                                <input type="email" id="mail" name="mail" class="form-control" />
                                            </div>
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="password">Mot de passe</label>
                                                <input type="password" id="password" name="password" class="form-control" />
                                            </div>
                                            <input type="hidden" name="tokenUserForm" class="form-control" value="<?php echo $tokenUserForm  ?>"  required>
                                            <button style="background-color: #4682B4;" name="UserConnectForm" type="submit" class="btn btn-primary btn-block mb-4">
                                                Se connecter
                                            </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <hr class="hr mx-2 " />

                <section class="mt-2" style="display: flex; justify-content: center;">
                    <div class="col-md-9">
                        <img style="object-fit: fill; width: 100%;" src="../../public/img/Ort.jpg" alt="">
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php include '../../public/inc/footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
