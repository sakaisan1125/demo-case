<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Http\Responses\RegisterResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // この行を追加
        $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            \App\Http\Responses\RegisterResponse::class
        );
        //このコードは**「サービスコンテナへの登録（バインド）」**と呼ばれるLaravelの仕組みを使っています。
        //超簡単な日本語でまとめると…「新規登録が終わったときに使うレスポンスの中身は、“自分で作ったRegisterResponse”を使って！」「しかも1個だけ（シングルトン）を全体で使いまわしてね」
        //Laravel Fortifyは「登録後のリダイレクト先」を自分でコントロールしたい人向けにRegisterResponseContract という「決まり（契約）」を用意してる普通は /home にリダイレクト（デフォルト）自分でRegisterResponseクラスを作って /profile/edit へ変えたい場合は、このバインドで差し替え！
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
        return view('auth.login');
        });

        Fortify::registerView(function () {
        return view('auth.register');
        });
    }

    

    
}
