<?php

/**
 * Função chamada durante a instalação do plugin
 */
function plugin_glpitypebotchat_install() {
    PluginGlpitypebotchatConfig::install();
    PluginGlpitypebotchatMenu::addRightsToSession();
    return true;
}

/**
 * Função chamada durante a desinstalação do plugin
 */
function plugin_glpitypebotchat_uninstall() {
    PluginGlpitypebotchatConfig::uninstall();
    PluginGlpitypebotchatMenu::removeRightsFromSession();
    return true;
}

/**
 * Função chamada durante a purga do plugin
 */
function plugin_glpitypebotchat_purge() {
    PluginGlpitypebotchatConfig::uninstall();
    PluginGlpitypebotchatMenu::removeRightsFromSession();
    return true;
} 