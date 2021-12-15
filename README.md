# atividades
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
    

Ferramentas utilizadas no sistema:

- Framework PHP CodeIgniter, versão 3.0;
- Bootstrap v4.0.0 e Jquery UI v1.10.4;
- JQuery JavaScript Library v3.5.1;
- Bibliotecas JavaScript (jQuery) DataTable, Validate e inputmask.bundle;
- Font Awesome 4.4.0;
- Bibliotecas MPDF 6.0 e Encryption;



Características do sistema:

- Está protegido por um login;
- Todas as telas do sistema só podem ser acessadas por usuários que estejam logados;
- As senhas dos usuários são armazenadas em banco de dados, de forma segura, usando hash bcrypt;
- Os usuários são vinculados a perfis, podendo ser mais de um, os quais permitem o acesso às áreas do sistama:
    - o perfil usuário (padrão) dará acesso apenas à área de gerenciamento de atividades;
    - o perfil administrador dará acesso, além da área de gerenciamento de atividades, às áreas de gerenciamento de usuários, de tipos de atividades e de registros do sistema (logs);

- A área de gerenciamento de atividades permite:
    - adicionar novas atividades contendo um título, descrição e tipo;
    - Listar as atividades em aberto;
    - Marcar e desmarcar as atividades como concluídas;
    - Listar as atividades concluídas;
    - Editar o título, descrição e tipo de uma atividade;
    - Remover uma atividade;
    - Os tipos de atividades podem ser: Desenvolvimento, Atendimento, Manutenção e Manutenção urgente;
    - Atividades de manutenção urgente não podem ser removidas, apenas finalizadas;
    - Atividades de atendimento e manutenção urgentes não podem ser finalizadas se a descrição estiver preenchida com menos de 50 caracteres;
    - Manutenções urgentes  só podem ser cadastradas de segunda-feira a quinta-feira, em qualquer horário, e na sexta-feira até às 12:59 horas.

