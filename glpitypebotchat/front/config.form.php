<?php

include ("../../../inc/includes.php");

Session::checkRight("config", UPDATE);

Html::header('GLPI Typebot Chat', $_SERVER['PHP_SELF'], 'config', 'plugins');

$plugin = new Plugin();

if ($plugin->isActivated('glpitypebotchat')) {
    if (isset($_POST['update'])) {
        $config = [
            'typebot_url' => $_POST['typebot_url'],
            'icon_position' => $_POST['icon_position'],
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'welcome_message' => $_POST['welcome_message'] ?? 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
        ];
        
        PluginGlpitypebotchatConfig::saveConfig($config);
        Session::addMessageAfterRedirect(__('Configurações salvas com sucesso!', 'glpitypebotchat'), true, INFO);
        Html::back();
    }
    
    PluginGlpitypebotchatConfig::showConfigForm();
} else {
    echo "<div class='alert alert-warning'>";
    echo "<i class='fas fa-exclamation-triangle'></i> ";
    echo "<b>" . __('Plugin não está instalado ou ativado.', 'glpitypebotchat') . "</b>";
    echo "</div>";
}

Html::footer(); 