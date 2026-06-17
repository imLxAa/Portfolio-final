<?php
    // tester la présence de id dans l'url
    if(isset($_GET['id']) && is_numeric($_GET['id']))
    {
        // protèger la valeur
        $id = htmlspecialchars($_GET['id']);
    }// sinon
    else{
        // redirection vers 404
        header("LOCATION:404.php");
        exit();
    }

    require "config/connexion.php";

    // req à la bdd pour vérifier si l'id existe et même temps récup les infos
    $req = $bdd->prepare("SELECT * FROM products WHERE id=?");
    //$req = $bdd->query("SELECT * FROM products WHERE id=25");
    $req->execute([$id]);
    // si id=25 => SELECT * FROM products WHERE id=25
    // récup les données
    $don = $req->fetch();

    // vérifier si j'ai bien des données
    if(!$don)
    {
        header("LOCATION:404.php");
        exit();
    }

    require_once "config/youtube-embed.php";

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include("partials/favicon.php"); ?>
    <link rel="stylesheet" href="assets/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <script src="assets/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="dist/css/glightbox.min.css">
     <link rel="stylesheet" href="build/style.css">
    <title>Projet - <?= $don['name'] ?></title>
</head>
<body class="page-product">
<?php
    $navBack = [
        'href' => 'categories.php',
        'label' => '←',
        'aria' => 'Retour aux projets',
    ];
    include("partials/nav-minimal.php");
?>
<a href="categories.php" class="projects-back projects-back--side" aria-label="Retour aux projets">← Retour aux projets</a>
<div class="container product-page">
    <div class="row">
        <div class="col-md-6">
            <a href='images/<?= $don['cover'] ?>' class="myimg">
                <img src="images/<?= $don['cover'] ?>" alt="image de <?= $don['name'] ?>" class="img-fluid">
            </a>
        </div>
        <div class="col-md-6">
            <h1><?= $don['name'] ?></h1>
            <h4><?= $don['date'] ?></h4>
            <div><?= product_description_with_youtube_previews($don['description']) ?></div>



            <h4>Galerie d'image</h4>
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <?php
                    $galerie = $bdd->prepare("SELECT * FROM images WHERE id_product=?");
                    $galerie->execute([$id]);
                    $count = $galerie->rowCount();
                    if($count > 0)
                    {
                        $cpt = 1;
                        while($donGal = $galerie->fetch())
                        {
                            if($cpt == 1)
                            {
                                echo "<div class='carousel-item active'>";
                            }
                            else{
                                echo "<div class='carousel-item'>";
                            }
                            echo "<a href='images/".$donGal['fichier']."' class='myimg'>";
                            echo "<img src='images/".$donGal['fichier']."' class='d-block w-100 myimg' alt='image de galere de".$don['name']."'>";
                            echo "</a>";
                            echo "</div>";
                            $cpt++;
                        }
                    }
                    else{
                        echo "<p>Aucune image pour le moment</p>";
                    }
                    $galerie->closeCursor();

                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

</div>
<script src="js/nav-menu.js"></script>
<script src="dist/js/glightbox.min.js"></script>
<script>
    var lightbox = GLightbox();
    var lightboxInlineIframe = GLightbox({
        selector: '.myimg'
    });
</script>
</body>
</html>