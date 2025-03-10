# GLPI Typebot Chat Plugin

Este plugin adiciona um chat interativo do Typebot ao GLPI, permitindo uma melhor comunicação com os usuários através de um chatbot personalizado.

## Características

- Integração fácil com o Typebot
- Ícone de chat flutuante personalizável
- Modal de chat responsivo
- Configurações simples através da interface do GLPI
- Suporte a múltiplas posições do ícone de chat
- Não aparece na tela de chamados

## Requisitos

- GLPI >= 10.0.0
- PHP >= 7.4

## Instalação

1. Faça o download do plugin
2. Extraia o arquivo zip na pasta `plugins` do seu GLPI
3. Renomeie a pasta para `glpitypebotchat` (se necessário)
4. Acesse o GLPI como administrador
5. Vá para Configurar > Plugins
6. Instale e ative o plugin

## Configuração

1. Acesse Configurar > Plugins > GLPI Typebot Chat
2. Insira a URL do seu bot do Typebot
3. Escolha a posição do ícone de chat (inferior direito ou inferior esquerdo)
4. Ative ou desative o chat conforme necessário
5. Clique em Salvar

## Uso

Após a configuração, o ícone do chat aparecerá na posição selecionada em todas as páginas do GLPI, exceto na tela de chamados.
Os usuários podem clicar no ícone para abrir o chat em um modal e interagir com o bot.

## Suporte

Para relatar problemas ou sugerir melhorias, por favor, abra uma issue no repositório do GitHub.

## Licença

Este plugin é distribuído sob a licença GPL v3+. 