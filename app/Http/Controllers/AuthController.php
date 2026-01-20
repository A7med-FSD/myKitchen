<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // TODO: Implement actual authentication logic
        // For now, just return success
        
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'redirect' => '/menu'
        ]);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        // TODO: Implement logout logic
        
        return redirect('/login');
    }

    /**
     * Show the registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'map_link' => 'nullable|url',
            'profile_image' => 'nullable|image|max:2048'
        ]);

        // TODO: Implement actual user creation logic
        // For now, just return success
        
        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'redirect' => '/login'
        ]);
    }

    /**
     * Show the admin login form
     */
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    /**
     * Handle admin login request
     */
    public function adminLogin(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // TODO: Implement actual admin authentication logic
        // For now, just return success
        
        return response()->json([
            'success' => true,
            'message' => 'Admin login successful',
            'redirect' => '/owner'
        ]);
    }
}
