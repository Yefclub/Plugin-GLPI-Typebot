<?php

// Inclui o arquivo principal do GLPI para acesso às funções
include ("../../../inc/includes.php");

// Verifica se o usuário está autenticado de forma simplificada
if (!isset($_SESSION['glpiID']) || $_SESSION['glpiID'] <= 0) {
    http_response_code(403); // Acesso proibido
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Você precisa estar autenticado para acessar esta função',
        'is_active' => 0
    ]);
    exit;
}

// Configurações de cabeçalho
header('Content-Type: application/json');

// Não usa a variável global $DB diretamente para evitar conflitos
$db = new DB();

try {
    // Verifica se a tabela existe antes de tentar obter as configurações
    if ($db->tableExists('glpi_plugin_glpitypebotchat_configs')) {
        // Tenta obter as configurações do plugin
        $query = "SELECT * FROM glpi_plugin_glpitypebotchat_configs WHERE id = 1 LIMIT 1";
        $result = $db->query($query);
        
        if ($result && $db->numrows($result) > 0) {
            $config = $db->fetch_assoc($result);
            echo json_encode([
                'typebot_url' => $config['typebot_url'] ?? '',
                'icon_position' => $config['icon_position'] ?? 'bottom-right',
                'is_active' => intval($config['is_active'] ?? 0),
                'welcome_message' => $config['welcome_message'] ?? 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
            ]);
        } else {
            echo json_encode([
                'typebot_url' => '',
                'icon_position' => 'bottom-right',
                'is_active' => 0,
                'welcome_message' => 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
            ]);
        }
    } else {
        // Retorna configurações padrão se a tabela não existir
        echo json_encode([
            'typebot_url' => '',
            'icon_position' => 'bottom-right',
            'is_active' => 0,
            'welcome_message' => 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
        ]);
    }
} catch (Exception $e) {
    error_log('Erro ao obter configurações do plugin glpitypebotchat: ' . $e->getMessage());
    echo json_encode([
        'error' => 'Erro ao obter configurações',
        'is_active' => 0
    ]);
} 