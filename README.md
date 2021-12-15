# Atividades

Sistema de controle de atividades

Requisitos do sistema:

- Apache 2.4.41, com módulo rewrite ativado;
- PHP 7.1 ou superior, com extensões mysql, gd, mbstring, mcrypt;
- Mysql 8.0.27, Charset UTF-8 Unicode;


Instalação (Linux derivado do Debian):

- Copiar o código-fonte do projeto para a raiz do servidor web (/var/www/html/);
- Executar, como root do banco de dados, o script database.sql e, em seguida, o script atividades.sql. Isso irá criar o usuario e a base de dados do sistema;
- Inserir o código abaixo no virtualhost default do servidor web (/etc/apache2/sites-available/000-default.conf):

    <Directory /var/www/html/atividades> # No caso de Linux

        DirectoryIndex index.php
        RewriteEngine on
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule .* index.php/$0 [PT,L]
        Options None
        Options +FollowSymLinks
        AllowOverride None
        Order allow,deny
        allow from all

    </Directory>
    
- O sistema poderá ser acessado em http://localhost/atividades;    
    

Ferramentas utilizadas no sistema:

- Framework PHP CodeIgniter, versão 3.0;
- Bootstrap v4.0.0 e Jquery UI v1.10.4;
- JQuery JavaScript Library v3.5.1;
- Bibliotecas JavaScript (jQuery) DataTable, Validate e inputmask.bundle;
- Font Awesome 4.4.0;
- Bibliotecas MPDF 6.0 e Encryption;



Características do sistema:

- Está protegido por um login (CPF). Não há verificação do CPF. Qualquer sequência de 11 números poderá ser usada. Para maior segurança, durante o logon, os dados de login e de senha são criptografados;
- Todas as telas do sistema só podem ser acessadas por usuários que estejam logados;
- As senhas dos usuários são armazenadas em banco de dados, de forma segura, usando hash bcrypt;
- Os usuários são vinculados a perfis, podendo ser mais de um, os quais permitem o acesso às áreas do sistama:
    - o perfil usuário (padrão) dará acesso apenas à área de gerenciamento de atividades;
    - o perfil administrador dará acesso, além da área de gerenciamento de atividades, às áreas de gerenciamento de usuários, de tipos de atividades e de registros do sistema (logs);

- A área de gerenciamento de atividades permite:
    - Adicionar novas atividades contendo um título, descrição e tipo;
    - Listar e imprimir as atividades em aberto;
    - Marcar e desmarcar as atividades como concluídas;
    - Listar e imprimir as atividades concluídas;
    - Editar o título, descrição e tipo de uma atividade;
    - Remover uma atividade;
    - Os tipos de atividades podem ser: Desenvolvimento, Atendimento, Manutenção e Manutenção urgente;
    - Atividades de manutenção urgente não podem ser removidas, apenas finalizadas;
    - Atividades de atendimento e manutenção urgentes não podem ser finalizadas se a descrição estiver preenchida com menos de 50 caracteres;
    - Manutenções urgentes  só podem ser cadastradas (mesmo na edição ou quando reabertas) de segunda-feira a quinta-feira, em qualquer horário, e na sexta-feira até às 12:59 horas.

- A área de gerenciamento de usuários permite:
    - Cadastrar novos usuários. Ao ser cadastrado, a senha do usuário será o seu próprio login. No primeiro acesso o sistema irá solicitar a troca da senha, que deverá ter, no mínimo, 8 caracteres, uma letra maiúscula, uma minúscula e um número;
    - Editar os dados;
    - Atribuir perfis;
    - Resetar a senha, que, depois de resetada, será o seu próprio login;
    - Desativar/Ativar usuários. Usuários desativados não poderão fazer logon no sistema;;

- A área de gerenciamento de tipos de atividades permite:
    - Cadastrar novos tipos de atividades;
    - Editar os dados;
    - Excluir tipos de atividades;

- A área de gerenciamento de registros do sistema (logs) permite:
    - Consultar e imprimir os registros (logs), podendo filtar por ano, usuário e período;
    - Todas as ações que modificam dados no sistema são registradas;

