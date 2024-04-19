<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite; // Sửa đường dẫn namespace
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index(){
        return view('user.login'); // Sửa tên view
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle(){
        if (!request()->has('code')) {
            return redirect('auth/google')->withErrors('Authorization request missing necessary code.');
        }
        try{
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id',$google_user->getId())->first();
            if(!$user){
                $new_user = User::create([
                    'name'=>$google_user->getName(),
                    'email'=>$google_user->getEmail(),
                    'google_id'=>$google_user->getId(),

                ]);
                Auth::login($new_user);
                if (session('redirect_to_payment')) {
                    session()->forget('redirect_to_payment');  // Xóa session đã dùng
                    return redirect()->route('payment');  // Chuyển hướng đến thanh toán
                }
                return redirect()->intended('/');
            }
            else{
                Auth::login($user);
                if (session('redirect_to_payment')) {
                    session()->forget('redirect_to_payment');  // Xóa session đã dùng
                    return redirect()->route('payment');  // Chuyển hướng đến thanh toán
                }
                return redirect()->intended('/');
            }
        } catch(\Throwable $e){
            dd($e);
            Log::error('Google Auth Error:', ['error' => $e->getMessage()]);
            return redirect('auth/google')->withErrors('Authentication failed.');
        }
    }
    // public function redirectFacebook()
    // {
    //     return Socialite::driver('facebook')->redirect();
    // }

    // public function callbackFacebook(){
    //     Log::info('Facebook Auth Code:', ['code' => request()->code]);
    //     try{
    //         $facebook_user = Socialite::driver('facebook')->user();
    //         $user = User::where('facebook_id',$facebook_user->getId())->first();
    //         if(!$user){
    //             $new_user = User::create([
    //                 'name'=>$facebook_user->getName(),
    //                 'email'=>$facebook_user->getEmail(),
    //                 'facebook_id'=>$facebook_user->getId(),

    //             ]);
    //             Auth::login($new_user);
    //             return redirect()->intended('/');
    //         }
    //         else{
    //             Auth::login($user);
    //             return redirect()->intended('/');
    //         }
    //     } catch(\Throwable $e){
    //         Log::error('Facebook Auth Error:', ['error' => $e->getMessage()]);
    //         return redirect('auth/facebook')->withErrors('Authentication failed.');
    //     }
    // }
    public function logout(Request $request){
        $request->session()->invalidate();
        Auth::logout();
        return redirect('/'); 
    }
}
