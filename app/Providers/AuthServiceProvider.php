<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Analytics;
use App\Models\Employee;
use App\Models\Favorate;
use App\Models\ManagerInvitation;
use App\Models\Menu;
use App\Models\Notification;
use App\Models\Place;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Survey_answer;
use App\Models\Survey_question;
use App\Models\Table;
use App\Models\User;
use App\Policies\AnalyticsPolicy;

use App\Policies\EmployeePolicy;
use App\Policies\FavoratePolicy;
use App\Policies\ManagerInvitationPolicy;
use App\Policies\MenuPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\PlacePolicy;
use App\Policies\ReservationPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\SurveyPolicy;
use App\Policies\TablePolicy;
use App\Policies\UserPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Analytics::class => AnalyticsPolicy::class,
        Menu::class => MenuPolicy::class,
        Notification::class => NotificationPolicy::class,
        Place::class => PlacePolicy::class,
        Reservation::class => ReservationPolicy::class,
        Review::class => ReviewPolicy::class,
        Survey_answer::class => SurveyPolicy::class,
        Survey_question::class => SurveyPolicy::class,
        Table::class => TablePolicy::class,
        User::class => UserPolicy::class,
        Employee::class => EmployeePolicy::class,
        ManagerInvitation::class => ManagerInvitationPolicy::class,


    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
        
    }
}
