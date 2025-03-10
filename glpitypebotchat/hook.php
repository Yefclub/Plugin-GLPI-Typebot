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
            PluginGlpitypebotchatConfig::install($migration);
            PluginGlpitypebotchatMenu::addRightsToSession();
            $migration->executeMigration();
            return true;
        } catch (Exception $e) {
            Toolbox::logError('Erro ao instalar o plugin:', $e->getMessage());
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
    
    try {
        PluginGlpitypebotchatConfig::uninstall();
        PluginGlpitypebotchatMenu::removeRightsFromSession();
        
        // Remove as tabelas do plugin
        $tables = ['glpi_plugin_glpitypebotchat_configs'];
        foreach ($tables as $table) {
            $DB->query("DROP TABLE IF EXISTS `$table`");
        }
        
        return true;
    } catch (Exception $e) {
        Toolbox::logError('Erro ao desinstalar o plugin:', $e->getMessage());
        return false;
    }
}

/**
 * Função chamada durante a purga do plugin
 *
 * @return boolean
 */
function plugin_glpitypebotchat_purge() {
    return plugin_glpitypebotchat_uninstall();
} 