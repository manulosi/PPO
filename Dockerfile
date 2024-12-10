# Usar uma imagem oficial do PHP com Apache
FROM php:8.2-apache

# Copiar os arquivos do projeto para o diretório root do servidor
COPY . /var/www/html/

# Dar as permissões corretas no diretório da aplicação
RUN chown -R www-data:www-data /var/www/html

# Instalar extensões do PHP (se necessário)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expor a porta 80
EXPOSE 80

# Comando padrão para iniciar o servidor
CMD ["apache2-foreground"]