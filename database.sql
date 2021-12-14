CREATE USER 'atividades'@'localhost' IDENTIFIED WITH caching_sha2_password BY '$up0r#e1971';
GRANT USAGE ON *.* TO 'atividades'@'localhost';
CREATE DATABASE IF NOT EXISTS `atividades`;
GRANT ALL PRIVILEGES ON `atividades`.* TO 'atividades'@'localhost';
