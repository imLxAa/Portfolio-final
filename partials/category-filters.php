<?php
if (!isset($bdd)) {
    require __DIR__ . "/../config/connexion.php";
}
$activeCategory = $activeCategory ?? null;
?>
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
