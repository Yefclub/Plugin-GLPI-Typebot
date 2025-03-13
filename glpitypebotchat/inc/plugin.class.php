<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

/**
 * Função para adicionar recursos ao header
 * Simplificada para minimizar a interferência com o GLPI
 */
function plugin_glpitypebotchat_add_head() {
    // Verifica se o usuário está realmente autenticado
    if (!isset($_SESSION['glpiID']) || $_SESSION['glpiID'] <= 0) {
        return '';
    }
    
    // Retorna apenas elementos básicos sem manipular outras partes do GLPI
    return ''; // Removido para evitar conflitos com o sistema
} 