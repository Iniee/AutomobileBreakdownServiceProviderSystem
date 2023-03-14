<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$controller_path = 'App\Http\Controllers';



Route::get('/', function () { return redirect('/login'); });

// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/forgot-password', [LoginController::class, 'forgotPassword']);
Route::get('payment/status', [PaymentController::class, 'checkPaymentStatus'])->name('payment.status');

Route::group(['middleware'=> ['auth']],function () {

  // Dashboard Page Route
  Route::get('/dashboard', [DashboardController::class, 'getDashboard'])->name('dashboard');

  //Agent side bar
  Route::get('/view/agent', [AgentController::class, 'agentAccount'])->name('agent-view-agent');
  Route::any('/create/agent', [AgentController::class, 'register'])->name('agent.create');
  Route::any('/store/user', [AgentController::class, 'store'])->name('agent.store');
  Route::put('/agent/{agent}/status', [StatusController::class, 'updateStatus'])->name('agent.status');
  Route::get('/active/agent', [AgentController::class, 'activeAgent'])->name('agent-activate-agent');
  Route::get('/deactive/agent', [AgentController::class, 'deactiveAgent'])->name('agent-deactivate-agent');

  //Client Side bar
  Route::get('/view/client', [ClientController::class, 'clientAccount'])->name('client-view-client');
  Route::put('/client/{client}/status', [StatusController::class, 'clientStatus'])->name('client.status');
  Route::get('/active/client', [ClientController::class, 'activeClient'])->name('client-activate-client');
  Route::get('/deactive/client', [ClientController::class, 'deactiveClient'])->name('client-deactivate-client');
  //Provider Side bar
  Route::get('/view/provider', [ProviderController::class, 'providerAccount'])->name('provider-view-provider');
  Route::get('/deactivate/provider', [providerController::class, 'providerDeactivateAccount'])->name('provider-deactivate-provider');

  //Transaction
  Route::get('/client/transaction', [TransactionController::class, 'clientTransaction'])->name('trans-client-transaction');
  Route::get('/service/charges', [TransactionController::class, 'serviceCharges'])->name('trans-service-charges');

  //Logout
  Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



  /////////////Search
  Route::get('/agent/search', [SearchController::class, 'searchAgentTable'])->name('searchAgent');
  Route::get('/active/agents/search', [SearchController::class, 'searchActiveAgents'])->name('searchActiveAgent');
  Route::get('/inactive/agents/search', [SearchController::class, 'searchInactiveAgents'])->name('searchInactiveAgent');

  Route::get('/client/search', [SearchController::class, 'searchClientTable'])->name('searchClient');
  Route::get('/active/clients/search', [SearchController::class, 'searchActiveClients'])->name('searchActiveClient');
  Route::get('/inactive/clients/search', [SearchController::class, 'searchInactiveClients'])->name('searchInactiveClient');

  Route::get('/provider/search', [SearchController::class, 'searchSevriceProviderTable'])->name('searchProvider');

  Route::get('/transaction/search', [SearchController::class, 'searchTransactionTable'])->name('searchTransaction');

  //////////////End Search

   // Admin Profile
  Route::get('/profile/admin', [DashboardController::class, 'showProfileDetails'])->name('admin.profile');
  Route::any('/update/admin', [DashboardController::class, 'updateProfileDetails'])->name('admin.update');

  //Admin Change Password
  Route::get('/password/admin', [DashboardController::class, 'changePasswdPage'])->name('admin.changePasswordPage');
  Route::any('/changePassword/admin', [DashboardController::class, 'changePassword'])->name('admin.changePassword');

});




// Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
//Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');



// layout
Route::get('/layouts/without-menu', $controller_path . '\layouts\WithoutMenu@index')->name('layouts-without-menu');
Route::get('/layouts/without-navbar', $controller_path . '\layouts\WithoutNavbar@index')->name('layouts-without-navbar');
Route::get('/layouts/fluid', $controller_path . '\layouts\Fluid@index')->name('layouts-fluid');
Route::get('/layouts/container', $controller_path . '\layouts\Container@index')->name('layouts-container');
Route::get('/layouts/blank', $controller_path . '\layouts\Blank@index')->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', $controller_path . '\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', $controller_path . '\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', $controller_path . '\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', $controller_path . '\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');


// cards
Route::get('/cards/basic', $controller_path . '\cards\CardBasic@index')->name('cards-basic');

// User Interface
Route::get('/ui/accordion', $controller_path . '\user_interface\Accordion@index')->name('ui-accordion');
Route::get('/ui/alerts', $controller_path . '\user_interface\Alerts@index')->name('ui-alerts');
Route::get('/ui/badges', $controller_path . '\user_interface\Badges@index')->name('ui-badges');
Route::get('/ui/buttons', $controller_path . '\user_interface\Buttons@index')->name('ui-buttons');
Route::get('/ui/carousel', $controller_path . '\user_interface\Carousel@index')->name('ui-carousel');
Route::get('/ui/collapse', $controller_path . '\user_interface\Collapse@index')->name('ui-collapse');
Route::get('/ui/dropdowns', $controller_path . '\user_interface\Dropdowns@index')->name('ui-dropdowns');
Route::get('/ui/footer', $controller_path . '\user_interface\Footer@index')->name('ui-footer');
Route::get('/ui/list-groups', $controller_path . '\user_interface\ListGroups@index')->name('ui-list-groups');
Route::get('/ui/modals', $controller_path . '\user_interface\Modals@index')->name('ui-modals');
Route::get('/ui/navbar', $controller_path . '\user_interface\Navbar@index')->name('ui-navbar');
Route::get('/ui/offcanvas', $controller_path . '\user_interface\Offcanvas@index')->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', $controller_path . '\user_interface\PaginationBreadcrumbs@index')->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', $controller_path . '\user_interface\Progress@index')->name('ui-progress');
Route::get('/ui/spinners', $controller_path . '\user_interface\Spinners@index')->name('ui-spinners');
Route::get('/ui/tabs-pills', $controller_path . '\user_interface\TabsPills@index')->name('ui-tabs-pills');
Route::get('/ui/toasts', $controller_path . '\user_interface\Toasts@index')->name('ui-toasts');
Route::get('/ui/tooltips-popovers', $controller_path . '\user_interface\TooltipsPopovers@index')->name('ui-tooltips-popovers');
Route::get('/ui/typography', $controller_path . '\user_interface\Typography@index')->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', $controller_path . '\extended_ui\PerfectScrollbar@index')->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', $controller_path . '\extended_ui\TextDivider@index')->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', $controller_path . '\icons\Boxicons@index')->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', $controller_path . '\form_elements\BasicInput@index')->name('forms-basic-inputs');
Route::get('/forms/input-groups', $controller_path . '\form_elements\InputGroups@index')->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', $controller_path . '\form_layouts\VerticalForm@index')->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', $controller_path . '\form_layouts\HorizontalForm@index')->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', $controller_path . '\tables\Basic@index')->name('tables-basic');
