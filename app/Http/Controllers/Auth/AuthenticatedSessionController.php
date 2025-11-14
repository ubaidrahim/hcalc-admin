<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::find(auth()->user()->id);
            if($user->status == 0){
                Auth::guard('web')->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();
                if($request->ajax()){
                    return response()->json(['status' => 0, 'message' => 'Your account is deactivated. Please contact the administrator.']);
                }
                return redirect('/login');
            }
            $user->last_login = Carbon::now();
            $user->save();
            if($request->ajax()){
                return response()->json(['status' => 1, 'goto' => session()->pull('url.intended', route('dashboard'))]);
                // return response()->json(['status' => 1, 'goto' => route('dashboard')]);
            }
            return redirect()->intended('/'); // Redirect to the intended route
        }

        return response()->json(['status' => 0, 'message' => 'Invalid credentials.']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        if($request->ajax()){
            return response()->json(['status' => 1, 'goto' => route('login')]);
        }

        return redirect('/login');
    }
}
