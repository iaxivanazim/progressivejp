# progressivejp
software for tracking Progressive Jackpots (For GAMEXPRO)

## Laravel Project Setup Guide (Windows)
This guide will help you set up and run a Laravel project on your Windows machine. Follow the steps below to install the necessary software, clone the repository, and run the project.

### Prerequisites
Before starting, ensure you have the following installed:

Git: Download and install from git-scm.com  
XAMPP: Download and install from xampp.org  

### Step 1: Install XAMPP
Download XAMPP from the official website.  
Install XAMPP, making sure to enable Apache and MySQL during installation.  
Start Apache and MySQL using the XAMPP Control Panel.  

### Step 2: Install Composer
Download and install Composer from getcomposer.org.  
To check if Composer is installed, open cmd and type:  

`composer -v`

###  Step 3: Clone the Laravel Project
Open Git Bash or Command Prompt.  
Navigate to the htdocs directory in XAMPP where your projects will be stored:  

`cd /path/to/xampp/htdocs`  

For example:  

`cd C:/xampp/htdocs`  

Clone the repository using the following command:  

`git clone https://github.com/your-username/your-repository-name.git`  

Navigate to the project directory:  

`cd your-repository-name`

### Step 4: Set Up .env File
Copy the .env.example file to create the .env file:  

`cp .env.example .env`  

Open the .env file in a text editor and configure the database connection details:  
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=progressivejp
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```
### Step 5: Install PHP Extensions (if necessary)
Locate php.ini file under xampp/php/php.ini.  
Replace this file with php.ini file present in the progressivejp project  

Restart Apache via the XAMPP Control Panel.

### Step 6: Install Project Dependencies
Open Command Prompt in the project folder and run the following command to install all required packages:  

`composer install`

### Step 7: Generate Application Key
Run the following command to generate an application key:  

`php artisan key:generate`

### Step 8: Configure Folder Permissions
Make sure the storage and bootstrap/cache directories are writable:  
```
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```
### Step 9: Create a MySQL Database
Open phpMyAdmin by navigating to http://localhost/phpmyadmin.  
Click on Databases and create a new database named progressivejp.  

### Step 10: Run Migrations
To create the necessary tables, run the migrations:  

`php artisan migrate`

### Step 11: Seed the Database
Seed the database with initial data:  

`php artisan db:seed`

### Step 12: Run the Laravel Development Server
Finally, to run the Laravel project, use the following command:  

`php artisan serve`  

The application will be accessible at http://127.0.0.1:8000.  

To access your Laravel app on a specific IP address without typing the port number, you’ll need to use port 80, which is the default HTTP port. This way, you can simply type the IP address without a port. Here’s how to achieve that:  

`php artisan serve --host=0.0.0.0 --port=80`  
replace 0.0.0.0 with your server IP address  

### Troubleshooting
#### Common Issues:
"Access Denied for User": Ensure your MySQL credentials in the .env file are correct.  
"Could Not Find Driver": Make sure pdo_mysql is enabled in php.ini and restart Apache.  
Permissions Issues: Use chmod to grant appropriate permissions to storage and bootstrap/cache directories.  

#### You can now access and use the Laravel application on your local development environment.