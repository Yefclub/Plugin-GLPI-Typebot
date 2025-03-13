<?php

include ("../../../inc/includes.php");

// Verifica se o usuário tem permissão para acessar a configuração
Session::checkRight("config", UPDATE);

// Se não estiver logado, redireciona para a página de login
if (!Session::getLoginUserID()) {
    Html::redirect($CFG_GLPI['root_doc'] . "/index.php");
    die;
}

// Verifica se o plugin está ativado
$plugin = new Plugin();
if (!$plugin->isActivated('glpitypebotchat')) {
    Html::displayRightError();
    die;
}

if (isset($_POST['update'])) {
    try {
        $config = [
            'typebot_url' => $_POST['typebot_url'],
            'icon_position' => $_POST['icon_position'],
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'welcome_message' => $_POST['welcome_message'] ?? 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
        ];
        
        if (PluginGlpitypebotchatConfig::saveConfig($config)) {
            Session::addMessageAfterRedirect(
                __('Configurações salvas com sucesso!', 'glpitypebotchat'),
                true,
                INFO
            );
        } else {
            Session::addMessageAfterRedirect(
                __('Erro ao salvar configurações.', 'glpitypebotchat'),
                true,
                ERROR
            );
        }
    } catch (Exception $e) {
        Session::addMessageAfterRedirect(
            __('Erro ao salvar configurações:', 'glpitypebotchat') . ' ' . $e->getMessage(),
            true,
            ERROR
        );
    }
    
    Html::redirect(Plugin::getWebDir('glpitypebotchat', true) . '/front/config.form.php');
    die;
}

Html::header('GLPI Typebot Chat', $_SERVER['PHP_SELF'], 'config', 'plugins');

PluginGlpitypebotchatConfig::showConfigForm();

Html::footer(); 