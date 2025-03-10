<?php

class PluginGlpitypebotchatMenu extends CommonGLPI {
   static $rightname = 'config';

   static function getMenuName() {
      return __('Typebot Chat', 'glpitypebotchat');
   }

   static function getMenuContent() {
      $menu = [];
      if (Session::haveRight(static::$rightname, READ)) {
         $menu['title'] = self::getMenuName();
         $menu['page']  = '/plugins/glpitypebotchat/front/config.form.php';
         $menu['icon']  = 'fas fa-comments';
      }
      return $menu;
   }

   static function removeRightsFromSession() {
      if (isset($_SESSION['glpimenu']['config']['types']['PluginGlpitypebotchatMenu'])) {
         unset($_SESSION['glpimenu']['config']['types']['PluginGlpitypebotchatMenu']);
      }
   }
   
   static function addRightsToSession() {
      if (Session::haveRight(static::$rightname, READ)) {
         $_SESSION['glpimenu']['config']['types']['PluginGlpitypebotchatMenu'] = 'PluginGlpitypebotchatMenu';
      }
   }
} 