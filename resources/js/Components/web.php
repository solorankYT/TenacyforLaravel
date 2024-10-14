<?php
//User Management
use App\Http\Controllers\Admin\UserManagement\UserSecurityController as UserSecurityController;
use App\Http\Controllers\Admin\UserManagement\UsersController as UsersController;
use App\Http\Controllers\Admin\UserManagement\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserManagement\RolesController as AdminRolesController;
use App\Http\Controllers\Admin\UserManagement\PermissionsController as AdminPermissionsController;

//Academic Structure
use App\Http\Controllers\Admin\AcademicStructure\InstitutionController as AdminInstitutionController;
use App\Http\Controllers\Admin\AcademicStructure\CampusController as AdminCampusController;
use App\Http\Controllers\Admin\AcademicStructure\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\AcademicStructure\CollegeController as AdminCollegeController;
use App\Http\Controllers\Admin\AcademicStructure\AcademicCareerController as AdminAcademicCareerController;
use App\Http\Controllers\Admin\AcademicStructure\AcademicProgramController as AdminAcademicProgramController;
use App\Http\Controllers\Admin\AcademicStructure\AcademicPlanController as AdminAcademicPlanController;
use App\Http\Controllers\Admin\AcademicStructure\AcademicSubplanController as AdminSubplanController;
use App\Http\Controllers\Admin\AcademicStructure\AcademicSubjectController as AdminSubjectController;
use App\Http\Controllers\Admin\AcademicStructure\DegreeController as AdminDegreeController;
use App\Http\Controllers\Admin\AcademicStructure\GradeSchemeController as AdminGradeSchemeController;
use App\Http\Controllers\Admin\AcademicStructure\GradeBasisController as AdminGradeBasisController;
use App\Http\Controllers\Admin\AcademicStructure\GradeController as AdminGradeController;
use App\Http\Controllers\Admin\AcademicStructure\LvlLdRulesController as AdminLevelLoadRuleController;
use App\Http\Controllers\Admin\AcademicStructure\AcadLoadController;
use App\Http\Controllers\Admin\AcademicStructure\AcademicLevelController;

//TermSession

//Faculty 
use App\Http\Controllers\Student\StudentController;

//Student
use App\Http\Controllers\Faculty\FacultyController;

//Course Catalog

//Schedule of Classes

//Student Program Plan

//Term Activate

//Enrollment

//Etc
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Routes
Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('Contact', [
        'layout' => 'GuestLayout', 
    ]);
})->name('contact');

Route::get('/academicCalendars', function () {
    return Inertia::render('AcademicCalendars');
})->name('academicCalendars');

Route::get('/registrationBulletin', function () {
    return Inertia::render('RegistrationBulletin');
})->name('registrationBulletin');

Route::get('/orientationVideos', function () {
    return Inertia::render('OrientationVideos');
})->name('orientationVideos');

Route::get('/announcements', function () {
    return Inertia::render('Announcements');
})->name('announcements');
// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/api/user/roles', [UserRoleController::class, 'getUserRoles']);
    Route::get('/api/user/fullname', [UserRoleController::class, 'getFullName']);
    Route::get('/profile', [UserRoleController::class, 'profile'])->name('auth.profile');

    // Dashboard Route
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard'); 

});



// Admin Routes/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    // User Management Routes
    Route::prefix('usermanagement')->group(function () {
        //Users
        Route::get('/users', [UsersController::class, 'index'])->name('admin.usermanagement.users.index');
        Route::get('/users/create', [UsersController::class, 'create'])->name('admin.usermanagement.users.create');
        Route::post('/users', [UsersController::class, 'store'])->name('admin.usermanagement.users.store');
        Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('admin.usermanagement.users.edit');
        Route::put('/users/{id}', [UsersController::class, 'update'])->name('admin.usermanagement.users.update');
        Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('admin.usermanagement.users.destroy');

        // Profiles
        Route::get('/profiles', [AdminProfileController::class, 'index'])->name('admin.usermanagement.profiles.index');
        Route::get('/profiles/create', [AdminProfileController::class, 'create'])->name('admin.usermanagement.profiles.create');
        Route::post('/profiles', [AdminProfileController::class, 'store'])->name('admin.usermanagement.profiles.store');
        Route::get('/profiles/{id}/edit', [AdminProfileController::class, 'edit'])->name('admin.usermanagement.profiles.edit');
        Route::put('/profiles/{id}', [AdminProfileController::class, 'update'])->name('admin.usermanagement.profiles.update');
        Route::delete('/profiles/{id}', [AdminProfileController::class, 'destroy'])->name('admin.usermanagement.profiles.destroy');
        Route::post('/profiles/check', [AdminProfileController::class, 'check'])->name('admin.usermanagement.profiles.check');
        // Route::get('/profile', [AdminProfileController::class, 'profile'])->name('admin.usermanagement.profiles.profle');
        // Roles
        Route::get('/roles', [AdminRolesController::class, 'index'])->name('admin.usermanagement.roles.index');
        Route::get('/roles/create', [AdminRolesController::class, 'create'])->name('admin.usermanagement.roles.create');
        Route::post('/roles', [AdminRolesController::class, 'store'])->name('admin.usermanagement.roles.store');
        Route::get('/roles/{role}/edit', [AdminRolesController::class, 'edit'])->name('admin.usermanagement.roles.edit');
        Route::put('/roles/{role}', [AdminRolesController::class, 'update'])->name('admin.usermanagement.roles.update');
        Route::delete('/roles/{role}', [AdminRolesController::class, 'destroy'])->name('admin.usermanagement.roles.destroy');

        // Permissions
        Route::get('/permissions', [AdminPermissionsController::class, 'index'])->name('admin.usermanagement.permissions.index');
        Route::get('/permissions/create', [AdminPermissionsController::class, 'create'])->name('admin.usermanagement.permissions.create');
        Route::post('/permissions', [AdminPermissionsController::class, 'store'])->name('admin.usermanagement.permissions.store');
        Route::get('/permissions/{permission}/edit', [AdminPermissionsController::class, 'edit'])->name('admin.usermanagement.permissions.edit');
        Route::put('/permissions/{permission}', [AdminPermissionsController::class, 'update'])->name('admin.usermanagement.permissions.update');
        Route::delete('/permissions/{permission}', [AdminPermissionsController::class, 'destroy'])->name('admin.usermanagement.permissions.destroy');
    
    });

    // Academic Structure Routes
    Route::prefix('academicstructure')->group(function () {
        // Institution
        Route::get('/institution', [AdminInstitutionController::class, 'index'])->name('admin.academicstructure.institution.index');
        Route::get('/institution/create', [AdminInstitutionController::class, 'create'])->name('admin.academicstructure.institution.create');
        Route::post('/institution', [AdminInstitutionController::class, 'store'])->name('admin.academicstructure.institution.store');
        Route::get('/institution/{institution}/edit', [AdminInstitutionController::class, 'edit'])->name('admin.academicstructure.institution.edit');
        Route::put('/institution/{institution}', [AdminInstitutionController::class, 'update'])->name('admin.academicstructure.institution.update');
        Route::delete('/institution/{institution}/{effdt}', [AdminInstitutionController::class, 'destroy'])->name('admin.academicstructure.institution.destroy');
    
        // Campus
        Route::get('/campus', [AdminCampusController::class, 'index'])->name('admin.academicstructure.campus.index');
        Route::get('/campus/create', [AdminCampusController::class, 'create'])->name('admin.academicstructure.campus.create');
        Route::post('/campus', [AdminCampusController::class, 'store'])->name('admin.academicstructure.campus.store');
        Route::get('/campus/{institution}/{campus}/{effdt}/edit', [AdminCampusController::class, 'edit'])->name('admin.academicstructure.campus.edit');
        Route::put('/campus/{institution}/{campus}/{effdt}', [AdminCampusController::class, 'update'])->name('admin.academicstructure.campus.update');
        Route::delete('/campus/{institution}/{campus}/{effdt}', [AdminCampusController::class, 'destroy'])->name('admin.academicstructure.campus.destroy');

        // Department
        Route::get('/department', [AdminDepartmentController::class, 'index'])->name('admin.academicstructure.department.index');
        Route::get('/department/create', [AdminDepartmentController::class, 'create'])->name('admin.academicstructure.department.create');
        Route::post('/department', [AdminDepartmentController::class, 'store'])->name('admin.academicstructure.department.store');
        Route::get('/department/{department}/{effdt}/{eff_status}/edit', [AdminDepartmentController::class, 'edit'])->name('admin.academicstructure.department.edit');
        Route::put('/department/{department}/{effdt}/{eff_status}', [AdminDepartmentController::class, 'update'])->name('admin.academicstructure.department.update');
        Route::delete('/department/{department}/{effdt}/{eff_status}', [AdminDepartmentController::class, 'destroy'])->name('admin.academicstructure.department.destroy');
        
        // College
        Route::get('/college', [AdminCollegeController::class, 'index'])->name('admin.academicstructure.college.index');
        Route::get('/college/create', [AdminCollegeController::class, 'create'])->name('admin.academicstructure.college.create');
        Route::post('/college', [AdminCollegeController::class, 'store'])->name('admin.academicstructure.college.store');
        Route::get('/college/{institution}/{college}/{effdt}/edit', [AdminCollegeController::class, 'edit'])->name('admin.academicstructure.college.edit');
        Route::put('/college/{institution}/{college}/{effdt}', [AdminCollegeController::class, 'update'])->name('admin.academicstructure.college.update');
        Route::delete('/college/{institution}/{college}/{effdt}', [AdminCollegeController::class, 'destroy'])->name('admin.academicstructure.college.destroy');

        // Academic Career
        Route::get('/academiccareer', [AdminAcademicCareerController::class, 'index'])->name('admin.academicstructure.academiccareer.index');
        Route::get('/academiccareer/create', [AdminAcademicCareerController::class, 'create'])->name('admin.academicstructure.academiccareer.create');
        Route::post('/academiccareer', [AdminAcademicCareerController::class, 'store'])->name('admin.academicstructure.academiccareer.store');
        Route::get('/academiccareer/{institution}/{acad_career}/{effdt}/edit', [AdminAcademicCareerController::class, 'edit'])->name('admin.academicstructure.academiccareer.edit');
        Route::put('/academiccareer/{institution}/{acad_career}/{effdt}', [AdminAcademicCareerController::class, 'update'])->name('admin.academicstructure.academiccareer.update');
        Route::delete('/academiccareer/{institution}/{acad_career}/{effdt}', [AdminAcademicCareerController::class, 'destroy'])->name('admin.academicstructure.academiccareer.destroy');
    
        // Academic Program
        Route::get('/academicprogram', [AdminAcademicProgramController::class, 'index'])->name('admin.academicstructure.academicprogram.index');
        Route::get('/academicprogram/create', [AdminAcademicProgramController::class, 'create'])->name('admin.academicstructure.academicprogram.create');
        Route::post('/academicprogram', [AdminAcademicProgramController::class, 'store'])->name('admin.academicstructure.academicprogram.store');
        Route::get('/academicprogram/{institution}/{program}/{effdt}/edit', [AdminAcademicProgramController::class, 'edit'])->name('admin.academicstructure.academicprogram.edit');
        Route::put('/academicprogram/{institution}/{program}/{effdt}', [AdminAcademicProgramController::class, 'update'])->name('admin.academicstructure.academicprogram.update');
        Route::delete('/academicprogram/{institution}/{program}/{effdt}', [AdminAcademicProgramController::class, 'destroy'])->name('admin.academicstructure.academicprogram.destroy');

        // Academic Plan
        Route::get('/academicplan', [AdminAcademicPlanController::class, 'index'])->name('admin.academicstructure.academicplan.index');
        Route::get('/academicplan/create', [AdminAcademicPlanController::class, 'create'])->name('admin.academicstructure.academicplan.create');
        Route::post('/academicplan', [AdminAcademicPlanController::class, 'store'])->name('admin.academicstructure.academicplan.store');
        Route::get('/academicplan/{institution}/{acad_plan}/{effdt}/edit', [AdminAcademicPlanController::class, 'edit'])->name('admin.academicstructure.academicplan.edit');
        Route::put('/academicplan/{institution}/{acad_plan}/{effdt}', [AdminAcademicPlanController::class, 'update'])->name('admin.academicstructure.academicplan.update');
        Route::delete('/academicplan/{institution}/{acad_plan}/{effdt}', [AdminAcademicPlanController::class, 'destroy'])->name('admin.academicstructure.academicplan.destroy');

        // Academic Subplan
        Route::get('/academicsubplan', [AdminSubplanController::class, 'index'])->name('admin.academicstructure.academicsubplan.index');
        Route::get('/academicsubplan/create', [AdminSubplanController::class, 'create'])->name('admin.academicstructure.academicsubplan.create');
        Route::post('/academicsubplan', [AdminSubplanController::class, 'store'])->name('admin.academicstructure.academicsubplan.store');
        Route::get('/academicsubplan/{institution}/{program}/{subplan}/{effdt}/edit', [AdminSubplanController::class, 'edit'])->name('admin.academicstructure.academicsubplan.edit');
        Route::put('/academicsubplan/{institution}/{program}/{subplan}/{effdt}', [AdminSubplanController::class, 'update'])->name('admin.academicstructure.academicsubplan.update');
        Route::delete('/academicsubplan/{institution}/{program}/{subplan}/{effdt}', [AdminSubplanController::class, 'destroy'])->name('admin.academicstructure.academicsubplan.destroy');

        // Subject
        Route::get('/subject', [AdminSubjectController::class, 'index'])->name('admin.academicstructure.subject.index');
        Route::get('/subject/create', [AdminSubjectController::class, 'create'])->name('admin.academicstructure.subject.create');
        Route::post('/subject', [AdminSubjectController::class, 'store'])->name('admin.academicstructure.subject.store');
        Route::get('/subject/{institution}/{subject}/{effdt}/edit', [AdminSubjectController::class, 'edit'])->name('admin.academicstructure.subject.edit');
        Route::put('/subject/{institution}/{subject}/{effdt}', [AdminSubjectController::class, 'update'])->name('admin.academicstructure.subject.update');
        Route::delete('/subject/{institution}/{subject}/{effdt}', [AdminSubjectController::class, 'destroy'])->name('admin.academicstructure.subject.destroy');

        //Degree
        Route::get('/degree', [AdminDegreeController::class, 'index'])->name('admin.academicstructure.degree.index');
        Route::get('/degree/create', [AdminDegreeController::class, 'create'])->name('admin.academicstructure.degree.create');
        Route::post('/degree', [AdminDegreeController::class, 'store'])->name('admin.academicstructure.degree.store');
        Route::get('/degree/{degree}/{effdt}/edit', [AdminDegreeController::class, 'edit'])->name('admin.academicstructure.degree.edit');
        Route::put('/degree/{degree}/{effdt}', [AdminDegreeController::class, 'update'])->name('admin.academicstructure.degree.update');
        Route::delete('/degree/{degree}/{effdt}', [AdminDegreeController::class, 'destroy'])->name('admin.academicstructure.degree.destroy');

        // GradeScheme
        Route::get('/gradescheme', [AdminGradeSchemeController::class, 'index'])->name('admin.academicstructure.gradescheme.index');
        Route::get('/gradescheme/create', [AdminGradeSchemeController::class, 'create'])->name('admin.academicstructure.gradescheme.create');
        Route::post('/gradescheme', [AdminGradeSchemeController::class, 'store'])->name('admin.academicstructure.gradescheme.store');
        Route::get('/gradescheme/{setid}/{grading_scheme}/{effdt}/edit', [AdminGradeSchemeController::class, 'edit'])->name('admin.academicstructure.gradescheme.edit');
        Route::put('/gradescheme/{setid}/{grading_scheme}/{effdt}', [AdminGradeSchemeController::class, 'update'])->name('admin.academicstructure.gradescheme.update');
        Route::delete('/gradescheme/{setid}/{grading_scheme}/{effdt}', [AdminGradeSchemeController::class, 'destroy'])->name('admin.academicstructure.gradescheme.destroy');

        // GradeBasis
        Route::get('/gradebasis', [AdminGradeBasisController::class, 'index'])->name('admin.academicstructure.gradebasis.index');
        Route::get('/gradebasis/create', [AdminGradeBasisController::class, 'create'])->name('admin.academicstructure.gradebasis.create');
        Route::post('/gradebasis', [AdminGradeBasisController::class, 'store'])->name('admin.academicstructure.gradebasis.store');
        Route::get('/gradebasis/{setid}/{grading_scheme}/{effdt}/{grading_basis}/edit', [AdminGradeBasisController::class, 'edit'])->name('admin.academicstructure.gradebasis.edit');
        Route::put('/gradebasis/{setid}/{grading_scheme}/{effdt}/{grading_basis}', [AdminGradeBasisController::class, 'update'])->name('admin.academicstructure.gradebasis.update');
        Route::delete('/gradebasis/{setid}/{grading_scheme}/{effdt}/{grading_basis}', [AdminGradeBasisController::class, 'destroy'])->name('admin.academicstructure.gradebasis.destroy');

        // Grade
        Route::get('/grade', [AdminGradeController::class, 'index'])->name('admin.academicstructure.grade.index');
        Route::get('/grade/create', [AdminGradeController::class, 'create'])->name('admin.academicstructure.grade.create');
        Route::post('/grade', [AdminGradeController::class, 'store'])->name('admin.academicstructure.grade.store');
        Route::get('/grade/{setid}/{grading_scheme}/{effdt}/{grading_basis}/{crse_grade_input}/edit', [AdminGradeController::class, 'edit'])->name('admin.academicstructure.grade.edit');
        Route::put('/grade/{setid}/{grading_scheme}/{effdt}/{grading_basis}/{crse_grade_input}', [AdminGradeController::class, 'update'])->name('admin.academicstructure.grade.update');
        Route::delete('/grade/{setid}/{grading_scheme}/{effdt}/{grading_basis}/{crse_grade_input}', [AdminGradeController::class, 'destroy'])->name('admin.academicstructure.grade.destroy');
    
        // Level Load Rules
        Route::get('/levelloadrules', [AdminLevelLoadRuleController::class, 'index'])->name('admin.academicstructure.levelloadrules.index');
        Route::get('/levelloadrules/create', [AdminLevelLoadRuleController::class, 'create'])->name('admin.academicstructure.levelloadrules.create');
        Route::post('/levelloadrules', [AdminLevelLoadRuleController::class, 'store'])->name('admin.academicstructure.levelloadrules.store');
        Route::get('/levelloadrules/{institution}/{level_load_rule}/{effdt}/edit', [AdminLevelLoadRuleController::class, 'edit'])->name('admin.academicstructure.levelloadrules.edit');
        Route::put('/levelloadrules/{institution}/{level_load_rule}/{effdt}', [AdminLevelLoadRuleController::class, 'update'])->name('admin.academicstructure.levelloadrules.update');
        Route::delete('/levelloadrules/{institution}/{level_load_rule}/{effdt}', [AdminLevelLoadRuleController::class, 'destroy'])->name('admin.academicstructure.levelloadrules.destroy');

        // Academic Level Routes
        Route::get('/academiclevel', [AcademicLevelController::class, 'index'])->name('admin.academicstructure.academiclevel.index');
        Route::get('/academiclevel/create', [AcademicLevelController::class, 'create'])->name('admin.academicstructure.academiclevel.create');
        Route::post('/academiclevel', [AcademicLevelController::class, 'store'])->name('admin.academicstructure.academiclevel.store');
        Route::get('/academiclevel/{level_load_rule}/{academic_level}/{effdt}/edit', [AcademicLevelController::class, 'edit'])->name('admin.academicstructure.academiclevel.edit');
        Route::put('/academiclevel/{level_load_rule}/{academic_level}/{effdt}', [AcademicLevelController::class, 'update'])->name('admin.academicstructure.academiclevel.update');
        Route::delete('/academiclevel/{level_load_rule}/{academic_level}/{effdt}', [AcademicLevelController::class, 'destroy'])->name('admin.academicstructure.academiclevel.destroy');

        // Academic Load
        Route::get('/academicload', [AcadLoadController::class, 'index'])->name('admin.academicstructure.academicload.index');
        Route::get('/academicload/create', [AcadLoadController::class, 'create'])->name('admin.academicstructure.academicload.create');
        Route::post('/academicload', [AcadLoadController::class, 'store'])->name('admin.academicstructure.academicload.store');
        Route::get('/academicload/{institution}/{level_load_rule}/{effdt}/{term_category}/{session_code}/{unt_trm_total}/{academic_load}/edit', [AcadLoadController::class, 'edit'])->name('admin.academicstructure.academicload.edit');
        Route::put('/academicload/{institution}/{level_load_rule}/{effdt}/{term_category}/{session_code}/{unt_trm_total}/{academic_load}', [AcadLoadController::class, 'update'])->name('admin.academicstructure.academicload.update');
        Route::delete('/academicload/{institution}/{level_load_rule}/{effdt}/{term_category}/{session_code}/{unt_trm_total}/{academic_load}', [AcadLoadController::class, 'destroy'])->name('admin.academicstructure.academicload.destroy');
    });


    // Term Session Routes
    Route::prefix('termsession')->group(function (){

    });
});

// Student 
Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');

});


// Faculty Routes
Route::prefix('faculty')->middleware(['auth', 'role:faculty'])->group(function () {
    Route::get('/dashboard', [FacultyController::class, 'index'])->name('faculty.dashboard');

});

// Curriculum Management Routes
Route::prefix('curriculummanagement')->group(function () {

    Route::get('/coursecatalog', function () {
        return Inertia::render('CurriculumManagement/CourseCatalog');
    })->name('curriculummanagement.coursecatalog');
    //Course Catalog Routes
    Route::prefix('coursecatalog')->group(function () {

    });

    //Schedule of Classes Routes
    Route::prefix('scheduleofclasses')->group(function () {

    });

});

//Records and Enrollment Routes
Route::prefix('recordsandenrollment')->group(function () {

    //Student Program Plan Routes
    Route::prefix('studentprogramplan')->group(function () {

    });

    //Term Activate Routes
    Route::prefix('termactivate')->group(function () {

    });

    //Enrollment Routes
    Route::prefix('enrollment')->group(function () {

    });
});
require __DIR__.'/auth.php';