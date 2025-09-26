<?php
/**
 * Fichier router pour le serveur PHP natif
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Si le fichier existe physiquement, laisse PHP le servir
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

// Sinon, redirige tout vers index.php de Laravel
require_once __DIR__.'/public/index.php';
