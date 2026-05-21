<?php

/**
 * Chemin public vers la vignette d'un produit (mini_ si elle existe, sinon image originale).
 */
function product_image_src(string $cover): string
{
    $cover = basename($cover);
    $mini = "images/mini_{$cover}";
    $full = "images/{$cover}";

    if (is_file(__DIR__ . "/../{$mini}")) {
        return $mini;
    }
    if (is_file(__DIR__ . "/../{$full}")) {
        return $full;
    }

    return $mini;
}
