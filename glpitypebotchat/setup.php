<?php

define('PLUGIN_GLPITYPEBOTCHAT_VERSION', '1.0.0');

/**
 * Init the hooks of the plugins -Needed
 */
function plugin_init_glpitypebotchat() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['glpitypebotchat'] = true;
   
   // Adiciona o hook para incluir o chat na interface
   if (Session::getLoginUserID()) {
      $PLUGIN_HOOKS['add_javascript']['glpitypebotchat'] = 'js/glpitypebotchat.js';
      $PLUGIN_HOOKS['add_css']['glpitypebotchat'] = 'css/glpitypebotchat.css';
      $PLUGIN_HOOKS['display_central']['glpitypebotchat'] = 'plugin_glpitypebotchat_display_central';
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
      'author'         => 'Seu Nome',
      'license'        => 'GPLv3+',
      'homepage'       => '',
      'requirements'   => [
         'glpi' => [
            'min' => '10.0.0',
            'max' => '11.0.0',
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
   // Verifica versão do GLPI
   if (version_compare(GLPI_VERSION, '10.0.0', 'lt')) {
      echo "Este plugin requer GLPI >= 10.0.0";
      return false;
   }
   
   // Verifica versão do PHP
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
   if (true) {
      return true;
   }
   return false;
} 