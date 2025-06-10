<?php

define('PLUGIN_AIOA_VERSION', '1.0.0');

function plugin_init_allinoneaccessibility()
{
   global $PLUGIN_HOOKS, $CFG_GLPI;

   $PLUGIN_HOOKS['csrf_compliant']['allinoneaccessibility'] = true;

   $plugin = new Plugin();
   if ($plugin->isInstalled('allinoneaccessibility') && $plugin->isActivated('allinoneaccessibility')) {

      // SkynetWidget::fetchWidgetSettings();
      $PLUGIN_HOOKS['add_javascript']['allinoneaccessibility'][] = "js/aioa.js";

      if (Session::haveRight('reminder_public', READ)) {
         $PLUGIN_HOOKS['config_page']['allinoneaccessibility'] = 'front\src\AllInOneAccessibility.php';
      }
   }
}

function plugin_version_allinoneaccessibility()
{
   return [
      'name'         => __('All in One Accessibility', 'allinoneaccessibility'),
      'version'      => PLUGIN_AIOA_VERSION,
      'author'       => 'SKYNET TECHNOLOGIES USA LLC.',
      'license'      => ''
   ];
}
