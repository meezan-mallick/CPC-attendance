<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// $routes->get('/', 'Home::index');
// $routes->get('/dashboard', 'Home::dashboard');
// $routes->get('/logout', 'Home::logout');
// $routes->match(['get', 'post'], '/f-login', 'Home::facultylogin');

//Authentication
$routes->get('/', 'AuthController::login'); // Redirect root to login
$routes->get('login', 'AuthController::login'); // Show login page
$routes->post('login', 'AuthController::attemptLogin'); // Handle login form submission
$routes->get('logout', 'AuthController::logout'); // Handle logout
$routes->get('dashboard', 'DashboardController::index'); // Dashboard page



$routes->get('faculties', 'FacultyController::index', ['filter' => 'auth:Superadmin']);
$routes->get('programs', 'ProgramController::index', ['filter' => 'auth:Superadmin,Coordinator']);
$routes->get('subjects', 'SubjectController::index', ['filter' => 'auth:Coordinator,Faculty']);


// Routes for Faculty Management (Superadmin Only)
$routes->get('users', 'UserController::index', ['filter' => 'auth']);
$routes->get('users/add', 'UserController::add', ['filter' => 'auth']);
$routes->post('users/store', 'UserController::store', ['filter' => 'auth']);
$routes->get('users/edit/(:num)', 'UserController::edit/$1', ['filter' => 'auth']);
$routes->post('users/update/(:num)', 'UserController::update/$1', ['filter' => 'auth']);
$routes->get('users/delete/(:num)', 'UserController::delete/$1', ['filter' => 'auth']);
$routes->get('users/export', 'UserController::exportUsers');
$routes->get('users/import', 'UserController::import');
$routes->post('users/import-store', 'UserController::importUsers');
$routes->get('users/download-sample', 'UserController::downloadSampleExcel', ['filter' => 'auth']); // Download Sample Excel (No Parameters)


//Routes for Assign Coordinatorship (Superadmin Only)
$routes->post('users/assign-coordinator/(:num)', 'UserController::assignCoordinator/$1', ['filter' => 'auth']);

//Routes for Subject Allotment (Coordinator Only)
$routes->get('subjectsallocation', 'SubjectController::Getassignsubjects', ['filter' => 'auth']);
$routes->get('subjectsallocation/assign', 'SubjectController::assign', ['filter' => 'auth']);
$routes->get('subjectsallocation/edit/(:num)', 'SubjectController::editAssignment/$1', ['filter' => 'auth']);
$routes->get('subjectsallocation/delete/(:num)', 'SubjectController::deleteAssignment/$1', ['filter' => 'auth']);
$routes->post('subjectsallocation/update/(:num)', 'SubjectController::updateAssignment/$1', ['filter' => 'auth']);
$routes->post('subjectsallocation/assignstore', 'SubjectController::storeAssignment', ['filter' => 'auth']);



# Routes for Programs
$routes->get('programs', 'ProgramController::index');
$routes->get('programs/add', 'ProgramController::add');
$routes->post('programs/store', 'ProgramController::store');
$routes->get('programs/edit/(:num)', 'ProgramController::edit/$1');
$routes->post('programs/update/(:num)', 'ProgramController::update/$1');
$routes->get('programs/delete/(:num)', 'ProgramController::delete/$1');


//Routes for Subjects
$routes->get('subjects', 'SubjectController::index');
$routes->get('subjects/add', 'SubjectController::add');
$routes->post('subjects/store', 'SubjectController::store');
$routes->get('subjects/edit/(:num)', 'SubjectController::edit/$1');
$routes->post('subjects/update/(:num)', 'SubjectController::update/$1');
$routes->get('subjects/delete/(:num)', 'SubjectController::delete/$1');
$routes->post('subjectsallocation/filter', 'SubjectController::filterAllocatedSubjects');



//Routes for Colleges
$routes->get('colleges', 'CollegeController::index');
$routes->get('colleges/add', 'CollegeController::add');
$routes->post('colleges/store', 'CollegeController::store');
$routes->get('colleges/edit/(:num)', 'CollegeController::edit/$1');
$routes->post('colleges/update/(:num)', 'CollegeController::update/$1');
$routes->get('colleges/delete/(:num)', 'CollegeController::delete/$1');


// Routes for coordinators
$routes->get('coordinators', 'CoordinatorController::list', ['filter' => 'auth']);
$routes->get('coordinators/assign', 'CoordinatorController::index', ['filter' => 'auth']);
$routes->post('coordinators/assign', 'CoordinatorController::assign', ['filter' => 'auth']);
$routes->get('coordinators/remove/(:num)/(:num)', 'CoordinatorController::removeAssignment/$1/$2', ['filter' => 'auth']);

// Routes  for Student Management
$routes->get('students', 'StudentController::index', ['filter' => 'auth']); // Course selection
$routes->get('students/list', 'StudentController::list', ['filter' => 'auth']); // Handles query parameters like ?course=1&semester=1&batch=1
$routes->get('students/download-sample', 'StudentController::downloadSampleExcel', ['filter' => 'auth']); // Download Sample Excel (No Parameters)
$routes->get('students/import', 'StudentController::import', ['filter' => 'auth']); // Import students view
$routes->post('students/import/(:num)/(:num)/(:num)', 'StudentController::processImport/$1/$2/$3', ['filter' => 'auth']); // Process student import
$routes->get('students/delete/(:num)', 'StudentController::delete/$1', ['filter' => 'auth']); // Delete a student
$routes->post('students/bulk-delete', 'StudentController::bulkDelete', ['filter' => 'auth']); // Bulk delete students
$routes->post('students/getSemesters', 'StudentController::getSemesters', ['filter' => 'auth']); // Get semesters dynamically based on course

$routes->get('students/add', 'StudentController::add', ['filter' => 'auth']); // Show Add Student Form
$routes->post('students/store', 'StudentController::store', ['filter' => 'auth']); // Store New Student

//time slots
$routes->get('/time-slots', 'TimeslotController::timeslots', ['filter' => 'auth']);
$routes->get('/time-slots/add', 'TimeslotController::add_timeslot', ['filter' => 'auth']);
$routes->post('/time-slots/store', 'TimeslotController::timeslot_store', ['filter' => 'auth']);
$routes->get('/time-slots/delete/(:num)', 'TimeslotController::delete_timeslot/$1', ['filter' => 'auth']);
$routes->get('/time-slots/edit/(:num)', 'TimeslotController::edit_timeslot/$1', ['filter' => 'auth']);
$routes->post('/time-slots/update/(:num)', 'TimeslotController::update_timeslotstore/$1', ['filter' => 'auth']);


// Student Attendance
$routes->get('/faculty-subjects', 'AttendanceController::allsubjects', ['filter' => 'auth']);
$routes->get('/topics-list/(:num)/(:num)/(:num)', 'AttendanceController::alltopics/$1/$2/$3/$4', ['filter' => 'auth'], ['filter' => 'auth']);
$routes->get('/topics-list/delete/(:num)/(:num)/(:num)/(:num)', 'AttendanceController::delete_topic/$1/$2/$3/$4', ['filter' => 'auth']);
$routes->get('/topics-list/edit/(:num)/(:num)/(:num)/(:num)', 'AttendanceController::edit_topic/$1/$2/$3/$4', ['filter' => 'auth']);
$routes->post('/topics-list/store/(:num)/(:num)/(:num)', 'AttendanceController::topic_store/$1/$2/$3/$4', ['filter' => 'auth']);
$routes->post('/topics-list/update/(:num)/(:num)/(:num)/(:num)', 'AttendanceController::update_topicstore/$1/$2/$3/$4', ['filter' => 'auth']);
$routes->get('attendance/export-topics/(:num)/(:num)/(:num)', 'AttendanceController::exportTopics/$1/$2/$3', ['filter' => 'auth']);


$routes->get('/attendance/(:num)/(:num)/(:num)/(:num)/(:num)', 'AttendanceController::allstudents/$1/$2/$3/$4/$5', ['filter' => 'auth']);
$routes->post('/attendance/store/(:num)/(:num)/(:num)/(:num)/(:num)', 'AttendanceController::attendance_store/$1/$2/$3/$4/$5', ['filter' => 'auth']);

// export
//attendance report
$routes->get('/attendance-report', 'ExportAttendanceController::get_allsubjects', ['filter' => 'auth']);
$routes->post('/attendance-report/export', 'ExportAttendanceController::export_attendance', ['filter' => 'auth']);


//payment voucher
$routes->get('/payment-voucher', 'ExportVoucherController::get_lectures', ['filter' => 'auth']);
$routes->get('/payment-voucher/export/(:num)/(:num)/(:num)/(:num)/(:segment)/(:segment)', 'ExportVoucherController::export_lec/$1/$2/$3/$4/$5/$6', ['filter' => 'auth']);
