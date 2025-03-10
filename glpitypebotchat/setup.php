<?php

define('PLUGIN_GLPITYPEBOTCHAT_VERSION', '1.0.0');

// Minimal GLPI version, inclusive
define('PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI', '10.0.0');
// Maximum GLPI version, exclusive
define('PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI', '11.0.0');

/**
 * Init the hooks of the plugins -Needed
 */
function plugin_init_glpitypebotchat() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['glpitypebotchat'] = true;
   
   if (Session::getLoginUserID()) {
      // Adiciona CSS e JavaScript
      $PLUGIN_HOOKS['add_css']['glpitypebotchat'] = 'css/glpitypebotchat.css';
      $PLUGIN_HOOKS['add_javascript']['glpitypebotchat'] = [
         'js/glpitypebotchat.js'
      ];
      
      // Adiciona o menu na barra lateral
      Plugin::registerClass('PluginGlpitypebotchatMenu');
      Plugin::registerClass('PluginGlpitypebotchatConfig', ['addtabon' => ['Config']]);
      
      $PLUGIN_HOOKS['menu_toadd']['glpitypebotchat'] = [
         'config' => 'PluginGlpitypebotchatMenu'
      ];
      
      // Adiciona a página de configuração
      $PLUGIN_HOOKS['config_page']['glpitypebotchat'] = 'front/config.form.php';
   }
}

/**
 * Get the name and the version of the plugin
 */
function plugin_version_glpitypebotchat() {
   return [
      'name'           => 'GLPI Typebot Chat',
      'version'        => PLUGIN_GLPITYPEBOTCHAT_VERSION,
      'author'         => 'Taskivus',
      'license'        => 'GPLv3+',
      'homepage'       => 'https://taskivus.com',
      'requirements'   => [
         'glpi' => [
            'min' => PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI,
            'max' => PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI,
         ],
         'php' => [
            'min' => '7.4.0'
         ]
      ]
   ];
}

/**
 * Check pre-requisites before install
 */
function plugin_glpitypebotchat_check_prerequisites() {
   if (version_compare(GLPI_VERSION, PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI, 'lt')
      || version_compare(GLPI_VERSION, PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI, 'ge')) {
      echo "Este plugin requer GLPI >= " . PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI . " e < " . PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI;
      return false;
   }
   
   if (version_compare(PHP_VERSION, '7.4.0', 'lt')) {
      echo "Este plugin requer PHP >= 7.4.0";
      return false;
   }
   
   return true;
}

/**
 * Check configuration
 */
function plugin_glpitypebotchat_check_config($verbose = false) {
   return true;
} 