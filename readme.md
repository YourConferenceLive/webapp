
___  

<img src="https://dev.yourconference.live/ycl_assets/ycl_logo.png" alt="YCL Logo" width="150">  

# Your Conference Live (Web App) [www.yourconference.live](www.yourconference.live)


Your Conference Live is a conference/webinar management application produced by One World Presentation Management Ltd.

GitHub: [https://github.com/YourConferenceLive/webapp](https://github.com/YourConferenceLive/webapp)

## :bangbang: IMPORTANT

#### :question: What is a project?
     A project is an instance of the web app which is dedicated for a particular client.
     Eg; COS is a client (hence a project) and is accessible through /COS of the web app.


###  1. :hammer_and_wrench: Custom Configuration File
#### :warning: YCL Web App uses a single (custom) config file which is `/ycl_config.php`

All the necessary environment configuration variables are and must be supplied through this file.
`ycl_config.php` file is not version controlled.
No other configuration files should contain environment related variables.


###  2. :arrow_heading_up: Routing
#### :warning: YCL Web App works slightly different than the traditional <img src="https://dev.yourconference.live/ycl_assets/codeigniter_logo.png" alt="CodeIgniter Logo" width="20"> CodeIgniter application.

In YCL Web App, there are projects eg; COS or PCE and they are accessible through the url eg; https://yourconference.live/COS or https://yourconference.live/PCE

But YCL Web App has no controller or a directory in the controllers names COS or PCE, instead controllers are divided into 4 categories.
ie;
1. Attendee
2. Moderator
3. Presenter
4. Admin

(you can find them in `application/controllers/public/` directory)
Inside each of those directories located are the controllers eg; `Lobby.php` which makes the YCL Web App function like a CodeIgniter application.
Those controllers are common for all the projects like COS or PCE.

By default, Attendee type is loaded when a user visits a project URL.

Example 1:  https://yourconference.live/COS will load `application/controllers/public/attendee/Login.php`

Example 2: https://yourconference.live/COS/lobby will load `application/controllers/public/attendee/Lobby.php`

Example 3: https://yourconference.live/COS/presenter/login will load `application/controllers/public/presenter/Login.php`

Example 4: https://yourconference.live/COS/admin/login will load `application/controllers/public/admin/Login.php`

:hammer_and_wrench: This is accomplished using customized routing mechanism.
:round_pushpin: Routes are hard-coded into the `/project_routes.php` file

###  3. :framed_picture: Theme Mechanism
#### :warning: YCL Web App uses dedicated theme mechanism (or configurable View files)
Projects in YCL Web App can be configured to use different view files.
We call them themes, they can be found at `application/views/themes/` eg; `application/views/themes/default_theme/`

Each theme directory contains necessary view files for different user types and their controllers.
    
---  

## :heavy_check_mark: Requirements

This project requires the following:

* <img src="https://dev.yourconference.live/ycl_assets/php_logo.png" alt="PHP Logo" width="35"> PHP version 5.6 or newer (https://www.php.net/releases/5_6_0.php)  
* <img src="https://dev.yourconference.live/ycl_assets/mysql_logo.png" alt="MySQL Logo" width="40"> MySQL (5.1+) via the mysqli and pdo drivers (https://docs.oracle.com/cd/E19078-01/mysql/mysql-refman-5.1/)  
---  

## :package: Installation

This is a standalone web application built using [<img src="https://dev.yourconference.live/ycl_assets/codeigniter_logo.png" alt="CodeIgniter Logo" width="15"> CodeIgniter 3](https://codeigniter.com/userguide3/index.html).    
[<img src="https://dev.yourconference.live/ycl_assets/codeigniter_logo.png" alt="CodeIgniter Logo" width="15"> CodeIgniter](https://codeigniter.com) is a powerful PHP framework with a very small footprint, built for developers who need a simple and elegant toolkit to create full-featured web applications.


### Your Conference Live can be installed by following 4 steps;

#### 1. Clone the GitHub repository or download the zipped project files from the GitHub

#### 2. Add `ycl_config.php` file at the project root and configure your settings

#### 3. Create an empty `project_routes.php` file at the project root

#### 4. Create an empty directory `cms_uploads` at the project root

#### 5. Run `composer install`

#### 6. Import the latest database schema
  
---  

## :lock_with_ink_pen: Custom Built-in methods and definitions
>These are reserved variables/constants. You should not use them for anything else anywhere in the application.

### 1. project
```php 
$this->project 
```  
Returns the project data (every data from the `project` table) of the project user currently accessing.

### 2. project_url
```php 
$this->project_url  
```  
Returns the base url of the project user currently accessing. eg; `https://yourconference.live/COS/`

### 3. themes_dir
```php 
$this->themes_dir  
```  
Returns the parent theme directory which contains every theme. eg; `themes/`

```php 
"{$this->themes_dir}/{$this->project->theme}/"  
```  
Returns the theme directory of the project user currently accessing. eg; `themes/default_theme/`

ie;
```php  
$this->load->view("{$this->themes_dir}/{$this->project->theme}/attendee/lobby");  
```  
Will load the **Lobby** page of user-type `attendee`.

### 4. ycl_root
```php 
ycl_root
```  
Returns the root URI of the application without trailing slash(/) eg; `https://yourconference.live`  
(Equivalent of `base_url()` except the trailing slash)

You can use it in the View files this way;
```php
<?=ycl_root?>
```
  
---  

## :bust_in_silhouette: User Session

```php 
$_SESSION['project_sessions']["project_{$this->project->id}"]  
```  
Returns the session array of the project user currently accessing.

```php array(  
'user_id' => 1,  
'name' => 'John',  
'surname' => 'Doe',  
'email' => 'john_doe@yourconference.live',  
'is_attendee' => 1,  
'is_moderator' => 0,  
'is_presenter' => 0,  
'is_admin' => 0  
);  
```  
If the user is logged-in, this is what a typical array returned by `$_SESSION['project_sessions']["project_{$this->project->id}"]` looks like.
  
---  

## :computer: Development URL
[dev.yourconference.live](dev.yourconference.live)

## :desktop_computer: Production URL
[www.yourconference.live](www.yourconference.live)
  
---  

## :keyboard: Contributing
Any unauthorized modification is strictly prohibited.

Authorized developers can contribute to the `dev` branch .    
For major changes, please open an issue first to discuss what you would like to change.

### :x: DO NOT PUSH/PULL CHANGES TO/FROM THE `master` BRANCH
### :white_check_mark: ALWAYS PUSH/PULL CHANGES TO/FROM THE `dev` BRANCH

Please make sure to test the changes before committing to the repository.

## :fast_forward: Automated Deployment
Every push to the `dev` branch will automatically deploy the `dev` branch to [dev.yourconference.live](dev.yourconference.live)

## :email: Contact

**Mark Rosenthal**, President - One World Presentation Management Ltd    
[mark@owpm.com](mailto:mark@owpm.com)

Shannon Morton, One World Presentation Management Ltd    
[shannon@owpm.com](shannon@owpm.com)

Athul AK, Solutions Architect - One World Presentation Management Ltd    
[athullive@gmail.com](athullive@gmail.com) [athul@owpm.com](athul@owpm.com)


## :copyright: License
Copyright (c) One World Presentation Management Ltd - All Rights Reserved
