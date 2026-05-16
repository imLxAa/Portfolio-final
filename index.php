<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="build/style.css">
    <title>Document</title>
</head>
<body>
<?php
    include("partials/nav.php");
?>
<div class="slide" id="home">
    <div class="space">
        <img src="images/cross.svg" alt="cross" class="cross">
        <div id="circles">
            <img src="images/circle.svg" alt="circle">
            <img src="images/circle.svg" alt="circle">
            <img src="images/circle.svg" alt="circle">
            <img src="images/circle.svg" alt="circle">
        </div>
        <img src="images/cross.svg" alt="cross" class="cross">
    </div>
    <div class="middle">
        <div class="title">
            <p>who am i ?</p>
            <h1>Lxaa</h1>
            <h1 class="pex">Pixels</h1>
            <p>Web designer / Graphic designer</p>
        </div>
        <div class="socials">
            <a href="https://instagram.com/a.l.ks" target="_blank">
                <img src="images/instagram.png" alt="instagram">
            </a>
            <a href="https://twitter.com/toncompte" target="_blank">
                <img src="images/twitter.png" alt="twitter">
            </a>
        </div>
    </div>
    <div class="end">
         
    </div>
</div>
<div class="slide" id="who">
    <div class="about">
        <p>Who am i ?</p>
            <p class="about1">I am Alexandre / Lxaa.
            </p>
            <p class="about2">Graphic design student in Belgium, passionate about design and web experience.
            </p>
    </div>
     <div class="timeline">
        <img src="images/moibis.png" alt="profile">
        <div class="year">
            <h4>2023</h4>
            <p>First year of computer graphics</p>
        </div>
        <div class="year">
            <h4>2024</h4>
            <p>Beginning portfolio</p>
        </div>
        <div class="year1">
            <h4>Future</h4>
            <p>UX / Interactive portfolio</p>
        </div>
    </div>
</div>
    




</div>
<div class="container">
    <a href="https://getbootstrap.com/docs/5.3/components/card/">Liens vers documentation Boostrap</a>
    <div class="row">
        <?php
        require "config/connexion.php";
        $req = $bdd->query("SELECT products.cover AS cover, products.name AS pname, categories.name AS cname, DATE_FORMAT(products.date, '%d/%m/%Y') AS mydate, products.id AS pid, categories.id AS cid FROM products INNER JOIN categories ON products.category = categories.id ORDER BY products.date DESC LIMIT 0,4");
        while($don = $req->fetch())
        {
            echo '<div class="col-lg-3 col-md-4 col-sm-6">';
                echo '<div class="card my-3">';
                    echo '<img src="images/mini_'.$don['cover'].'" class="card-img-top" alt="image de '.$don['pname'].'">';
                    echo ' <div class="card-body">';
                        echo '<h5 class="card-title">'.$don['pname'].'</h5>';
                        echo '<a href="category.php?id='.$don['cid'].'" class="btn btn-secondary">'.$don['cname'].'</a>';
                        echo ' <p class="card-text"><strong>Date: </strong>'.$don['mydate'].'</p>';
                        echo ' <a href="product.php?id='.$don['pid'].'" class="btn btn-primary">En savoir plus</a>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
        $req->closeCursor();
        ?>
    </div>
    <div class="d-flex justify-content-center my-5">
        <a href="categories.php" class="btn btn-primary">Voir plus</a>
    </div>
</div>
<div class="slide" id="contact">
    <div class="gauche"></div>
    <div class="droite">
        <h3>Contact</h3>
        <?php
            if(isset($_GET['success']))
            {
                echo "<div class='message-success'>Votre message à bien été envoyé! Merci</div>";
            }

            if(isset($_GET['error']))
            {
                echo "<div class='message-error'>Une erreur est survenue</div>";
            }

        ?>
        <form action="treatmentContact.php" method="POST">
            <div class="form-group">
                <label for="nom">Nom: </label>
                <input type="text" name="nom" id="nom">
            </div>
            <div class="form-group">
                <label for="email">E-mail: </label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="message">Message: </label>
                <textarea name="message" id="message"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Envoyer">
            </div>
        </form>
    </div>
</div>
</body>
</html>