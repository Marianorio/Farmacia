<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Permisos para Titular
        Gate::define('ver-admin', function ($user) {
            return $user->hasRole('Titular');
        });

        // Permisos para Titular y Adjunto
        Gate::define('ver-reportes', function ($user) {
            return $user->hasAnyRole(['Titular', 'Adjunto']);
        });

        Gate::define('ver-recetas', function ($user) {
            return $user->hasAnyRole(['Titular', 'Adjunto']);
        });

        Gate::define('ver-obras-sociales', function ($user) {
            return $user->hasAnyRole(['Titular', 'Adjunto']);
        });

        // Permisos para Titular, Adjunto y Técnico
        Gate::define('ver-proveedores', function ($user) {
            return $user->hasAnyRole(['Titular', 'Adjunto', 'Tecnico']);
        });

        Gate::define('gestionar-productos', function ($user) {
            return $user->hasAnyRole(['Titular', 'Adjunto', 'Tecnico']);
        });
    }
}