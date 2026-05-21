<?php
if (!isset($bdd)) {
    require __DIR__ . "/../config/connexion.php";
}
$skillsReq = $bdd->query("SELECT * FROM skills ORDER BY nom ASC");
$hasSkills = false;
while ($skill = $skillsReq->fetch()) {
    $hasSkills = true;
    $nom = htmlspecialchars($skill['nom'], ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars($skill['image'], ENT_QUOTES, 'UTF-8');
    echo '<div class="tool-gallery-item">';
    echo '<div class="tool-item">';
    echo '<img src="images/' . $image . '" class="card-img-top" alt="' . $nom . '">';
    echo '<span class="tooltip">' . $nom . '</span>';
    echo '</div>';
    echo '</div>';
}
$skillsReq->closeCursor();
if (!$hasSkills) {
    echo '<p class="tools-empty">Aucun outil pour le moment. Ajoute-les dans l’admin → Compétences.</p>';
}
