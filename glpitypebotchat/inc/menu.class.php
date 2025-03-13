<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

class PluginGlpitypebotchatMenu extends CommonGLPI {
   static $rightname = 'config';

   static function getMenuName() {
      return __('Typebot Chat', 'glpitypebotchat');
   }

   static function getMenuContent() {
      global $CFG_GLPI;
      
      $menu = [];
      if (Session::haveRight('config', UPDATE)) {
         $menu['title'] = self::getMenuName();
         $menu['page']  = '/plugins/glpitypebotchat/front/config.form.php';
         $menu['icon']  = 'fas fa-comments';
         
         $menu['options']['config']['title'] = __('Configurações', 'glpitypebotchat');
         $menu['options']['config']['page']  = '/plugins/glpitypebotchat/front/config.form.php';
         $menu['options']['config']['icon']  = 'fas fa-cog';
      }
      return $menu;
   }

   static function removeRightsFromSession() {
      if (isset($_SESSION['glpimenu']['admin']['types']['PluginGlpitypebotchatMenu'])) {
         unset($_SESSION['glpimenu']['admin']['types']['PluginGlpitypebotchatMenu']);
      }
   }
   
   static function addRightsToSession() {
      if (Session::haveRight('config', UPDATE)) {
         $_SESSION['glpimenu']['admin']['types']['PluginGlpitypebotchatMenu'] = 'PluginGlpitypebotchatMenu';
      }
   }
} 