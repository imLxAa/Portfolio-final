<?php
if (!isset($bdd)) {
    require __DIR__ . "/../config/connexion.php";
}
$activeCategory = $activeCategory ?? null;
?>
<div class="projects-filters">
    <p class="projects-filters-label">Filtrer par style</p>
    <div class="category-filters-wrap">
        <button type="button" class="filters-scroll-btn filters-scroll-btn--prev" aria-label="Filtres précédents" hidden>‹</button>
        <div class="category-filters-scroll" id="filtersScroll">
            <nav class="category-filters" aria-label="Filtrer par catégorie">
                <a href="categories.php" class="filter-btn<?= $activeCategory === null ? ' active' : '' ?>">Tous</a>
                <?php
                $catList = $bdd->query("SELECT * FROM categories ORDER BY name ASC");
                while ($donCatList = $catList->fetch()) {
                    $cid = (int) $donCatList['id'];
                    $cname = htmlspecialchars($donCatList['name'], ENT_QUOTES, 'UTF-8');
                    $isActive = $activeCategory === $cid ? ' active' : '';
                    echo '<a href="categories.php?id=' . $cid . '" class="filter-btn' . $isActive . '">' . $cname . '</a>';
                }
                $catList->closeCursor();
                ?>
            </nav>
        </div>
        <button type="button" class="filters-scroll-btn filters-scroll-btn--next" aria-label="Filtres suivants" hidden>›</button>
    </div>
</div>
