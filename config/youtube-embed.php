<?php

/**
 * Extrait l'identifiant vidéo d'une URL YouTube reconnue.
 */
function youtube_video_id_from_url(string $url): ?string
{
    $patterns = [
        '~(?:youtube\.com|youtube-nocookie\.com)/watch\?v=([\w-]{11})~i',
        '~youtu\.be/([\w-]{11})~i',
        '~(?:youtube\.com|youtube-nocookie\.com)/embed/([\w-]{11})~i',
        '~(?:youtube\.com|youtube-nocookie\.com)/shorts/([\w-]{11})~i',
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
    }

    return null;
}

/**
 * Lecteur YouTube intégré (iframe responsive).
 */
function youtube_embed_markup(string $videoId): string
{
    $videoId = preg_replace('/[^\w-]/', '', $videoId);
    if ($videoId === '') {
        return '';
    }

    $embedUrl = 'https://www.youtube.com/embed/' . rawurlencode($videoId);

    return '<div class="product-youtube-embed">'
        . '<iframe src="' . htmlspecialchars($embedUrl, ENT_QUOTES, 'UTF-8') . '"'
        . ' title="YouTube video player"'
        . ' allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"'
        . ' referrerpolicy="strict-origin-when-cross-origin"'
        . ' allowfullscreen loading="lazy"></iframe>'
        . '</div>';
}

/**
 * Remplace les liens YouTube (texte ou balises <a>) par un lecteur intégré dans la description produit.
 */
function product_description_with_youtube_previews(string $description): string
{
    if ($description === '') {
        return '';
    }

    $html = $description;

    $html = preg_replace_callback(
        '~<a\s[^>]*\bhref=(["\'])([^"\']+)\1[^>]*>.*?</a>~is',
        static function (array $match): string {
            $videoId = youtube_video_id_from_url(html_entity_decode($match[2], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            return $videoId !== null ? youtube_embed_markup($videoId) : $match[0];
        },
        $html
    ) ?? $html;

    $html = preg_replace_callback(
        '~(?<!["\'=/>])(?:https?://)?(?:www\.)?(?:'
        . '(?:youtube\.com|youtube-nocookie\.com)/watch\?v='
        . '|youtu\.be/'
        . '|(?:youtube\.com|youtube-nocookie\.com)/embed/'
        . ')([\w-]{11})(?:[&?#][^\s<"]*)?~i',
        static function (array $match): string {
            return youtube_embed_markup($match[1]);
        },
        $html
    ) ?? $html;

    return $html;
}
