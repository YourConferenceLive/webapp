___

<img src="https://dev.yourconference.live/ycl_assets/ycl_logo.png" alt="YCL Logo" width="150">

# Your Conference Live (Web App) 
[www.yourconference.live](www.yourconference.live)

Your Conference Live is a conference/webinar management application produced by One World Presentation Management Ltd.  

GitHub: [https://github.com/YourConferenceLive/webapp](https://github.com/YourConferenceLive/webapp)

---

## Requirements

This project requires the following:

 * PHP version 5.6 or newer (https://www.php.net/releases/5_6_0.php)
 * MySQL (5.1+) via the mysqli and pdo drivers (https://docs.oracle.com/cd/E19078-01/mysql/mysql-refman-5.1/)
---

## Installation

This is a standalone web application built using [CodeIgniter 3](https://codeigniter.com/userguide3/index.html).  
[CodeIgniter](https://codeigniter.com) is a powerful PHP framework with a very small footprint, built for developers who need a simple and elegant toolkit to create full-featured web applications.


### Your Conference Live can be installed by following 4 steps;

#### 1. Clone the GitHub repository or download the zipped project files from the GitHub

#### 2. Add `ycl_config.php` file at the project root and configure your settings

#### 2. Create an empty `project_routes.php` file at the project root

#### 3. Create an empty directory `cms_uploads` at the project root

#### 3. Run `composer install`

#### 4. Import the latest database schema

---

## Custom Built-in methods and definitions
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

---

## User Session

```php 
$_SESSION['project_sessions']["project_{$this->project->id}"]
```
Returns the session array of the project user currently accessing.

```php 
array(
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

## Development URL
[dev.yourconference.live](dev.yourconference.live)

## Production URL
[www.yourconference.live](www.yourconference.live)

---

## Contributing
Any unauthorized modification is strictly prohibited. 
 
Authorized developers can create pull requests.  
For major changes, please open an issue first to discuss what you would like to change.

### :x: DO NOT PUSH/PULL CHANGES TO/FROM THE `master` BRANCH
### :white_check_mark: ALWAYS PUSH/PULL CHANGES TO/FROM THE `dev` BRANCH


Please make sure to test the changes before committing to the repository.

## Automated Deployment
Every push to the `dev` branch will automatically deploy the `dev` branch to [dev.yourconference.live](dev.yourconference.live)

##Contact

**Mark Rosenthal**, President - One World Presentation Management Ltd  
[mark@owpm.com](mailto:mark@owpm.com)

Shannon Morton, One World Presentation Management Ltd  
[shannon@owpm.com](shannon@owpm.com)

Athul AK, Developer - One World Presentation Management Ltd  
[athullive@gmail.com](athullive@gmail.com)  
[athul@owpm.com](athul@owpm.com)


## License
Copyright (c) One World Presentation Management Ltd - All Rights Reserved
