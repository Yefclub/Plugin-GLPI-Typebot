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
 * IMPORTANTE: O nome do plugin deve ser retornado sem tradução
 * @return array
 */
function plugin_version_glpitypebotchat() {
   return [
      'name'           => 'GLPI Typebot Chat', // Nome sem tradução
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
            'min' => '7.4.0',
            'extensions' => [
               'curl',
            ]
         ]
      ]
   ];
}

/**
 * Check pre-requisites before install
 * @return boolean
 */
function plugin_glpitypebotchat_check_prerequisites() {
   // Verifica versão do PHP
   if (version_compare(PHP_VERSION, '7.4.0', 'lt')) {
      echo "Este plugin requer PHP >= 7.4.0";
      return false;
   }

   // Verifica extensão curl
   if (!extension_loaded('curl')) {
      echo "Este plugin requer a extensão PHP curl";
      return false;
   }

   // Verifica versão do GLPI
   if (version_compare(GLPI_VERSION, PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI, 'lt')
      || version_compare(GLPI_VERSION, PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI, 'ge')) {
      echo "Este plugin requer GLPI >= " . PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI . " e < " . PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI;
      return false;
   }
   
   return true;
}

/**
 * Check configuration
 * @return boolean
 */
function plugin_glpitypebotchat_check_config() {
   return true;
}

/**
 * Initialize the plugin
 */
function plugin_init_glpitypebotchat() {
   global $PLUGIN_HOOKS;

   // CSRF compliance
   $PLUGIN_HOOKS['csrf_compliant']['glpitypebotchat'] = true;

   // Registra as classes
   Plugin::registerClass('PluginGlpitypebotchatConfig');
   
   // Menu Configuration
   if (Session::haveRight('config', UPDATE)) {
      $PLUGIN_HOOKS['config_page']['glpitypebotchat'] = 'front/config.form.php';
   }
   
   // Adiciona CSS e JavaScript apenas se o usuário estiver logado
   if (Session::getLoginUserID()) {
      // Hook para adicionar CSS
      $PLUGIN_HOOKS['add_css']['glpitypebotchat'] = [
         'css/glpitypebotchat.css'
      ];
      
      // Hook para adicionar JavaScript
      $PLUGIN_HOOKS['add_javascript']['glpitypebotchat'] = [
         'js/glpitypebotchat.js',
         'js/navbar.js'
      ];
   }
} 