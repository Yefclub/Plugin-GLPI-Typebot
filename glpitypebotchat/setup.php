<?php

use Glpi\Plugin\Hooks;

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

// Definições do plugin
define('PLUGIN_GLPITYPEBOTCHAT_VERSION', '1.0.0');
define('PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI', '10.0.0');
define('PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI', '11.0.0');

// Constantes de localização
define('PLUGIN_GLPITYPEBOTCHAT_DIR', __DIR__);
define('PLUGIN_GLPITYPEBOTCHAT_WEB_DIR', Plugin::getWebDir('glpitypebotchat'));

/**
 * Get the name and the version of the plugin
 * 
 * @return array
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
            'dev' => false,
            'plugins' => []
         ],
         'php' => [
            'min' => '7.4.0',
            'max' => '8.4.0',
            'params' => [
               'curl' => [
                  'required' => true
               ]
            ]
         ]
      ]
   ];
}

/**
 * Check pre-requisites before install
 * 
 * @return boolean
 */
function plugin_glpitypebotchat_check_prerequisites() {
   if (version_compare(PHP_VERSION, '7.4.0', 'lt')) {
      echo "Este plugin requer PHP >= 7.4.0";
      return false;
   }

   if (!extension_loaded('curl')) {
      echo "Este plugin requer a extensão PHP 'curl'";
      return false;
   }

   if (version_compare(GLPI_VERSION, PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI, 'lt')
      || version_compare(GLPI_VERSION, PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI, 'ge')) {
      echo Plugin::messageIncompatible('core', PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI, PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI);
      return false;
   }
   
   return true;
}

/**
 * Check configuration
 * 
 * @param boolean $verbose Exibir mensagens detalhadas
 * @return boolean
 */
function plugin_glpitypebotchat_check_config($verbose = false) {
   if (true) {
      return true;
   }
   
   if ($verbose) {
      echo __('Plugin instalado mas não configurado', 'glpitypebotchat');
   }
   return false;
}

/**
 * Init the hooks of the plugins -Needed
 */
function plugin_init_glpitypebotchat() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS[Hooks::CSRF_COMPLIANT]['glpitypebotchat'] = true;

   if (Session::getLoginUserID()) {
      // Registra as classes
      Plugin::registerClass('PluginGlpitypebotchatConfig', [
         'addtabon' => ['Config']
      ]);

      if (Session::haveRight('config', UPDATE)) {
         // Adiciona o item no menu de configuração
         $PLUGIN_HOOKS['config_page']['glpitypebotchat'] = 'front/config.form.php';
         
         // Hook para adicionar o menu
         $PLUGIN_HOOKS['menu_toadd']['glpitypebotchat'] = [
            'admin' => 'PluginGlpitypebotchatMenu'
         ];
      }

      // Hook para adicionar CSS e JavaScript
      $PLUGIN_HOOKS['add_css']['glpitypebotchat'] = 'css/glpitypebotchat.css';
      $PLUGIN_HOOKS['add_javascript']['glpitypebotchat'] = [
         'js/glpitypebotchat.js',
         'js/navbar.js'
      ];
   }
} 