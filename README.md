# my_project_JO2024

=======================================================
==================== Installation =====================
=======================================================
=== Prérequis : Composer (https://getcomposer.org/) ===

Ouvrez le terminal de votre ordinateur, allez dans le dossier d'installation du projet et cloner le dépôt :
=> Tapez les commande suivantes :
=> Tapez la commande : git clone https://github.com/AbdelAYYADI/my_project_JO2024.git + ENTREE
=> Dans le terminal allez dans le sous dossier créé par le clonage
=> Tapez la commande : composer install + ENTREE
=> créez ou modifiez le fichier .env :
 	=> ajouter la ligne ci-dessous pour définir la base de données:
 	=> DATABASE_URL="mysql://user:password@127.0.0.1:3306/db_jo2024_test"
 	=> NB : user et password doivent être créés dans l'admin de votre serveur de base de données (ex phpMyAdmin)
=> Tapez la commande : php bin/console doctrine:database:create
=> Tapez la commande : php bin/console doctrine:migrations:migrate
=> Tapez la commande : php bin/console doctrine:fixtures:load
=> Lancez l'application via votre navigateur :
 	=> configurez le port de votre serveur web (ex Apache) afin q'il pointe sur le dossier de l'application
 	=> ex : http://127.0.0.1:8001/

