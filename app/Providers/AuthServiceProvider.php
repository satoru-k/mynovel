<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\User;
use App\Policies\UserPolicy;
use App\Profile;
use App\Policies\ProfilePolicy;
use App\Novel;
use App\Policies\NovelPolicy;
use App\Story;
use App\Policies\StoryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Profile::class => ProfilePolicy::class,
        Novel::class => NovelPolicy::class,
        Story::class => StoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
