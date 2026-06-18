<?php
$navBack = $navBack ?? null;
?>
<?php if ($navBack): ?>
    <a
        href="<?= htmlspecialchars($navBack['href'], ENT_QUOTES, 'UTF-8') ?>"
        class="projects-back projects-back--nav"
        aria-label="<?= htmlspecialchars($navBack['aria'] ?? $navBack['label'], ENT_QUOTES, 'UTF-8') ?>"
    ><span class="projects-back__icon" aria-hidden="true"><?= htmlspecialchars($navBack['label'], ENT_QUOTES, 'UTF-8') ?></span></a>
<?php endif; ?>
<nav class="main-nav">
    <a href="index.php" class="logo">Lxaa</a>
    <button id="burger" type="button" aria-label="Menu" aria-expanded="false">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>
</nav>
<div class="overlay" id="overlay"></div>
<aside class="panel" id="panel" aria-hidden="true">
    <ul class="nav-links">
        <li><a href="index.php#tools">Tools</a></li>
        <li><a href="categories.php">Works</a></li>
        <li><a href="index.php#contact">Contact</a></li>
    </ul>
    <div class="panel-footer">
        <div class="socials">
            <a href="https://www.instagram.com/lxaastudio/">Instagram</a>
            <a href="https://x.com/LxaaStudio">X</a>
        </div>
        <span class="panel-year">&copy; 2026</span>
    </div>
</aside>
