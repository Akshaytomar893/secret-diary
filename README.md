# secret-diary
Secret Diary let you to store your thoughts and secrets securely and permanently...

This project is developed using following technologies:
1.HTML
2.CSS
3.JQuery
4.Bootstrap
4.PHP
5.MySql

To mmake this project completly functional on your system , first you have to connect to your database by editing in connection.php file as follows:
  $link = mysqli_connect("<server_name>","<user_name>","<password>","<database_name>");
  
  
The table format for mysql database can be found inside database folder in user.sql which can be directly imported into a database using phpMyAdmin.



This project let you store your thoughts and secrets securely and permanently and can access anywhere on any device. So basically , this can work as your personal secret diary.
The auto save function of the secret diary automatically saves all your data by itself so you don't have to worry for saving the data.
For security purpose your passwords are stored using md5 encryption technique with some added salt which provide a bbetter security to your account.
