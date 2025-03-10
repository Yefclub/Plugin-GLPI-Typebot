<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

class PluginGlpitypebotchatConfig extends CommonDBTM {
    static private $_instance = null;
    static $rightname = 'config';

    /**
     * Obtém a instância única da configuração
     */
    static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Instala ou atualiza o plugin
     */
    static function install() {
        global $DB;

        $table = 'glpi_plugin_glpitypebotchat_configs';
        
        if (!$DB->tableExists($table)) {
            $query = "CREATE TABLE IF NOT EXISTS `$table` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `typebot_url` varchar(255) NOT NULL,
                `icon_position` varchar(20) DEFAULT 'bottom-right',
                `is_active` tinyint(1) DEFAULT 1,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $DB->query($query) or die($DB->error());
            
            // Insere configuração padrão
            $DB->insert($table, [
                'typebot_url' => '',
                'icon_position' => 'bottom-right',
                'is_active' => 1
            ]);
        }
        return true;
    }

    /**
     * Remove o plugin
     */
    static function uninstall() {
        global $DB;
        $DB->query("DROP TABLE IF EXISTS `glpi_plugin_glpitypebotchat_configs`");
        return true;
    }

    /**
     * Obtém as configurações atuais
     */
    static function getConfig() {
        global $DB;
        
        $config = new self();
        $config->getFromDB(1);
        
        return [
            'typebot_url' => $config->fields['typebot_url'] ?? '',
            'icon_position' => $config->fields['icon_position'] ?? 'bottom-right',
            'is_active' => $config->fields['is_active'] ?? 1
        ];
    }

    /**
     * Salva as configurações
     */
    static function saveConfig($values) {
        $config = new self();
        $values['id'] = 1;
        
        if ($config->getFromDB(1)) {
            return $config->update($values);
        }
        
        return $config->add($values);
    }

    static function getTypeName($nb = 0) {
        return __('Typebot Chat', 'glpitypebotchat');
    }

    function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {
        if ($item->getType() == 'Config') {
            return self::getTypeName();
        }
        return '';
    }

    static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0) {
        if ($item->getType() == 'Config') {
            self::showConfigForm();
        }
        return true;
    }

    static function showConfigForm() {
        $config = self::getConfig();
        
        echo "<form name='form' action='../plugins/glpitypebotchat/front/config.form.php' method='post'>";
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
    }
} 