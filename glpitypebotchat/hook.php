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
    $table = 'glpi_plugin_glpitypebotchat_configs';
    
    // Cria a tabela se não existir
    if (!$DB->tableExists($table)) {
        $query = "CREATE TABLE IF NOT EXISTS `$table` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `typebot_url` varchar(255) NOT NULL,
            `icon_position` varchar(20) DEFAULT 'bottom-right',
            `is_active` tinyint(1) DEFAULT 1,
            `welcome_message` text DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $DB->query($query) or die($DB->error());
        
        // Insere configuração padrão
        $DB->insert($table, [
            'typebot_url' => '',
            'icon_position' => 'bottom-right',
            'is_active' => 0, // Desativa por padrão até que seja configurado
            'welcome_message' => 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
        ]);
    } else {
        // Verifica se a coluna welcome_message existe
        if (!$DB->fieldExists($table, 'welcome_message')) {
            $query = "ALTER TABLE `$table` ADD COLUMN `welcome_message` text DEFAULT NULL";
            $DB->query($query) or die($DB->error());
            
            // Atualiza valores existentes
            $DB->update($table, [
                'welcome_message' => 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
            ], ['id' => 1]);
        }
    }
    
    // Registra o plugin no GLPI
    CronTask::Register('PluginGlpitypebotchat', 'Sample', DAY_TIMESTAMP);
    
    $migration->executeMigration();
    
    return true;
}

/**
 * Função chamada durante a desinstalação do plugin
 *
 * @return boolean
 */
function plugin_glpitypebotchat_uninstall() {
    global $DB;
    
    $tables = [
        'glpi_plugin_glpitypebotchat_configs'
    ];
    
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