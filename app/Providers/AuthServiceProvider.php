<?php

namespace App\Providers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Event;


// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Label;
use App\Models\Item;
use App\Models\Comment;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Event::class => EventPolicy::class,
        Game::class => GamePolicy::class,
        Team::class => TeamPolicy::class,
        // TODO: delete this
        Label::class => LabelPolicy::class,
        Item::class => ItemPolicy::class,
        Comment::class => CommentPolicy::class,
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
