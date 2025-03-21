GLPI Typebot Chat Plugin

📌 Descrição

O GLPI Typebot Chat Plugin é um plugin desenvolvido para integrar o GLPI com o Typebot, permitindo que os usuários acessem um chat diretamente da interface do GLPI. Esse plugin adiciona um botão que abre um modal contendo um chat Typebot, facilitando a interação dos usuários com um chatbot automatizado.

🔍 Como Funciona?

O plugin adiciona um botão na interface do GLPI.

Quando clicado, ele abre um modal com um iframe carregando o Typebot.

O chat pode ser usado para tirar dúvidas, abrir chamados ou interagir com a IA configurada no Typebot.

📥 Instalação

Siga os passos abaixo para instalar corretamente o plugin no GLPI:

1️⃣ Clonar o repositório

Abra o terminal e copie o repositório para a pasta de plugins do GLPI:

cd /var/www/html/glpi/plugins
wget https://github.com/Yefclub/Plugin-GLPI-Typebot/archive/refs/heads/main.zip
unzip main.zip

2️⃣ Renomear a pasta

Renomeie a pasta clonada para o nome correto do plugin:

mv Plugin-GLPI-Typebot-main/glpitypebotchat glpitypebotchat

3️⃣ Ativar o Plugin no GLPI

Acesse o painel administrativo do GLPI.

Vá até Configurações > Plugins.

Encontre o plugin GLPI Typebot Chat e clique em Instalar.

Após a instalação, clique em Ativar.

📜 Licença

Este projeto é distribuído sob a Licença GPL-3.0.
