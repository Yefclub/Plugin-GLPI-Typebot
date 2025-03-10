<?php

use Glpi\Plugin\Hooks;

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

include (GLPI_ROOT . "/inc/includes.php");

// Carrega as classes necessárias
foreach (glob(PLUGIN_GLPITYPEBOTCHAT_DIR . '/inc/*.class.php') as $file) {
    require_once($file);
}

/**
 * Função chamada durante a instalação do plugin
 *
 * @return boolean
 */
function plugin_glpitypebotchat_install() {
    global $DB;

    $migration = new Migration(PLUGIN_GLPITYPEBOTCHAT_VERSION);
    
    // Verifica se as tabelas existem
    if (!$DB->tableExists('glpi_plugin_glpitypebotchat_configs')) {
        try {
            $query = "CREATE TABLE IF NOT EXISTS `glpi_plugin_glpitypebotchat_configs` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `typebot_url` varchar(255) NOT NULL,
                `icon_position` varchar(20) DEFAULT 'bottom-right',
                `is_active` tinyint(1) DEFAULT 1,
                `welcome_message` text DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $DB->query($query) or die($DB->error());
            
            // Insere configuração padrão
            $DB->insert('glpi_plugin_glpitypebotchat_configs', [
                'typebot_url' => '',
                'icon_position' => 'bottom-right',
                'is_active' => 1,
                'welcome_message' => 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
            ]);
        } catch (Exception $e) {
            return false;
        }
    }
    return true;
}

/**
 * Função chamada durante a desinstalação do plugin
 *
 * @return boolean
 */
function plugin_glpitypebotchat_uninstall() {
    global $DB;
    
    $tables = ['glpi_plugin_glpitypebotchat_configs'];
    
    foreach ($tables as $table) {
        $DB->query("DROP TABLE IF EXISTS `$table`") or die($DB->error());
    }
    
    return true;
}

/**
 * Função chamada durante a purga do plugin
 *
 * @return boolean
 */
function plugin_glpitypebotchat_purge() {
    return plugin_glpitypebotchat_uninstall();
} 