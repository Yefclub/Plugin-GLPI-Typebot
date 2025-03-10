<?php

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
} 