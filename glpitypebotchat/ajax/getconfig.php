<?php

include ("../../../inc/includes.php");

// Verifica se o usuário está autenticado
Session::checkLoginUser();

// Configurações de cabeçalho
header('Content-Type: application/json');

global $DB;

// Verifica se a tabela existe antes de tentar obter as configurações
if ($DB->tableExists('glpi_plugin_glpitypebotchat_configs')) {
    // Obtém as configurações do plugin
    $config = PluginGlpitypebotchatConfig::getConfig();
    
    // Retorna as configurações em formato JSON
    echo json_encode($config);
} else {
    // Retorna configurações padrão se a tabela não existir
    echo json_encode([
        'typebot_url' => '',
        'icon_position' => 'bottom-right',
        'is_active' => 0, // Desativa o chat se a tabela não existir
        'welcome_message' => 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
    ]);
} 