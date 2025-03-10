<?php

if (!defined('GLPI_ROOT')) {
   include ("../../../inc/includes.php");
}

if (!class_exists('PluginGlpitypebotchatConfig')) {
    require_once(GLPI_ROOT . '/plugins/glpitypebotchat/inc/config.class.php');
}

if (!class_exists('PluginGlpitypebotchatMenu')) {
    require_once(GLPI_ROOT . '/plugins/glpitypebotchat/inc/menu.class.php');
}

/**
 * Função chamada durante a instalação do plugin
 *
 * @return boolean
 */
function plugin_glpitypebotchat_install() {
    PluginGlpitypebotchatConfig::install();
    PluginGlpitypebotchatMenu::addRightsToSession();
    return true;
}

/**
 * Função chamada durante a desinstalação do plugin
 *
 * @return boolean
 */
function plugin_glpitypebotchat_uninstall() {
    PluginGlpitypebotchatConfig::uninstall();
    PluginGlpitypebotchatMenu::removeRightsFromSession();
    return true;
}

/**
 * Função chamada durante a purga do plugin
 *
 * @return boolean
 */
function plugin_glpitypebotchat_purge() {
    PluginGlpitypebotchatConfig::uninstall();
    PluginGlpitypebotchatMenu::removeRightsFromSession();
    return true;
} 