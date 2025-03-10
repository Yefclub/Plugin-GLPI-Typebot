<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

class PluginGlpitypebotchatConfig extends CommonDBTM {
    static private $_instance = null;
    static $rightname = 'config';

    /**
     * Obtém a instância única da configuração
     */
    static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Instala ou atualiza o plugin
     */
    static function install() {
        global $DB;

        $table = 'glpi_plugin_glpitypebotchat_configs';
        
        if (!$DB->tableExists($table)) {
            $query = "CREATE TABLE IF NOT EXISTS `$table` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `typebot_url` varchar(255) NOT NULL,
                `icon_position` varchar(20) DEFAULT 'bottom-right',
                `is_active` tinyint(1) DEFAULT 1,
                `welcome_message` text DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $DB->query($query) or die($DB->error());
            
            // Insere configuração padrão
            $DB->insert($table, [
                'typebot_url' => '',
                'icon_position' => 'bottom-right',
                'is_active' => 1,
                'welcome_message' => 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
            ]);
        } else {
            // Verifica se a coluna welcome_message existe
            if (!$DB->fieldExists($table, 'welcome_message')) {
                $query = "ALTER TABLE `$table` ADD COLUMN `welcome_message` text DEFAULT NULL";
                $DB->query($query) or die($DB->error());
                
                // Atualiza valores existentes
                $DB->update($table, [
                    'welcome_message' => 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
                ], ['id' => 1]);
            }
        }
        return true;
    }

    /**
     * Remove o plugin
     */
    static function uninstall() {
        global $DB;
        $DB->query("DROP TABLE IF EXISTS `glpi_plugin_glpitypebotchat_configs`");
        return true;
    }

    /**
     * Obtém as configurações atuais
     */
    static function getConfig() {
        global $DB;
        
        $config = new self();
        $config->getFromDB(1);
        
        return [
            'typebot_url' => $config->fields['typebot_url'] ?? '',
            'icon_position' => $config->fields['icon_position'] ?? 'bottom-right',
            'is_active' => $config->fields['is_active'] ?? 1,
            'welcome_message' => $config->fields['welcome_message'] ?? 'Bem-vindo ao Chat do GLPI! Como posso ajudar?'
        ];
    }

    /**
     * Salva as configurações
     */
    static function saveConfig($values) {
        $config = new self();
        $values['id'] = 1;
        
        if ($config->getFromDB(1)) {
            return $config->update($values);
        }
        
        return $config->add($values);
    }

    static function getTypeName($nb = 0) {
        return __('Typebot Chat', 'glpitypebotchat');
    }

    function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {
        if ($item->getType() == 'Config') {
            return self::getTypeName();
        }
        return '';
    }

    static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0) {
        if ($item->getType() == 'Config') {
            self::showConfigForm();
        }
        return true;
    }

    static function showConfigForm() {
        $config = self::getConfig();
        
        echo "<div class='card'>";
        echo "<div class='card-header'>";
        echo "<h3>" . __('Configurações do Typebot Chat', 'glpitypebotchat') . "</h3>";
        echo "</div>";
        echo "<div class='card-body'>";
        
        // Mensagem de boas-vindas
        echo "<div class='alert alert-info mb-4'>";
        echo "<h4><i class='fas fa-info-circle'></i> " . __('Bem-vindo ao Plugin Typebot Chat!', 'glpitypebotchat') . "</h4>";
        echo "<p>" . __('Este plugin integra o Typebot com o GLPI, permitindo adicionar um chat interativo na interface.', 'glpitypebotchat') . "</p>";
        echo "<p>" . __('Após a configuração, o ícone do chat aparecerá em todas as páginas do GLPI, e também será adicionado um botão na barra de navegação.', 'glpitypebotchat') . "</p>";
        echo "</div>";
        
        // Formulário de configuração
        echo "<form name='form' action='../plugins/glpitypebotchat/front/config.form.php' method='post' class='mb-4'>";
        echo "<div class='card border-secondary mb-4'>";
        echo "<div class='card-header bg-secondary text-white'>";
        echo "<h4 class='m-0'>" . __('Configurações Básicas', 'glpitypebotchat') . "</h4>";
        echo "</div>";
        echo "<div class='card-body'>";
        
        // URL do Typebot
        echo "<div class='mb-3 row'>";
        echo "<label for='typebot_url' class='col-sm-3 col-form-label'>" . __('URL do Typebot', 'glpitypebotchat') . "</label>";
        echo "<div class='col-sm-9'>";
        echo "<input type='text' class='form-control' id='typebot_url' name='typebot_url' value='" . $config['typebot_url'] . "' required>";
        echo "<small class='form-text text-muted'>" . __('URL completa do seu bot do Typebot (ex: https://bot.typebot.io/meu-bot)', 'glpitypebotchat') . "</small>";
        echo "</div>";
        echo "</div>";
        
        // Posição do Ícone
        echo "<div class='mb-3 row'>";
        echo "<label for='icon_position' class='col-sm-3 col-form-label'>" . __('Posição do Ícone', 'glpitypebotchat') . "</label>";
        echo "<div class='col-sm-9'>";
        echo "<select class='form-select' id='icon_position' name='icon_position'>";
        $positions = [
            'bottom-right' => __('Inferior Direito', 'glpitypebotchat'),
            'bottom-left' => __('Inferior Esquerdo', 'glpitypebotchat')
        ];
        foreach ($positions as $key => $val) {
            echo "<option value='$key' " . ($config['icon_position'] == $key ? 'selected' : '') . ">$val</option>";
        }
        echo "</select>";
        echo "</div>";
        echo "</div>";
        
        // Mensagem de boas-vindas
        echo "<div class='mb-3 row'>";
        echo "<label for='welcome_message' class='col-sm-3 col-form-label'>" . __('Mensagem de Boas-vindas', 'glpitypebotchat') . "</label>";
        echo "<div class='col-sm-9'>";
        echo "<textarea class='form-control' id='welcome_message' name='welcome_message' rows='3'>" . $config['welcome_message'] . "</textarea>";
        echo "<small class='form-text text-muted'>" . __('Esta mensagem será exibida quando o usuário abrir o chat pela primeira vez.', 'glpitypebotchat') . "</small>";
        echo "</div>";
        echo "</div>";
        
        // Ativar Chat
        echo "<div class='mb-3 row'>";
        echo "<label for='is_active' class='col-sm-3 col-form-label'>" . __('Ativar Chat', 'glpitypebotchat') . "</label>";
        echo "<div class='col-sm-9 d-flex align-items-center'>";
        echo "<div class='form-check form-switch'>";
        echo "<input class='form-check-input' type='checkbox' id='is_active' name='is_active' " . ($config['is_active'] ? 'checked' : '') . ">";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        
        echo "</div>";
        echo "</div>";
        
        // Passo a passo
        echo "<div class='card border-info mb-4'>";
        echo "<div class='card-header bg-info text-white'>";
        echo "<h4 class='m-0'>" . __('Passo a Passo para Configuração', 'glpitypebotchat') . "</h4>";
        echo "</div>";
        echo "<div class='card-body'>";
        
        echo "<ol class='list-group list-group-numbered mb-3'>";
        echo "<li class='list-group-item'>" . __('Acesse <a href="https://typebot.io" target="_blank">typebot.io</a> e crie sua conta', 'glpitypebotchat') . "</li>";
        echo "<li class='list-group-item'>" . __('Crie um novo bot ou escolha um existente', 'glpitypebotchat') . "</li>";
        echo "<li class='list-group-item'>" . __('Após configurar seu bot, vá para a aba de "Compartilhar"', 'glpitypebotchat') . "</li>";
        echo "<li class='list-group-item'>" . __('Copie a URL do seu bot e cole no campo "URL do Typebot" acima', 'glpitypebotchat') . "</li>";
        echo "<li class='list-group-item'>" . __('Clique em "Salvar" para ativar o chat no GLPI', 'glpitypebotchat') . "</li>";
        echo "</ol>";
        
        echo "<div class='alert alert-warning'>";
        echo "<i class='fas fa-exclamation-triangle'></i> ";
        echo __('Certifique-se de que seu bot está configurado para permitir o domínio do seu GLPI nas configurações do Typebot.', 'glpitypebotchat');
        echo "</div>";
        
        echo "</div>";
        echo "</div>";
        
        // Botão Salvar
        echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>";
        echo "<input type='submit' name='update' class='btn btn-primary' value='" . __('Salvar', 'glpitypebotchat') . "'>";
        echo "</div>";
        
        Html::closeForm();
        
        echo "</div>";
        echo "</div>";
    }
} 