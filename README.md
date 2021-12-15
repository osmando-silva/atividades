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

- framework PHP CodeIgniter, versão 3.0;
- bootstrap v4.0.0 e Jquery UI v1.10.4;
- jQuery JavaScript Library v3.5.1
- Bibliotecas JavaScript (jQuery) DataTable, Validate e inputmask.bundle
- Font Awesome 4.4.0;
- Bibliotecas MPDF 6.0 e Encryption;



Características do sistema:

- 
