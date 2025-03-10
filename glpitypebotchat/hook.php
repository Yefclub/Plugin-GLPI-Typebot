<?php

include ("../../../inc/includes.php");

/**
 * Função chamada durante a instalação do plugin
 */
function plugin_glpitypebotchat_install() {
    if (!class_exists('PluginGlpitypebotchatConfig')) {
        require_once(GLPI_ROOT . '/plugins/glpitypebotchat/inc/config.class.php');
    }
    PluginGlpitypebotchatConfig::install();
    PluginGlpitypebotchatMenu::addRightsToSession();
    return true;
}

/**
 * Função chamada durante a desinstalação do plugin
 */
function plugin_glpitypebotchat_uninstall() {
    if (!class_exists('PluginGlpitypebotchatConfig')) {
        require_once(GLPI_ROOT . '/plugins/glpitypebotchat/inc/config.class.php');
    }
    PluginGlpitypebotchatConfig::uninstall();
    PluginGlpitypebotchatMenu::removeRightsFromSession();
    return true;
}

/**
 * Função chamada durante a purga do plugin
 */
function plugin_glpitypebotchat_purge() {
    if (!class_exists('PluginGlpitypebotchatConfig')) {
        require_once(GLPI_ROOT . '/plugins/glpitypebotchat/inc/config.class.php');
    }
    PluginGlpitypebotchatConfig::uninstall();
    PluginGlpitypebotchatMenu::removeRightsFromSession();
    return true;
} 