---------------
 ASSETS MODULE 
---------------

-----------------------
 DEPENDENCIES Composer
-----------------------

(1) Robo:
	"codegyre/robo": "*",

(2) Scss:
	"leafo/scssphp": "*",
	
(3) JS Squeeze:
	"patchwork/jsqueeze": "~1.0",
	
(4) CSS Min:
	"natxet/CssMin": "~3.0"
	
-------------
 CONFIG File	
-------------
Located in application/config/config_assets.php

---------------
 AUTOLOAD File
---------------
Located in application/config/autoload.php

	- Add 'assets/AssetCss' to the $autoload['libraries'] array
	- Add 'assets/AssetJs' to the $autoload['libraries'] array

--------------
 ASSET Module
--------------
Copy the assets folder into the modules folder located in application/modules

--------------------
 ASSET Module Setup 
--------------------

(1) Copy config_assets.php into application/config/

(2) Copy assets module into application/modules/

(3) If not this setup adjust config accordingly.
    - create assets folder on root
	- create the following folders
		- assets/js			( Project js files )
		- assets/scss		( Project scss files )
		- assets/temp		( Temp directory used by Asset module to create files. )
		- assets/vendor		( This will house the vendor based css and js frameworks. )
		
(4) If not this setup adjust in config accordingly.
	- create pubic folder on root that will be to the public
	- craete the following folders
		- public/css
		- public/img
		- public/js
		
(5) Implementing in the page.
	
	With the sample below the pages are in the order in which you want to compile the css.
	The parameter in the new Class declaration will be the name you want the css to be if none provided 'default' will be used.
	
	*** EXAMPLE ***
	
	<?php
		$css = new AssetCss('login');
		$css->add_asset('./assets/vendor/bootstrap/dist/css/bootstrap.min.css');
		$css->add_asset('./assets/vendor/font-awesome/css/font-awesome.min.css');
	    $css->add_asset($this->config->item('base_preprocess'));
		$css->add_asset('./application/modules/ezauth/assets/scss/ezauth.scss');
	?>

	<link type="text/css" rel="stylesheet" href="<?php echo Modules::run('assets/AssetCreate/index', $css); ?>" media="all" />
	
	
	
	
	