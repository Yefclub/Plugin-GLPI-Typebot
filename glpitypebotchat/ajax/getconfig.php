<?php

include ("../../../inc/includes.php");
header('Content-Type: application/json');

$config = PluginGlpitypebotchatConfig::getConfig();
echo json_encode($config); 