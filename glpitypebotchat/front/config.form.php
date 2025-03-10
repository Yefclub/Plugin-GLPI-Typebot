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
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
        
        PluginGlpitypebotchatConfig::saveConfig($config);
        Session::addMessageAfterRedirect(__('Configurações salvas com sucesso!', 'glpitypebotchat'), true);
        Html::back();
    }
    
    $config = PluginGlpitypebotchatConfig::getConfig();
    
    echo "<form name='form' action='" . $_SERVER['PHP_SELF'] . "' method='post'>";
    echo "<div class='center' id='tabsbody'>";
    echo "<table class='tab_cadre_fixe'>";
    
    echo "<tr><th colspan='2'>" . __('Configurações do Typebot Chat', 'glpitypebotchat') . "</th></tr>";
    
    echo "<tr class='tab_bg_1'>";
    echo "<td>" . __('URL do Typebot', 'glpitypebotchat') . "</td>";
    echo "<td><input type='text' name='typebot_url' value='" . $config['typebot_url'] . "' size='50'></td>";
    echo "</tr>";
    
    echo "<tr class='tab_bg_1'>";
    echo "<td>" . __('Posição do Ícone', 'glpitypebotchat') . "</td>";
    echo "<td>";
    echo "<select name='icon_position'>";
    $positions = ['bottom-right' => __('Inferior Direito', 'glpitypebotchat'),
                 'bottom-left' => __('Inferior Esquerdo', 'glpitypebotchat')];
    foreach ($positions as $key => $val) {
        echo "<option value='$key' " . ($config['icon_position'] == $key ? 'selected' : '') . ">$val</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr class='tab_bg_1'>";
    echo "<td>" . __('Ativar Chat', 'glpitypebotchat') . "</td>";
    echo "<td>";
    echo "<input type='checkbox' name='is_active' " . ($config['is_active'] ? 'checked' : '') . ">";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr class='tab_bg_1'>";
    echo "<td colspan='2' class='center'>";
    echo "<input type='submit' name='update' class='submit' value='" . __('Salvar', 'glpitypebotchat') . "'>";
    echo "</td>";
    echo "</tr>";
    
    echo "</table>";
    echo "</div>";
    Html::closeForm();
} else {
    echo "<div class='center'><br>";
    echo "<img src='" . $CFG_GLPI["root_doc"] . "/pics/warning.png' alt='warning'><br><br>";
    echo "<b>" . __('Plugin não está instalado ou ativado.', 'glpitypebotchat') . "</b></div>";
}

Html::footer(); 