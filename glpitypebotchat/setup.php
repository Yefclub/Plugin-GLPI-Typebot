<?php

use Glpi\Plugin\Hooks;

define('PLUGIN_GLPITYPEBOTCHAT_VERSION', '1.0.0');

// Minimal GLPI version, inclusive
define('PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI', '10.0.0');
// Maximum GLPI version, exclusive
define('PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI', '11.0.0');

// Constantes de localização
define('PLUGIN_GLPITYPEBOTCHAT_DIR', __DIR__);
define('PLUGIN_GLPITYPEBOTCHAT_WEB_DIR', Plugin::getWebDir('glpitypebotchat'));

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

/**
 * Init the hooks of the plugins -Needed
 */
function plugin_init_glpitypebotchat() {
   global $PLUGIN_HOOKS, $CFG_GLPI;

   $PLUGIN_HOOKS[Hooks::CSRF_COMPLIANT]['glpitypebotchat'] = true;
   
   // Hook para adicionar CSS e JavaScript em todas as páginas
   $PLUGIN_HOOKS['add_css']['glpitypebotchat'] = [
      PLUGIN_GLPITYPEBOTCHAT_WEB_DIR . '/css/glpitypebotchat.css'
   ];
   
   $PLUGIN_HOOKS['add_javascript']['glpitypebotchat'] = [
      PLUGIN_GLPITYPEBOTCHAT_WEB_DIR . '/js/glpitypebotchat.js'
   ];
   
   if (Session::getLoginUserID()) {
      // Adiciona o botão na barra de navegação principal
      $PLUGIN_HOOKS['add_javascript']['glpitypebotchat'][] = 
         PLUGIN_GLPITYPEBOTCHAT_WEB_DIR . '/js/navbar.js';
      
      if (Session::haveRight('config', UPDATE)) {
         // Registra as classes
         Plugin::registerClass('PluginGlpitypebotchatConfig', [
            'addtabon' => ['Config']
         ]);
         
         // Adiciona o item no menu de configuração
         $PLUGIN_HOOKS['menu_entry']['glpitypebotchat'] = true;
         $PLUGIN_HOOKS['config_page']['glpitypebotchat'] = 'front/config.form.php';
         
         // Hook para adicionar o menu
         $PLUGIN_HOOKS['menu_toadd']['glpitypebotchat'] = [
            'admin' => 'PluginGlpitypebotchatMenu'
         ];
      }
   }
}

/**
 * Get the name and the version of the plugin
 * 
 * @return array
 */
function plugin_version_glpitypebotchat() {
   return [
      'name'           => __('GLPI Typebot Chat', 'glpitypebotchat'),
      'version'        => PLUGIN_GLPITYPEBOTCHAT_VERSION,
      'author'         => 'Taskivus',
      'license'        => 'GPLv3+',
      'homepage'       => 'https://taskivus.com',
      'requirements'   => [
         'glpi' => [
            'min' => PLUGIN_GLPITYPEBOTCHAT_MIN_GLPI,
            'max' => PLUGIN_GLPITYPEBOTCHAT_MAX_GLPI,
            'dev' => false, // não é um plugin de desenvolvimento
            'plugins' => [] // não depende de outros plugins
         ],
         'php' => [
            'min' => '7.4.0',
            'max' => '8.4.0', // Atualizado para incluir PHP 8.3
            'params' => [ // extensões PHP necessárias
               'curl' => [
                  'required' => true
               ]
            ]
         ]
      ],
      'picto' => 'fas fa-comments'
   ];
}

/**
 * Check pre-requisites before install
 * 
 * @return boolean
 */
function plugin_glpitypebotchat_check_prerequisites() {
   // Verifica versão do PHP
   if (version_compare(PHP_VERSION, '7.4.0', 'lt')) {
      echo "Este plugin requer PHP >= 7.4.0";
      return false;
   }

   // Remove a verificação de versão máxima do PHP para permitir versões mais recentes
   
   // Verifica extensões do PHP
   if (!extension_loaded('curl')) {
      echo "Este plugin requer a extensão PHP 'curl'";
      return false;
   }

   // Verifica versão do GLPI
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
   if (true) { // Verifica se a configuração está OK
      return true;
   }
   
   if ($verbose) {
      echo __('Plugin instalado mas não configurado', 'glpitypebotchat');
   }
   return false;
} 