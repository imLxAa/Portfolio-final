<?php
require "config/connexion.php";
require_once "config/product-image.php";

$activeCategory = null;
$activeCategoryName = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $categoryId = (int) $_GET['id'];
    $reqSecu = $bdd->prepare("SELECT * FROM categories WHERE id = ?");
    $reqSecu->execute([$categoryId]);
    $donSecu = $reqSecu->fetch(PDO::FETCH_ASSOC);
    if (!$donSecu) {
        header("Location: 404.php");
        exit();
    }
    $activeCategory = $categoryId;
    $activeCategoryName = $donSecu['name'];
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="build/style.css">
    <title>Voir plus de projets — LxaaPortfolio</title>
</head>
<body class="page-projects">
<?php include("partials/nav-minimal.php"); ?>

<section class="projects-page">
    <div class="projects-head">
        <h1 class="section-title">More Work</h1>
        <p class="projects-intro">
            <?php if ($activeCategoryName): ?>
                <?= htmlspecialchars($activeCategoryName, ENT_QUOTES, 'UTF-8') ?>
            <?php else: ?>
                Choisis une catégorie pour filtrer tes réalisations
            <?php endif; ?>
        </p>
    </div>

    <div class="projects-filters">
        <nav class="category-filters" aria-label="Filtrer par catégorie">
            <a href="categories.php" class="filter-btn<?= $activeCategory === null ? ' is-active' : '' ?>">Tous</a>
            <?php
            $catList = $bdd->query("SELECT id, name FROM categories ORDER BY name ASC");
            while ($donCatList = $catList->fetch()) {
                $cid = (int) $donCatList['id'];
                $cname = htmlspecialchars($donCatList['name'], ENT_QUOTES, 'UTF-8');
                $isActive = $activeCategory === $cid ? ' is-active' : '';
                echo '<a href="categories.php?id=' . $cid . '" class="filter-btn' . $isActive . '">' . $cname . '</a>';
            }
            $catList->closeCursor();
            ?>
        </nav>
    </div>

    <div class="projects-grid">
        <?php
        if ($activeCategory === null) {
            $req = $bdd->query(
                "SELECT products.cover AS cover, products.name AS pname, categories.name AS cname,
                        DATE_FORMAT(products.date, '%d/%m/%Y') AS mydate, products.id AS pid, categories.id AS cid
                 FROM products
                 INNER JOIN categories ON products.category = categories.id
                 ORDER BY products.date DESC"
            );
        } else {
            $req = $bdd->prepare(
                "SELECT products.cover AS cover, products.name AS pname, categories.name AS cname,
                        DATE_FORMAT(products.date, '%d/%m/%Y') AS mydate, products.id AS pid, categories.id AS cid
                 FROM products
                 INNER JOIN categories ON products.category = categories.id
                 WHERE products.category = ?
                 ORDER BY products.date DESC"
            );
            $req->execute([$activeCategory]);
        }

        $hasProjects = false;
        while ($don = $req->fetch()) {
            $hasProjects = true;
            $pname = htmlspecialchars($don['pname'], ENT_QUOTES, 'UTF-8');
            $cname = htmlspecialchars($don['cname'], ENT_QUOTES, 'UTF-8');
            $cover = htmlspecialchars($don['cover'], ENT_QUOTES, 'UTF-8');
            $mydate = htmlspecialchars($don['mydate'], ENT_QUOTES, 'UTF-8');
            $pid = (int) $don['pid'];
            $cid = (int) $don['cid'];
            ?>
            <article class="project-card">
                <a href="product.php?id=<?= $pid ?>" class="project-card-image">
                    <img src="<?= htmlspecialchars(product_image_src($don['cover']), ENT_QUOTES, 'UTF-8') ?>" alt="<?= $pname ?>">
                </a>
                <div class="project-card-body">
                    <h2><?= $pname ?></h2>
                    <p class="project-date"><?= $mydate ?></p>
                    <a href="categories.php?id=<?= $cid ?>" class="project-category"><?= $cname ?></a>
                    <a href="product.php?id=<?= $pid ?>" class="project-link">Voir le projet →</a>
                </div>
            </article>
            <?php
        }
        if (!$hasProjects) {
            echo '<p class="projects-empty">Aucun projet dans cette catégorie pour le moment.</p>';
        }
        $req->closeCursor();
        ?>
    </div>
</section>

<a href="index.php#work" class="projects-back" aria-label="Retour au portfolio">← Portfolio</a>

<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js"></script>
<script src="js/nav-menu.js"></script>
<script src="js/projects-page.js"></script>
</body>
</html>
