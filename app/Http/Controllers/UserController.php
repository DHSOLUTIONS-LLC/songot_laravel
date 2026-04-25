<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id()
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6'
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true]);
    }

    public function deleteAccount()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->delete();

        Auth::logout();

        return response()->json(['success' => true]);
    }
}