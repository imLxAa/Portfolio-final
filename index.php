<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="build/style.css" href="https://jsdelivr.net">
    <title>LxaaPortfolio</title>
</head>
<body>
<?php
    include("partials/nav.php");
?>
<div class="slide" id="home">
    <div class="space left-space">
        <img src="images/cross.svg" alt="cross" class="cross top-cross">
        <div id="circles">
            <img src="images/circle.svg" alt="circle">
            <img src="images/circle.svg" alt="circle">
            <img src="images/circle.svg" alt="circle">
            <img src="images/circle.svg" alt="circle">
        </div>
        <img src="images/cross.svg" alt="cross" class="cross">
    </div>
    <div class="space right-space">
        <img src="images/cross.svg" alt="cross" class="cross">
        <img src="images/cross.svg" alt="cross" class="bottom-cross">
    </div>
    <div class="middle">
            <div class="title">
    <p class="intro">Who am I ?</p>

    <h1 class="name">Lxaa</h1>

    <h1 class="pex">Pixels</h1>

    <p class="job">Web designer / Graphic designer</p>

        </div>
    </div>
    <div class="end">
    </div>
</div>
<section class="about reveal-left" id="about">
    <h5>WHO AM I ?</h5>
    <p class="introduction">
        I am Alexandre / Lxaa. <br>
        Graphic design student in Belgium, passionate about design and web experience.
    </p>
    <div class="about-flex">
        <div class="left">
            <img src="images/moipetit.jpg" class="portrait">
        </div>
        <div class="right">
            <div class="year">
                <p>•2023</p>
                <p>First year of computer graphics</p>
            </div>
            <div class="year">
                <p>•2024</p>
                <p>Beginning portfolio</p>
            </div>
            <div class="year">
                <p>•FUTUR</p>
                <p>Portfolios interactifs / UX</p>
            </div>
        </div>
    </div>
</section>


<section class="tools-section" id="tools">
  <h1 class="tools-title">TOOLS</h1>
  <div class="tool-card">
    <div class="gallery">
        <?php include("partials/tools-gallery.php"); ?>
    </div>
</div>
</section>


<section class="recent-work" id="work">
    <h1 class="section-title">RECENT WORK</h1>
    <div class="work-gallery">
        <?php
        require_once "config/product-image.php";
        if (!isset($bdd)) {
            require "config/connexion.php";
        }
        $works = $bdd->query(
            "SELECT products.cover AS cover, products.name AS pname, products.id AS pid
             FROM products
             ORDER BY products.date DESC
             LIMIT 6"
        );
        $workCount = 0;
        while ($don = $works->fetch()) {
            $workCount++;
            $cover = $don['cover'];
            $name = htmlspecialchars($don['pname'], ENT_QUOTES, 'UTF-8');
            $pid = (int) $don['pid'];
            $imgSrc = htmlspecialchars(product_image_src($cover), ENT_QUOTES, 'UTF-8');
            $featured = $workCount === 1 ? ' work-card--featured' : '';
            ?>
            <a href="product.php?id=<?= $pid ?>" class="work-card<?= $featured ?>" title="<?= $name ?>">
                <img src="<?= $imgSrc ?>" alt="<?= $name ?>" loading="lazy">
            </a>
            <?php
        }
        $works->closeCursor();
        if ($workCount === 0) {
            echo '<p class="work-gallery-empty">Aucun projet pour le moment. Ajoute tes créations depuis l’admin.</p>';
        }
        ?>
    </div>
    <div id="view">
        <a href="categories.php" class="view-more">
            View more
            <span class="arrow">›</span>
        </a>
    </div>
</section>


<section class="slide" id="contact">
    <div class="contact-container">
        <h3 class="contact-title">Contact</h3>
        <p class="contact-description">Available for interships, freelance projects or collaborations.</p>
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
        <form action="treatmentContact.php" method="POST" class="contact-form">
            <div class="form-group">
                <input type="text" name="nom" placeholder="nom">
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="e-mail">
            </div>
            <div class="form-group">
                <textarea name="message" id="message" placeholder="message"></textarea>
            </div>
            <button class="btn-17">
        <span class="text-container">
            <span class="text">Submit</span>
        </span>
</button>

        </form>
    </div>
</section>


<footer id="footer">
    <div class="footer-content">
        <h2 class="footer-logo">
            Lxaa<span>&copy;</span>
        </h2>
        <h1 class="footer-title">
            Web Designer,
        </h1>
        <h1 class="footer-subtitle">
            Graphic Designer
        </h1>
        <div class="footer-links">
            <a href="https://instagram.com/a.l.ks">Instagram</a>
            <span>|</span>
            <a href="https://x.com/LxaaStudio">X</a>
            <span>|</span>
            <a href="#">E-mail</a>
            <span>|</span>
            <a href="#">Website</a>

        </div>

</footer>


<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrollTrigger.min.js"></script>

<script src="https://unpkg.com/lenis@1.1.14/dist/lenis.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrambleTextPlugin.min.js"></script>

<script src="script.js"></script>
<script src="js/nav-menu.js"></script>


</body>
</html>
