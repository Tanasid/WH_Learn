<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//Check Auth //
$routes->get('/', 'Home::index', ['filter' => 'authOut']);
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/start', 'Dashboard::index', ['filter' => 'auth']);

// DashBoard //
$routes->get('/dashboard/getView', 'Dashboard::getView',);
$routes->get('/dashboard/getUser', 'Dashboard::getUser',);


// ManageAccount //
$routes->get('/manageAccount', 'ManageAccount::index', ['filter' => 'auth']);
$routes->get('/manageAccount/showAccount', 'ManageAccount::showAccount',);
$routes->post('/manageAccount/updateStatusFlag', 'ManageAccount::updateStatusFlag',);
$routes->get('/manageAccount/getPermissionGroups', 'ManageAccount::getPermissionGroups',);
$routes->get('/manageAccount/getPlant', 'ManageAccount::getPlant',);
$routes->get('/manageAccount/getDataEdit', 'ManageAccount::getDataEdit',);
$routes->post('/manageAccount/addAccount', 'ManageAccount::addAccount',);
$routes->post('/manageAccount/updateAccount', 'ManageAccount::updateAccount',);
$routes->post('/manageAccount/deleteAccount', 'ManageAccount::deleteAccount',);


// ManageMainMenu //
$routes->get('/manageMainMenu', 'ManageMainMenu::index', ['filter' => 'auth']);
$routes->get('/manageMainMenu/getMainMenu', 'ManageMainMenu::getMainMenu',);
$routes->get('/manageMainMenu/getMainMenuByStatus', 'ManageMainMenu::getMainMenuByStatus',);
$routes->get('/manageMainMenu/addMainMenu', 'ManageMainMenu::addMainMenu',);
$routes->get('/manageMainMenu/updateStatusFlg', 'ManageMainMenu::updateStatusFlg',);
$routes->get('/manageMainMenu/getMainMenuByID', 'ManageMainMenu::getMainMenuByID',);
$routes->get('/manageMainMenu/updateMainMenu', 'ManageMainMenu::updateMainMenu',);

// ManageSubMenu //
$routes->get('/ManageSubMenu', 'ManageSubMenu::index', ['filter' => 'auth']);
$routes->get('/ManageSubMenu/getSubMenu', 'ManageSubMenu::getSubMenu',);
$routes->get('/ManageSubMenu/getSubMenuByStatus', 'ManageSubMenu::getSubMenuByStatus',);
$routes->get('/ManageSubMenu/getMainMenu', 'ManageSubMenu::getMainMenu',);
$routes->get('/ManageSubMenu/getSubMenuById', 'ManageSubMenu::getSubMenuById',);
$routes->get('/ManageSubMenu/updateStatusFlg', 'ManageSubMenu::updateStatusFlg',);
$routes->get('/ManageSubMenu/editSubMenuById', 'ManageSubMenu::editSubMenuById',);
$routes->post('/ManageSubMenu/addSubMenu', 'ManageSubMenu::addSubMenu',);

// ManagePermissionGroup //
$routes->get('/managePermissionGroup', 'ManagePermissionGroup::index', ['filter' => 'auth']);
$routes->get('/managePermissionGroup/getPermisGroup', 'ManagePermissionGroup::getPermisGroup',);
$routes->get('/managePermissionGroup/getPermisGPByStatus', 'ManagePermissionGroup::getPermisGPByStatus',);
$routes->post('/managePermissionGroup/addPermisGP', 'ManagePermissionGroup::addPermisGP',);
$routes->get('/managePermissionGroup/getPermisGPByID', 'ManagePermissionGroup::getPermisGPByID',);
$routes->post('/managePermissionGroup/updatePermisGP', 'ManagePermissionGroup::updatePermisGP',);
$routes->get('/managePermissionGroup/updateStatusFlg', 'ManagePermissionGroup::updateStatusFlg',);

// ManagePermission //
$routes->get('/managePermission', 'ManagePermission::index', ['filter' => 'auth']);
$routes->get('/managePermission/getPermisGP', 'ManagePermission::getPermisGP',);
$routes->get('/managePermission/getPermisDetail', 'ManagePermission::getPermisDetail',);
$routes->get('/managePermission/getMainMenu', 'ManagePermission::getMainMenu',);
$routes->get('/managePermission/getSubMenuByMainSel', 'ManagePermission::getSubMenuByMainSel',);
$routes->post('/managePermission/addPermis', 'ManagePermission::addPermis',);
$routes->get('/managePermission/getStatus', 'ManagePermission::getStatus',);
$routes->get('/managePermission/updateStatusFlg', 'ManagePermission::updateStatusFlg',);

// Edit Profile //
$routes->post('/editProfile/updateProfile', 'EditProfile::updateProfile',);

// Department //
$routes->get('/department', 'Department::index', ['filter' => 'auth']);
$routes->post('/department/addDepartment', 'Department::addDepartment',);
$routes->get('/department/updateStatusFlg', 'Department::updateStatusFlg',);
$routes->get('/department/getDepByStatus', 'Department::getDepByStatus',);
$routes->get('/department/getDepartment', 'Department::getDepartment',);
$routes->get('/department/getDepartmentByID', 'Department::getDepartmentByID',);
$routes->post('/department/updateDepartment', 'Department::updateDepartment',);

// Subject //
$routes->get('/subject', 'Subject::index', ['filter' => 'auth']);

// Login //
$routes->get('/login', 'Home::index', ['filter' => 'authOut']);
$routes->get('/logout', 'Login::logout');
// $routes->get('/SubMenuPermission/(:num)', 'SubMenuPermission::index',);

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
