<?php
use App\EnxRtc\Errors;
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
// Cache clear route
Route::get(
    'cache-clear',
    function () {
        \Artisan::call('config:cache');
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        return redirect()->back();
    }
);
// Authentication|Guest Routes
Auth::routes();
//Video Routes

Route::get('/joinvideo', function () {
    return view('front-end.video.index');
});

Route::get('/confo/{room}/{type}/{ref}',  "EnxRtc\RoomController@confo");
// Home
Route::get(
    '/',
    function () {
        if (Schema::hasTable('users')) {
            if (file_exists(resource_path('views/extend/front-end/index.blade.php'))) {
                return view('extend.front-end.index');
            } else {
                return view('front-end.index');
            }
        } else {
            if (!empty(env('DB_DATABASE'))) {
                return Redirect::to('/install');
            } else {
                return trans('lang.configure_database');
            }
        }
    }
)->name('home');
Route::get(
    '/home',
    function () {
        return Redirect::to('/');
    }
);

Route::get('cookie', function (Illuminate\Http\Request $request) {
    dd(
        $request,
        $request->cookie(),
        $request->session(),
        $request->header('User-Agent'),
    Cookie::get(),
        Request::cookie('uuid')
    );
});

Route::post('user/add-wishlist', 'UserController@addWishlist');
Route::post('user/remove-wishlist', 'UserController@removeWishlist');
Route::post('user/add-liked-answer', 'UserController@addLikedAnswer');
Route::post('profile/get-liked-answer', 'UserController@getLikedAnswer');
Route::post('profile/get-wishlist', 'UserController@getUserWishlist');
Route::post('submit-report', 'UserController@storeReport');


//Admin Routes
Route::group(
    ['middleware' => ['role:admin']],
    function () {
        Route::post('admin/update/medical-verify', 'UserController@updateUserMedical');

        //Symptoms
        Route::get('admin/symptom', 'SymptomController@index')->name('symptom');
        Route::get('admin/symptom/edit/{slug}', 'SymptomController@edit')->name('editSymptom');
        Route::post('admin/store-symptom', 'SymptomController@store');
        Route::post('admin/store-symptoms', 'SymptomController@store_symptoms');
        Route::get('admin/symptoms/search', 'SymptomController@index')->name('searchSymptom');
        Route::post('admin/symptom/delete', 'SymptomController@destroy');
        Route::post('admin/symptom/deleted', 'SymptomController@destroy_top');
        Route::post('admin/symptom/update/{id}', 'SymptomController@update');
        Route::post('admin/delete-checked-symptoms', 'SymptomController@deleteSelected');

        //Specialities
        Route::get('admin/specialities', 'SpecialityController@index')->name('specialities');
        Route::get('admin/specialities/edit/{slug}', 'SpecialityController@edit')->name('editSpeciality');
        Route::post('admin/store-speciality', 'SpecialityController@store');
        Route::post('admin/store-specialities', 'SpecialityController@store_speciality');
        Route::get('admin/specialities/search', 'SpecialityController@index')->name('searchSpecialities');
        Route::post('admin/specialities/delete', 'SpecialityController@destroy');
        Route::post('admin/specialities/deleted', 'SpecialityController@destroy_top');
        Route::post('admin/specialities/update/{id}', 'SpecialityController@update');
        Route::post('admin/delete-checked-specialities', 'SpecialityController@deleteSelected');

        // Treatments
        Route::get('admin/treatments', 'TreatmentController@index')->name('treatments');
        Route::post('admin/store-treatment', 'TreatmentController@store');
        Route::post('admin/treatments/delete', 'TreatmentController@destroy');
        Route::get('admin/treatments/edit/{id}', 'TreatmentController@edit');
        Route::post('admin/treatments/update/{id}', 'TreatmentController@update');
        Route::get('admin/treatments/search', 'TreatmentController@index')->name('searchTreatments');

        // Affairs Routes
        Route::get('admin/affairs', 'AffairController@index')->name('affairs');
        Route::post('admin/store-affair', 'AffairController@store');
        Route::post('admin/affairs/delete', 'AffairController@destroy');
        Route::get('admin/affairs/edit/{id}', 'AffairController@edit');
        Route::post('admin/affairs/update/{id}', 'AffairController@update');
        Route::get('admin/affairs/search', 'AffairController@index')->name('searchAffairs');

        // Affairs Details Routes
        Route::get('admin/affair-details', 'AffairDetailController@index')->name('affair-details');
        Route::post('admin/store-affair-details', 'AffairDetailController@store');
        Route::post('admin/affairs-details/delete', 'AffairDetailController@destroy');
        Route::get('admin/affairs-details/edit/{id}', 'AffairDetailController@edit');
        Route::post('admin/affairs-details/update/{id}', 'AffairDetailController@update');
        Route::get('admin/affairs-details/search', 'AffairDetailController@index')->name('searchAffairDetails');


        // Category Routes
        Route::get('admin/categories', 'CategoryController@index')->name('categories');
        Route::get('admin/categories/edit/{slug}', 'CategoryController@edit')->name('editCategories');
        Route::post('admin/store-category', 'CategoryController@store');
        Route::get('admin/categories/search', 'CategoryController@index')->name('categoriesSearch');
        Route::post('admin/categories/delete', 'CategoryController@destroy');
        Route::post('admin/categories/update/{id}', 'CategoryController@update');
        Route::post('admin/delete-checked-categories', 'CategoryController@deleteSelected');
        // Improvement Options Routes
        Route::get('admin/improvement-options', 'ImprovementOptionController@index')->name('improvement-opts');
        Route::get('admin/improvement-options/edit/{slug}', 'ImprovementOptionController@edit')->name('edit-improvement-opts');
        Route::post('admin/store-improvement-opts', 'ImprovementOptionController@store');
        Route::get('admin/improvement-options/search', 'ImprovementOptionController@index')->name('search-improvement-opts');
        Route::post('admin/improvement-options/delete', 'ImprovementOptionController@destroy');
        Route::post('admin/improvement-options/update/{id}', 'ImprovementOptionController@update');
        Route::post('admin/delete-checked-imprv-opts', 'ImprovementOptionController@deleteSelected');
        // Location Routes
        Route::get('admin/locations', 'LocationController@index')->name('locations');
        Route::get('admin/locations/edit/{slug}', 'LocationController@edit')->name('editLocations');
        Route::post('admin/store-location', 'LocationController@store');
        Route::post('admin/store-locations', 'LocationController@store_location');
        Route::get('admin/locations/search', 'LocationController@index')->name('searchLocations');
        Route::post('admin/locations/delete', 'LocationController@destroy');
        Route::post('admin/locations/deleted', 'LocationController@destroy_top');
        Route::post('admin/locations/update/{id}', 'LocationController@update');
        Route::post('admin/get-location-flag', 'LocationController@getFlag');
        Route::post('admin/delete-checked-locations', 'LocationController@deleteSelected');
        // Urls Routes or Pages Routes
        Route::get('admin/url', 'UrlController@index');
        Route::post('admin/store-url', 'UrlController@store');
        Route::post('admin/url/delete', 'UrlController@destroy');
        Route::get('admin/url/edit/{id}', 'UrlController@edit');
        Route::post('admin/url/update/{id}', 'UrlController@update');
        Route::get('admin/url/show/{id}', 'UrlController@show');

         // Roles Routes
        Route::get('admin/role', 'RolesController@index');
        Route::post('admin/store-role', 'RolesController@store');
        Route::post('admin/role/delete', 'RolesController@destroy');
        Route::get('admin/role/edit/{id}', 'RolesController@edit');
        Route::post('admin/role/update/{id}', 'RolesController@update');


            // Vaccinations Routes
        Route::get('admin/vaccination', 'VaccinationController@index');
        Route::post('admin/store-vaccination', 'VaccinationController@store');
        Route::post('admin/vaccination/delete', 'VaccinationController@destroy');
        Route::get('admin/vaccination/edit/{id}', 'VaccinationController@edit');
        Route::post('admin/vaccination/update/{id}', 'VaccinationController@update');

            // Vaccination location Routes
        Route::get('admin/vaccination-location', 'Vaccination_locationController@index');
        Route::post('admin/store-vaccination-location', 'Vaccination_locationController@store');
        Route::post('admin/vaccination-location/delete', 'Vaccination_locationController@destroy');
        Route::get('admin/vaccination-location/edit/{id}', 'Vaccination_locationController@edit');
        Route::post('admin/vaccination-location/update/{id}', 'Vaccination_locationController@update');

            // Vaccination alerts Routes
        Route::get('admin/vaccination-alert', 'Vaccination_alertController@index');
        Route::post('admin/store-vaccination-alert', 'Vaccination_alertController@store');
        Route::post('admin/vaccination-alert/delete', 'Vaccination_alertController@destroy');
        Route::get('admin/vaccination-alert/edit/{id}', 'Vaccination_alertController@edit');
        Route::post('admin/vaccination-alert/update/{id}', 'Vaccination_alertController@update');


        // Departments Routes
        Route::get('admin/department', 'DepartmentController@index');
        Route::post('admin/store-department', 'DepartmentController@store');
        Route::post('admin/department/delete', 'DepartmentController@destroy');
        Route::get('admin/department/edit/{id}', 'DepartmentController@edit');
        Route::post('admin/department/update/{id}', 'DepartmentController@update');

        // Department Service Routes
        Route::get('admin/department-service', 'DepartmentServiceController@index');
        Route::post('admin/store-department-service', 'DepartmentServiceController@store');
        Route::post('admin/department-service/delete', 'DepartmentServiceController@destroy');
        Route::get('admin/department-service/edit/{id}', 'DepartmentServiceController@edit');
        Route::post('admin/department-service/update/{id}', 'DepartmentServiceController@update');

          // Ppeciality Tests Routes
        Route::get('admin/speciality-test', 'Speciality_TestController@index');
        Route::post('admin/store-test', 'Speciality_TestController@store');
        Route::post('admin/test/delete', 'Speciality_TestController@destroy');
        Route::get('admin/test/edit/{id}', 'Speciality_TestController@edit');
        Route::post('admin/test/update/{id}', 'Speciality_TestController@update');


        // Diagnosis Routes
        Route::get('admin/diagnose', 'DiagnoseController@index');
        Route::post('admin/store-diagnose', 'DiagnoseController@store');
        Route::post('admin/diagnose/delete', 'DiagnoseController@destroy');
        Route::get('admin/diagnose/edit/{id}', 'DiagnoseController@edit');
        Route::post('admin/diagnose/update/{id}', 'DiagnoseController@update');

          // Medicines Routes
        Route::get('admin/medicine', 'MedicineController@index');
        Route::post('admin/store-medicine', 'MedicineController@store');
        Route::post('admin/medicine/delete', 'MedicineController@destroy');
        Route::get('admin/medicine/edit/{id}', 'MedicineController@edit');
        Route::post('admin/medicine/update/{id}', 'MedicineController@update');

        // Facility Routes
        Route::get('admin/facility', 'FacilityController@index');
        Route::post('admin/store-facility', 'FacilityController@store');
        Route::post('admin/facility/delete', 'FacilityController@destroy');
        Route::get('admin/facility/edit/{id}', 'FacilityController@edit');
        Route::post('admin/facility/update/{id}', 'FacilityController@update');

        // Procedure Routes
        Route::get('admin/procedure', 'ProcedureController@index');
        Route::post('admin/store-procedure', 'ProcedureController@store');
        Route::post('admin/procedure/delete', 'ProcedureController@destroy');
        Route::get('admin/procedure/edit/{id}', 'ProcedureController@edit');
        Route::post('admin/procedure/update/{id}', 'ProcedureController@update');

        //Admin All Appointments
        Route::get('admin/visit-appointment', 'AppointmentBookingController@visit_appointment');
        Route::post('admin/visit-appointment/delete', 'AppointmentBookingController@delete_visit');
        Route::get('admin/online-appointment', 'AppointmentBookingController@online_appointment');
        Route::post('admin/online-appointment/delete', 'AppointmentBookingController@delete_online');

        // FAQ'S Routes
        Route::get('admin/faq', 'FaqController@index');
        Route::post('admin/store-faq', 'FaqController@store');
        Route::post('admin/faq/delete', 'FaqController@destroy');
        Route::get('admin/faq/edit/{id}', 'FaqController@edit');
        Route::post('admin/faq/update/{id}', 'FaqController@update');
        Route::get('admin/faq/{status}/{id}','FaqController@approve');

        // Services Routes
        Route::get('admin/services', 'ServiceController@index')->name('services');
        Route::get('admin/services/edit/{slug}', 'ServiceController@edit')->name('editServices');
        Route::post('admin/store-service', 'ServiceController@store');
        Route::post('admin/store-services', 'ServiceController@store_service');
        Route::get('admin/services/search', 'ServiceController@index')->name('searchServices');
        Route::post('admin/services/delete', 'ServiceController@destroy');
        Route::post('admin/services/deleted', 'ServiceController@destroy_top');
        Route::post('admin/services/update/{id}', 'ServiceController@update');
        Route::post('admin/delete-checked-services', 'ServiceController@deleteSelected');
        //Home Page Settings Route
        Route::get('admin/settings/home-page-settings', 'SiteManagementController@homePageSettings')->name('homePageSettings');
        //Map Image
        Route::post('admin/store-map-img', 'SiteManagementController@mapimg');
        Route::get('admin/settings/general-settings', 'SiteManagementController@generalSettings')->name('generalSettings');
        Route::post('admin/store/reg-form-settings', 'SiteManagementController@storeRegistrationSettings')->name('storeRegFormSettings');
        Route::post('admin/store/home-slider-settings', 'SiteManagementController@storeHomeSliderSettings')->name('storeHomeSettings');
        Route::post('admin/store/home-search-banner-settings', 'SiteManagementController@storeHomeSearchBannerSettings')->name('storeSearchBannerSettings');
        Route::post('admin/store/home-about-us-settings', 'SiteManagementController@storeHomeAboutUsSettings')->name('storeAboutUsSettings');
        Route::post('admin/store/home-how-works-settings', 'SiteManagementController@storeHowItWorksSettings')->name('storeHowItWorksSettings');
        Route::post('admin/store/home-service-tabs-settings', 'SiteManagementController@storeServiceTabsSettings')->name('storeServiceTabsSettings');
        Route::post('admin/store/home-seo-settings', 'SiteManagementController@storeSeoSettings');
        Route::post('admin/store/home-how-work-tabs-settings', 'SiteManagementController@storeHowWorkTabSettings')->name('storeHowWorkTabSettings');
        Route::post('admin/store/benefits-online-profile', 'SiteManagementController@storebenefitsonlineprofile')->name('storebenefitsonlineprofile');
        Route::post('admin/store/benefits-online-doctor', 'SiteManagementController@storebenefitsonlinedoctor')->name('storebenefitsonlinedoctor');
        Route::post('admin/store/doctor-slider-section-settings', 'SiteManagementController@storeDoctorSliderSettings');
        Route::post('admin/store/home-download-app-settings', 'SiteManagementController@storeDownloadAppSecSettings')->name('storeDownloadAppSecSettings');
        Route::post('admin/store/article-section-settings', 'SiteManagementController@storeArticleSectionSettings')->name('storeArticleSectionSettings');
        Route::post('admin/store/signup-section', 'SiteManagementController@storeSignUpSection')->name('storeSignUpSection');
        Route::get('admin/get-homeslider-slides', 'SiteManagementController@getHomeSliderSlides');
        Route::get('admin/get-home-sections-display-settings', 'SiteManagementController@getHomeSectionsDisplaySettings');
        Route::get('admin/get-home-service-section-color', 'SiteManagementController@getHomeServiceSectionsColorSettings');
        Route::get('admin/settings/home-page-settings/services-section', 'SiteManagementController@homePageSettings')->name('homeServicesSection');
        // General Settings
        Route::post('admin/store/settings', 'SiteManagementController@storeGeneralSettings');
        Route::post('admin/store/sidebar-settings', 'SiteManagementController@storeSidebarSettings');
        Route::post('admin/store/forum-settings', 'SiteManagementController@storeforumSettings');
        Route::post('admin/store/topbar-settings', 'SiteManagementController@storeTopBarSettings');
        Route::post('admin/store/booking-settings', 'SiteManagementController@storeAppointmentBookingSettings');
        Route::get('admin/import-update', 'SiteManagementController@importUpdate');
        Route::post('admin/store/theme-styling-settings', 'SiteManagementController@storeThemeStylingSettings');
        Route::post('admin/store/social-settings', 'SiteManagementController@storeSocialSettings');
        Route::post('admin/store/footer-settings', 'SiteManagementController@storeFooterSettings');
        Route::get('admin/get-theme-color-display-setting', 'SiteManagementController@getThemeColorDisplaySetting');
        Route::get('admin/get-theme-language-setting', 'SiteManagementController@getThemeLanguageSetting');
        Route::get('admin/get-topbar-switch-settings', 'SiteManagementController@getTopbarSwicthSettings');
        Route::get('admin/get-booking-switch-settings', 'SiteManagementController@getBookingSwicthSettings');
        Route::get('admin/get-footer-settings', 'SiteManagementController@getFooterSettings');
        Route::get('admin/get-chat-display-setting', 'SiteManagementController@getchatDisplaySetting');
        Route::get('admin/get-sidebar-display-setting', 'SiteManagementController@getSidebarSetting');
        Route::post('admin/store/upload-icons', 'SiteManagementController@storeDashboardIcons');
        Route::get('admin/get-roles', 'SiteManagementController@getRoles')->name('getRoles');
        Route::post('admin/update-role', 'SiteManagementController@updateRole')->name('updateRole');
        Route::post('admin/clear-cache', 'SiteManagementController@clearCache');
        Route::get('admin/clear-allcache', 'SiteManagementController@clearAllCache');
        Route::get('admin/import-demo', 'SiteManagementController@importDemo');
        Route::get('admin/remove-demo', 'SiteManagementController@removeDemoContent');
        Route::post('admin/store/chat-settings', 'SiteManagementController@storeChatSettings');
        Route::post('admin/store/email-settings', 'SiteManagementController@storeEmailSettings');
        Route::post('admin/store/payment-settings', 'SiteManagementController@storePaymentSettings');
        Route::post('admin/store/paypal-settings', 'SiteManagementController@storePaypalSettings');
        Route::post('admin/store/stripe-settings', 'SiteManagementController@storeStripeSettings');
        //Appointment Interval Routes
        Route::get('admin/appointment-interval', 'AppointmentIntervalController@index')->name('appointment-interval');
        Route::get('admin/appointment-interval/edit/{slug}', 'AppointmentIntervalController@edit')->name('edit-appointment-interval');
        Route::post('admin/store-appointment-interval', 'AppointmentIntervalController@store');
        Route::get('admin/appointment-interval/search', 'AppointmentIntervalController@index')->name('search-appointment-interval');
        Route::post('admin/appointment-interval/delete', 'AppointmentIntervalController@destroy');
        Route::post('admin/appointment-interval/update/{id}', 'AppointmentIntervalController@update');
        Route::post('admin/delete-checked-appnt-intrvl', 'AppointmentIntervalController@deleteSelected');
        // Appointment Duration Routes
        Route::get('admin/appointment-duration', 'AppointmentDurationController@index')->name('appointment-duration');
        Route::get('admin/appointment-duration/edit/{slug}', 'AppointmentDurationController@edit')->name('edit-appointment-duration');
        Route::post('admin/store-appointment-duration', 'AppointmentDurationController@store');
        Route::get('admin/appointment-duration/search', 'AppointmentDurationController@index')->name('search-appointment-duration');
        Route::post('admin/appointment-duration/delete', 'AppointmentDurationController@destroy');
        Route::post('admin/appointment-duration/update/{id}', 'AppointmentDurationController@update');
        Route::post('admin/delete-checked-appnt-dur', 'AppointmentDurationController@deleteSelected');
        // Pages Routes
        Route::get('admin/pages', 'PageController@index')->name('pages');
        Route::get('admin/create/page', 'PageController@create')->name('createPage');
        Route::get('admin/pages/edit-page/{id}', 'PageController@edit')->name('editPage');
        Route::post('admin/store-page', 'PageController@store');
        Route::get('admin/pages/search', 'PageController@index');
        Route::post('admin/pages/delete-page', 'PageController@destroy');
        Route::post('admin/pages/update-page', 'PageController@update');
        Route::post('admin/delete-checked-pages', 'PageController@deleteSelected');
        Route::post('admin/get-page-option', 'SiteManagementController@getPageOption');
        Route::post('admin/get/innerpage-settings', 'SiteManagementController@getInnerPageSettings');
        Route::post('admin/store/innerpage-settings', 'SiteManagementController@storeInnerPageSettings');
        //All packages
        Route::get('admin/packages', 'PackageController@create')->name('createPackage');
        Route::get('admin/packages/search', 'PackageController@create');
        Route::get('admin/packages/edit/{id}', 'PackageController@edit')->name('editPackage');
        Route::post('admin/packages/update', 'PackageController@update');
        Route::post('admin/store/package', 'PackageController@store');
        Route::post('admin/packages/delete-package', 'PackageController@destroy');
        Route::post('package/get-package-options', 'PackageController@getPackageOptions');
        Route::get('admin/payouts', 'UserController@getPayouts')->name('adminPayouts');

// Admin Invoice
        Route::get('admin/invoice', 'UserController@getinvoice');


        Route::get('admin/payouts/download/{year}/{month}', 'UserController@generatePDF');
        Route::get('admin/get/site-payment-option', 'SiteManagementController@getSitePaymentOption');
        Route::get('admin/email-templates', 'EmailTemplateController@index')->name('emailTemplates');
        Route::get('admin/email-templates/filter-templates', 'EmailTemplateController@index')->name('emailTemplates');
        Route::get('admin/email-templates/{id}', 'EmailTemplateController@edit')->name('editEmailTemplates');
        Route::post('admin/email-templates/update-content', 'EmailTemplateController@updateTemplateContent');
        Route::post('admin/email-templates/update-templates/{id}', 'EmailTemplateController@update');
// Get user listing
        Route::get('users', 'UserController@userListing')->name('manageUsers');
        // Get user role
        Route::get('users/{role}','UserController@roleListing')->name('user-role');

        Route::post('admin/delete-user', 'UserController@deleteUser')->name('adminDeleteUser');
        Route::get('admin/edit-user/{id}', 'UserController@editUser')->name('adminEditUser');
        Route::get('admin/add-user', 'UserController@createUser')->name('adminAddUser');
        Route::post('admin/edit-user-detail', 'UserController@updateUserProfileSettings');
        Route::post('admin/create-user', 'UserController@storeUser');

        Route::post('doctor/store/UpdateExperiences', 'DoctorController@storeUpdateExperiences')->name('storeUpdateExperiences');
        Route::post('doctor/store/UpdateEducations', 'DoctorController@storeUpdateEducations')->name('storeUpdateEducations');
        Route::post('doctor/store-update-award-downloads', 'DoctorController@storeUpdateAwardDownloadSettings')->name('storeUpdateAwardDownloadSettings');
        /*Extended Profile*/
        Route::post('/doctor/extend', 'DoctorController@Extend')->name('Extend');
        //All onnlin consultant doctors
        Route::get('admin/all-online', 'Allonline@index')->name('allOnline');
        Route::get('admin/moredoc/{id}', 'Allonline@moredoc')->name('all-online');
        //All Doctors
        Route::get('admin/all-doctors', 'Allonline@doctors')->name('allDoctors');
        //All extended doctors
        Route::get('admin/all-extend-doctors', 'Allonline@extendDoctors')->name('all-extend-doctors');
        //all cities extended doctors
        Route::get('admin/all-cities-extend-doctors','AllCitiesExtendedDoctorController@index');
        //Feedback Doctors
        Route::get('admin/feedback','FeedbackController@index');
        //Feedback Hospitals
        Route::get('admin/feedback-hospital','FeedbackController@hospital_feedback');
        //feedback approved/disapproved
        Route::get('admin/feedback/{status}/{id}','FeedbackController@approve');
        //Feedback Delete
        Route::post('admin/feedback/delete', 'FeedbackController@destroy');
        // Location Diseases
        Route::get('admin/diseases', 'DiseaseController@index')->name('disease');
        Route::get('admin/diseases/edit/{slug}', 'DiseaseController@edit')->name('editDiseases');
        Route::post('admin/store-disease', 'DiseaseController@store');
        Route::get('admin/diseases/search', 'DiseaseController@index')->name('searchDiseases');
        Route::post('admin/diseases/delete', 'DiseaseController@destroy');
        Route::post('admin/diseases/update/{id}', 'DiseaseController@update');
        Route::post('admin/delete-checked-diseases', 'DiseaseController@deleteSelected');
        //Doctor
        Route::get('/doctor/appointments/{id}', 'DoctorController@showAppointmentsToAdmin');

        //push notification
        Route::get('admin/notification', 'NotificationController@index');
        Route::post('admin/push-notification', 'NotificationController@store');
    }
);

/*Start New Search Routes*/

//doctor by location
Route::get('/doctors/{slug}', 'PublicController@getSearchResult')->name('doctors-by-city');
Route::get('/doctor/{slug}/{location}', 'PublicController@getSearchResult')->name('doctors-speciality-city');
Route::get('/doctors/{location}/{area}', 'PublicController@getSearchResult')->name('doctors-location-area');

//hospitals
Route::get('/hospitals/{slug}', 'PublicController@getSearchResult')->name('hospitals-by-city');
Route::get('/hospital/{speciality}/{location}', 'PublicController@getSearchResult')->name('hospitals-speciality-city');
Route::get('/hospitals/{location}/{area}', 'PublicController@getSearchResult')->name('hospitals-location-area');

//speciality
Route::get('speciality', 'SpecialityController@forum');
Route::get('speciality/{slug}', 'PublicController@getSearchResult')->name('specialityDetails');
Route::get('speciality/{slug}/{location}', 'PublicController@getSearchResult')->name('specialityDetailsLocation');

//diseases
Route::get('diseases/{slug}', 'PublicController@getSearchResult')->name('diseasesDetails');
Route::get('diseases/{slug}/{location}', 'PublicController@getSearchResult')->name('diseasesDetailsLocation');


//services
Route::get('service/{slug}', 'PublicController@getSearchResult')->name('servicesDetails');
Route::get('service/{slug}/{location}', 'PublicController@getSearchResult')->name('servicesDetailsLocation');

//symptom
//Route::get('symptom/{slug}', 'PublicController@getSearchResult')->name('symptomsDetails');
//articles
Route::get('health-articles/{category?}', 'ArticleController@articleListing')->name('articleListing');
Route::get('health-articles/{slug}', 'ArticleController@articleDetail')->name('articleDetail');

Route::get('/doctors/pakistan', 'LocationController@doctorsLocation');
Route::get('/hospitals-in-pakistan', 'LocationController@hospitalsLocation');
//Route::get('/doctors/{slug}', 'UserController@doctorsInCity');
Route::get('/hospitals/{slug}', 'UserController@hospitalsInCity');
Route::get('/diseases', 'DiseaseController@allDiseases');
Route::get('/services', 'ServiceController@allSpecialities');
Route::get('/find-a-doctor', 'ServiceController@getAllServices');

//location area speciality gender wise
Route::get('/{location}/{area}/{speciality}/{gender}', 'PublicController@getSearchResult')->name('loc-area-spec-gen');
Route::get('/{location}/{area}/{speciality}', 'PublicController@getSearchResult')->name('loc-area-spec');

//Route::get('/{role}/{location}/{area}', 'SpecialityController@getDataByArea');

Route::get('search-results', 'PublicController@getSearchResult')->name('searchResults');
Route::get('/{slug}-in-Pakistan', 'PublicController@getSearchResult')->name('speciality');
Route::get('/{slug}-in-{location}', 'PublicController@getSearchResult')->name('speciality-by-location');

/*End New Search Routes*/


Route::post('getChildLocations', 'LocationController@getChildLocations');
Route::post('booking', 'BookingController@index');


//Doctor Routes
Route::group(
    ['middleware' => ['role:doctor|admin']],
    function () {
        Route::get('doctor/packages', 'PackageController@index')->name('doctorPackages');
        Route::get('doctor/package-checkout/{id}', 'DoctorController@checkout')->name('doctorCheckout');
        // Route::get('doctor/dashboard', 'DoctorController@doctorDashboard')->name('doctorDashboard');
        Route::post('doctor/store-award-downloads', 'DoctorController@storeAwardDownloadSettings')->name('storeAwardDownloadSettings');
        
        Route::get('doctor/get-awards', 'DoctorController@getDoctorAwards')->name('getDoctorAwards');
        Route::get('doctor/get-awards/{id}', 'DoctorController@getUserDoctorAwards');
        Route::post('doctor/store/experiences', 'DoctorController@storeExperiences')->name('storeExperiences');
        Route::post('doctor/store/educations', 'DoctorController@storeEducations')->name('storeEducations');
    
        Route::get('doctor/get-experiences', 'UserController@getExperiences');
        Route::get('getexperiences/{id}', 'UserController@getUserExperiences');
        Route::get('doctor/get-educations', 'UserController@getEducations');
        Route::get('doctor/get-educations/{id}', 'UserController@getUserEducations');
        Route::get('appointment-settings', 'DoctorController@addLocation')->name('addAppointmentLocation');
        Route::get('appointment-detail/{id}', 'DoctorController@editLocation')->name('editLocation');
        Route::post('doctor/store/appointment-location', 'DoctorController@storeAppointmentLocation');
        Route::post('doctor/update/slots/{id}', 'DoctorController@updateSlots');
        Route::post('doctor/update-day-slots/{id}', 'DoctorController@storeSelectedDaySlots');
        Route::post('doctor/update-location-services/{id}', 'DoctorController@updateLocationServices');
        Route::post('doctor/delete-slots/{slot_id}/{day}/{id}', 'DoctorController@deleteSlots');
        Route::post('doctor/delete-all-slots/{day}/{id}', 'DoctorController@deleteAllSlots');
        Route::get('doctor/appointments', 'DoctorController@showAppointments')->name('doctorAppointments');;
        Route::post('doctor/get-appointments', 'DoctorController@getAppointments');
        Route::get('doctor/payout-settings', 'DoctorController@payoutSettings')->name('doctorPayoutsSettings');
        Route::get('doctor/payouts', 'DoctorController@getPayouts')->name('getDoctorPayouts');
        Route::post('doctor/accept-appointment', 'DoctorController@acceptAppointment');
        Route::post('doctor/decline-appointment', 'DoctorController@declineAppointment');
    }
);
Route::group(
    ['middleware' => ['role:admin|doctor|hospital|patient']],
    function () {
        Route::get('user/products/thankyou', 'UserController@thankyou');
        Route::post('user/store-registration-detail', 'UserController@storeRegistrationSettings')->name('storeRegistrationSettings');
        Route::post('user/store-user-registration-detail', 'UserController@updateRegistrationSettings')->name('updateRegistrationSettings');
        // Account Settings Routes
        Route::get('profile/settings/account-settings', 'UserController@accountSettings')->name('accountSettings');
        Route::get('profile/settings/reset-password', 'UserController@resetPassword')->name('resetPassword');
        Route::post('profile/settings/request-password', 'UserController@requestPassword');
        Route::get('profile/settings/email-notification-settings', 'UserController@emailNotificationSettings')->name('emailNotificationSettings');
        Route::post('profile/settings/save-email-settings', 'UserController@saveEmailNotificationSettings');
        Route::post('profile/settings/save-account-settings', 'UserController@saveAccountSettings');
        Route::get('profile/settings/delete-account', 'UserController@deleteAccount')->name('deleteAccount');
        Route::post('user/settings/delete-account', 'UserController@destroy');
        Route::get('profile/settings/get-user-searchable-settings', 'UserController@getUserSearchableSettings');
        Route::get('checkout/{id}', 'UserController@checkout')->name('checkout');
        Route::post('user/update-payout-detail', 'UserController@updatePayoutDetail');
        Route::get('user/get-payout-detail', 'UserController@getPayoutDetail');
        Route::get('{role_type}/profile-settings', 'UserController@userProfileSettings')->name('profileSettings');
        Route::post('{role_type}/store-personal-detail', 'UserController@storeUserProfileSettings')->name('storeUserProfileSettings');
        Route::post('{role_type}/store-gallery', 'UserController@storeUserGallery');
        Route::post('{role_type}/store-update-gallery', 'UserController@storeupdateUserGallery');


    }
);
Route::group(
    ['middleware' => ['role:admin|doctor']],
    function () {
        Route::get('create-article', 'ArticleController@createArticle')->name('createArticle');
        Route::get('edit-article/{slug}', 'ArticleController@editArticle')->name('editArticle');
        Route::post('get-stored-cats', 'ArticleController@getStoredCategories')->name('getAllCategories');
        Route::post('get-article-cats', 'ArticleController@getArticleCats');
        Route::post('post/article', 'ArticleController@postArticle')->name('postArticle');
        Route::post('update/article', 'ArticleController@updateArticle')->name('updateArticle');
        Route::post('delete/article', 'ArticleController@destroy')->name('deleteArticle');
        Route::post('get/featured-article', 'ArticleController@getFeaturedArticleSetting')->name('getFeaturedArticleSetting');
    }
);
Route::group(
    ['middleware' => ['role:doctor|patient|admin']],
    function () {
        Route::get('user/invoice', 'UserController@getUserInvoices')->name('userInvoice');
        Route::get('show/invoice/{id}', 'UserController@showInvoice')->name('showInvoice');
        Route::get('user/invoices', 'UserController@getUserInvoicess')->name('userInvoices');
    }
);
Route::group(
    ['middleware' => ['role:patient|admin']],
    function () {
        Route::get('patient/appointments/{id?}', 'PatientController@showAppointments')->name('userAppointments');
        Route::post('patient/get-appointments', 'PatientController@getAppointments');
    }
);
Route::group(
    ['middleware' => ['role:hospital|admin']],
    function () {
        Route::get('hospital/manage-team/{id?}', 'HospitalController@doctorListing')->name('manageTeams');
        Route::post('hospital/approve-user', 'HospitalController@approveUser')->name('approveUser');
        Route::post('hospital/reject-user', 'HospitalController@rejectUser')->name('rejectUser');
        Route::post('hospital/delete-user', 'HospitalController@deleteUser')->name('deleteUser');
    }
);
Route::fallback(
    function () {
        return View('errors.404 ');
    }
);
Route::post('submit-appointment', 'PublicController@submitAppointment');
Route::post('verify-appointment-password', 'PublicController@verifyAppointmentPassword');
Route::post('verify-appointment-code', 'PublicController@verifyAppointmentCode');
Route::post('doctor/get-hospital-services', 'DoctorController@getHospitalServices');
Route::get('paypal/redirect-url', 'PaypalController@getIndex');
Route::get('paypal/ec-checkout', 'PaypalController@getExpressCheckout');
Route::get('paypal/ec-checkout-success', 'PaypalController@getExpressCheckoutSuccess');
Route::get('addmoney/stripe', array('as' => 'addmoney.paywithstripe', 'uses' => 'StripeController@payWithStripe',));
Route::post('addmoney/stripe', array('as' => 'addmoney.stripe', 'uses' => 'StripeController@postPaymentWithStripe',));
Route::post('stripe/generate-order', 'StripeController@generateOrder');

Route::post('submit-feedback', 'PublicController@submitFeedack');
Route::post('message/send-private-message', 'MessageController@store');
Route::get('message-center', 'MessageController@index')->name('message');
Route::get('message-center/get-users', 'MessageController@getUsers');
Route::post('message-center/get-messages', 'MessageController@getUserMessages');
Route::post('message', 'MessageController@store')->name('message.store');
Route::get('get-user-specialities', 'UserController@getSpecialities');
Route::post('user/speciality_delete/{speciality_index}/{service_index?}', 'UserController@destroySpeciality');
Route::post('get-doctor-education', 'PublicController@getDoctorEducations')->name('getDoctorEducations');
Route::post('get-doctor-experience', 'PublicController@getDoctorExperiences')->name('getDoctorExperiences');
Route::post('store-appointment-data', 'PublicController@storeAppointmentInSession');
Route::get('health-forum', 'ForumController@index')->name('forumQuestions');
Route::get('health-forum/search-query', 'ForumController@index')->name('searchQueryFilter');
Route::get('health-forum/filter-questions', 'ForumController@index')->name('getFilteredQuestions');
Route::post('health-forum/post-question', 'ForumController@store')->name('storeForumQuestions');
Route::get('health-forum/{slug}', 'ForumController@getForumAnswers')->name('getForumAnswers');
Route::post('health-forum/post-answer', 'ForumController@postAnswer')->name('ForumAnswers');
Route::post('user/store/services', 'UserController@storeServices');
Route::post('user/store/updateservices', 'UserController@updatestoreServices');
Route::post('user/store/updatehospitalservices', 'UserController@updatestoreHospitalServices');
Route::post('user/store/updatefaqs', 'UserController@updatestoreFaqs');
Route::post('user/store/updateBankData', 'UserController@updateBankData');
Route::post('send/app-link', 'PublicController@sendDownloadAppEmail');
Route::post('register/login-register-user', 'PublicController@loginUser')->name('loginUser');
Route::post('register/verify-user-code', 'PublicController@verifyUserCode');
Route::post('register/form-step1-custom-errors', 'PublicController@RegisterStep1Validation');
Route::post('register/form-step2-custom-errors', 'PublicController@RegisterStep2Validation');


Route::get('profile/{slug}', 'PublicController@showProfile')->name('userProfile');
Route::get('{city}/{spec}/{slug}', 'PublicController@showProfile')->name('citySpecialtyUserProfile');
Route::get('hospitals/{location}/{slug}', 'PublicController@showProfile')->name('hospitalLocationProfile');
Route::get('get-specialities', 'SpecialityController@getSpecialities');
Route::post('get-speciality-service', 'SpecialityController@getSpecialityService');
Route::post('get-speciality-services', 'updatehospitalservices@getServices');

Route::get('search/get-hospitals', 'UserController@getHospitals');
Route::get('search/get-locations', 'UserController@getLocations');
Route::get('page/{slug}', 'PageController@show')->name('showPage');
Route::get('{role}/saved-items', 'UserController@getSavedItems')->name('getSavedItems');

Route::get('{role}/dashboard', 'UserController@getDashboard')->name('dashboard');
Route::post('appointment/status','UserController@approve');

Route::post('media/upload-temp-image/{type}/{file_name}/{img_type?}', 'MediaController@uploadTempImage');
Route::post('doctor/get-appointment-slots', 'DoctorController@getAppointmentSlots');
// attachments
Route::get('get/{type}/{id}/{attachment}', 'MediaController@getFile')->name('getfile');
 Route::get('doctor/get-awards', 'DoctorController@getUpdateDoctorAwards')->name('getUpdateDoctorAwards');
        Route::get('doctor/get-experiences', 'UserController@getExperiences');
        Route::get('doctor/get-educations', 'UserController@getEducations');



//get All Diseases
Route::get('getAllDiseases','DiseaseController@getAllDiseases');
//get All Doctors Hospitals
Route::get('getAllDoctors','UserController@getAllDoctors');
//get Speciality By User Id
Route::get('getSpecialityByUserId/{id}','SpecialityController@getSpecialityByUserId');
// get unserialize data
Route::post('unserialize', 'UserController@unserialize');
// get current user's saved items
Route::get('getCurrentUsersSaved', 'UserController@getCurrentUsersSaved');

Route::get('/search', function (Request $request) {
    return App\User::role('doctor')->search($request->search)->get();
});

Route::post('/feedbackCheck', 'FeedbackController@feedbackCheck');
Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/callback/{provider}', 'SocialController@callback');

/*Quick Registration*/
Route::post('/quick-registration', 'UserController@quickReg');
/*Phone Number Verification*/
Route::post('/phone-number-verification', 'UserController@phoneNumVer');
//resend verification code
Route::post('user/resend-code', 'CodeController@resendCode');
Route::post('user/appointmentbookingstatus', 'CodeController@appointmentBookedMessage');


Route::get('/check-login', 'UserController@checkLogin');
Route::get('/current-affair-show/{id}', 'UserController@datashow');
Route::get('/cosult-online', function () {
    return view('welcome');
});
Route::get('/all-hospital', function () {
    return view('welcome');
});


Route::get('/jazz', function () {
    return view('jazz');
});

Route::post('/testjazz', 'JazzController@index');



Route::get('/video', "VideoRoomsController@index");
Route::prefix('room')->middleware('auth')->group(function() {
    Route::get('join/{roomName}', 'VideoRoomsController@joinRoom');
    Route::post('create', 'VideoRoomsController@createRoom');
});

//csr booking route
Route::post('/callAppointmentBooking', 'AppointmentBookingController@callAppointmentBooking')->name('csrBookingAppointment');
Route::get('/online-appointment-booking', 'AppointmentBookingController@onlineAppointmentBooking')->name('csrOnlineBookingAppointment');
Route::get('/appointment-booking-system', 'UserController@appointmentBookingSystem');




// Add New Routes



Route::get('/online-doctor-consultation', function () {
    return view('front-end.pages.online_doctor_consultation');
});
Route::get('/online-doctor-consultation/dermatologist', function () {
    return view('front-end.pages.dermatologist');
});
Route::get('/doctors/pakistan', function () {
    return view('front-end.pages.doctors_pakistan');
});
Route::get('/dermatologist-Pakistan', function () {
    return view('front-end.pages.dermatologist');
});
Route::get('/bahria-town/dermatologiest', function () {
    return view('front-end.pages.bahria_town_dermatologist');
});

Route::get('/dermatologist/female', function () {
    return view('front-end.pages.dermatologist_female');
});
Route::get('/dermatologist/male', function () {
    return view('front-end.pages.dermatologist_male');
});
Route::get('/lahore/johar-town/dermatologist/female', function () {
    return view('front-end.pages.johar_town_dermatologist_female');
});

Route::get('/lahore/johar-town/dermatologist/male', function () {
    return view('front-end.pages.johar_town_dermatologist_male');
});
Route::get('/lahore/dermatologist/dr-umer-mushtaq/callcenter', function () {
    return view('front-end.pages.callcenter');
});
Route::get('/lahore/dermatologist/dr-umer-mushtaq/review-doctor', function () {
    return view('front-end.pages.review_doctor');
});
Route::get('/hospital/pakistan', function () {
    return view('front-end.pages.hospitals_pakistan');
});

Route::get('/hospitals-lahore-area-johar-town', function () {
    return view('front-end.pages.hospitals_lahore_johar_town');
});
Route::get('/hospitals/lahore/hameed-latif-hospital/dermatologist', function () {
    return view('front-end.pages.hameed_latif_hospital_dermatologist');
});



Route::get('/sitemap', function () {

    return view('front-end.sitemap.index');
});
Route::get('sitemap/diseases', 'SiteMapController@diseasesFunction');
Route::get('sitemap/specialities', 'SiteMapController@specialitiesFunction');
Route::get('sitemap/services', 'SiteMapController@servicesFunction');
Route::get('sitemap/doctors', 'SiteMapController@doctorsFunction');
Route::get('sitemap/hospitals', 'SiteMapController@hospitalsFunction');
Route::get('sitemap/symptoms', 'SiteMapController@symptomsFunction');

