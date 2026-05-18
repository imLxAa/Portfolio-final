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
<section class="about reveal-left" id="about">
    <h5>WHO AM I ?</h5>
    <p class="introduction">
        I am Alexandre / Lxaa. <br>
        Graphic design student in Belgium, passionate about design and web experience.
    </p>
    <div class="about-flex">
        <div class="left">
            <img src="images/moipetit.jpg" alt="portrait" class="portrait">
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


<section class="tools-section">
  <h1 class="tools-title">TOOLS</h1>
  <div class="tool-card">
    <div class="gallery">
        <?php
        require "config/connexion.php";
    
        $req = $bdd->query("SELECT * FROM skills");
        while($don = $req->fetch())
        {
            echo '<div class="col-lg-3 col-md-4 col-sm-6">';
                echo '<div class="card my-3">';
                    echo '<img src="images/'.$don['image'].'" class="card-img-top" alt="image de '.$don['nom'].'">';
                    echo ' <div class="card-body">';
                        echo '<h5 class="card-title">'.$don['nom'].'</h5>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
        $req->closeCursor();

        // req pour dernière compétences
        // $works = $bdd->query("SELECT products.cover AS cover, products.name AS pname, categories.name AS cname, DATE_FORMAT(products.date, '%d/%m/%Y') AS mydate, products.id AS pid, categories.id AS cid FROM products INNER JOIN categories ON products.category = categories.id ORDER BY products.date DESC LIMIT 0,6");
      
        ?>
    </div>
    <div id="view">
  <a href="categories.php" class="view-more">
    View more
    <span class="arrow">›</span>
  </a>
</div>
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
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrollTrigger.min.js"></script>

<script src="https://unpkg.com/lenis@1.1.14/dist/lenis.min.js"></script>

<script src="script.js"></script>


<script>
        const burger = document.getElementById("burger");
        const panel = document.getElementById("panel");
        const overlay = document.getElementById("overlay");

        function openMenu() {
            burger.classList.add("open");
            panel.classList.add("open");
            overlay.classList.add("open");

            // gestion inclusive
            burger.setAttribute("aria-expanded", "true");
            panel.setAttribute("aria-hidden", "false");

            // éviter le scroll
            document.body.style.overflow = "hidden";
        }

        function closeMenu() {
            burger.classList.remove("open");
            panel.classList.remove("open");
            overlay.classList.remove("open");
            burger.setAttribute("aria-expanded", "false");
            panel.setAttribute("aria-hidden", "true");
            document.body.style.overflow = "";
        }

        // fonction fléchée () => {}
        burger.addEventListener("click", () => {
            if( burger.classList.contains("open"))
            {
                closeMenu();
            }else{
                openMenu();
            }
        });

        overlay.addEventListener("click", closeMenu);

        document.addEventListener("click", "keydown", (e) => {
            if(e.key === "Escape") {
                closeMenu();
            }
        });
        
    </script>


</body>
</html>
