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
   if (version_compare(PHP_VERSION, '7.4.0', 'lt')) {
      echo "Este plugin requer PHP >= 7.4.0";
      return false;
   }

   if (!extension_loaded('curl')) {
      echo "Este plugin requer a extensão PHP curl";
      return false;
   }

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
   global $PLUGIN_HOOKS, $CFG_GLPI, $DB;

   // CSRF compliance
   $PLUGIN_HOOKS['csrf_compliant']['glpitypebotchat'] = true;

   // Registra as classes apenas se o usuário estiver autenticado
   if (isset($_SESSION['glpiID']) && $_SESSION['glpiID'] > 0) {
      // Registra as classes
      Plugin::registerClass('PluginGlpitypebotchatConfig');
      
      // Menu Configuration - apenas adicionar se o usuário tiver permissão
      if (Session::haveRight('config', UPDATE)) {
         $PLUGIN_HOOKS['config_page']['glpitypebotchat'] = 'front/config.form.php';
      }
      
      // Verifica se a tabela de configuração existe antes de carregar os recursos
      if ($DB->tableExists('glpi_plugin_glpitypebotchat_configs')) {
         // Hook para adicionar CSS - sem modificar qualquer comportamento global
         $PLUGIN_HOOKS['add_css']['glpitypebotchat'][] = 'css/glpitypebotchat.css';
         
         // Hook para adicionar JavaScript - sem modificar qualquer comportamento global
         $PLUGIN_HOOKS['add_javascript']['glpitypebotchat'][] = 'js/glpitypebotchat.js';
         
         // Adiciona o JavaScript da barra de navegação apenas em páginas específicas
         if (!isset($_REQUEST['ajax'])) {
            $PLUGIN_HOOKS['javascript']['glpitypebotchat'][] = [
               'path' => 'js/navbar.js',
               'options' => ['defer' => true]
            ];
         }
         
         // Adiciona o hook para o header de forma simplificada
         $PLUGIN_HOOKS['add_head']['glpitypebotchat'] = 'plugin_glpitypebotchat_add_head';
      }
   }
} 