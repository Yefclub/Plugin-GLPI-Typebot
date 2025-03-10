<?php

include ("../../../inc/includes.php");

// Permite acesso de qualquer origem para este endpoint
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Obtém as configurações do plugin
$config = PluginGlpitypebotchatConfig::getConfig();

// Retorna as configurações em formato JSON
echo json_encode($config); 