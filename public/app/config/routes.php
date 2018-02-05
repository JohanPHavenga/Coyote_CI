<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

//$route['news/(:any)'] = 'news/view/$1';
//$route['news'] = 'news';
//$route['(:any)'] = 'pages/view/$1';
$route['default_controller'] = 'pages/view';

//$route['default_controller'] = 'welcome';
$route['404_override'] = 'pages/my_404';
$route['translate_uri_dashes'] = FALSE;
// for admin
$route['admin'] = 'admin/dashboard/view';

//basic pages running through PAGES controller
$route['about'] = 'pages/about';
$route['mailer'] = 'pages/mailer';
$route['404'] = 'pages/my_404';
$route['search'] = 'pages/search';
$route['events'] = 'event/calendar';

// redirect
$route['capetown'] = 'landing/cape+town';
$route['CapeTown'] = 'landing/cape+town';
$route['overberg'] = 'landing/overberg';
$route['Overberg'] = 'landing/overberg';
$route['winelands'] = 'landing/winelands';
$route['Winelands'] = 'landing/winelands';
$route['westcoast'] = 'landing/west+coast';
$route['WestCoast'] = 'landing/west+coast';
$route['gardenroute'] = 'landing/garden+route';
$route['GardenRoute'] = 'landing/garden+route';

$route['content-overview'] = 'event/calendar';

$route['seo/sitemap\.xml'] = "seo/sitemap";