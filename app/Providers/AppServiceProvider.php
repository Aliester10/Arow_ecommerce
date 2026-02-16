<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $perusahaan = \App\Models\Perusahaan::first();
            $categories = \App\Models\Kategori::with('subkategori.subSubkategori')->get();
            $layoutFooterLinks = \App\Models\FooterLink::orderBy('column_title')->orderBy('order')->get()->groupBy('column_title');

            $view->with('perusahaan', $perusahaan);
            $view->with('categories', $categories);
            $view->with('layoutFooterLinks', $layoutFooterLinks);

            if (\Illuminate\Support\Facades\Auth::check()) {
                $user = \Illuminate\Support\Facades\Auth::user();
                $wishlistCount = \App\Models\Wishlist::where('id_user', $user->id_user)->count();
                $cartCount = \App\Models\Cart::where('id_user', $user->id_user)
                    ->where('status', 'active')
                    ->withCount('details')
                    ->get()
                    ->sum('details_count');

                $view->with('wishlistCount', $wishlistCount);
                $view->with('cartCount', $cartCount);
            } else {
                $view->with('wishlistCount', 0);
                $view->with('cartCount', 0);
            }
        });
    }
}
