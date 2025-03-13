<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

/**
 * Função para adicionar recursos ao header
 */
function plugin_glpitypebotchat_add_head() {
    global $CFG_GLPI;
    
    // Verifica se o usuário está autenticado
    if (!isset($_SESSION['glpiID']) || $_SESSION['glpiID'] <= 0) {
        return '';
    }
    
    $out = '';
    
    // Adiciona preload para fontes
    $out .= '<link rel="preload" href="' . $CFG_GLPI["root_doc"] . '/public/lib/fontawesome/css/all.min.css" as="style">';
    
    // Adiciona CSS do FontAwesome
    $out .= '<link rel="stylesheet" type="text/css" href="' . $CFG_GLPI["root_doc"] . '/public/lib/fontawesome/css/all.min.css">';
    
    return $out;
} 