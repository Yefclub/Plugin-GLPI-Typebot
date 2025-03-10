<?php

/**
 * Função chamada durante a instalação do plugin
 */
function plugin_glpitypebotchat_install() {
    PluginGlpitypebotchatConfig::install();
    return true;
}

/**
 * Função chamada durante a desinstalação do plugin
 */
function plugin_glpitypebotchat_uninstall() {
    PluginGlpitypebotchatConfig::uninstall();
    return true;
}

/**
 * Função chamada durante a purga do plugin
 */
function plugin_glpitypebotchat_purge() {
    PluginGlpitypebotchatConfig::uninstall();
    return true;
} 