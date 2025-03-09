<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = User::where("id",Auth::user()->id)->first();
        $request->validate([
            "name"=> "required",
            'email' => 'required',
        ]);
        if ($request -> hasFile('profile_image')){
            $imagepath = $request->file('profile_image') ? $request->file('profile_image')->store('profile-images', 'public') : null;
            if ($user -> image !== null){
                Storage::disk('public')->delete($user->image);
            }
        } else {
            $imagepath = $user -> image;
        }
        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->email = $request->email;
        $user->languages = $request->languages;
        $user->skills = $request->skills;
        $user->portfolio = $request->portfolio;
        $user->image = $imagepath;
        $user->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    // show user profile
    public function showUserProfile(User $user): View
    {
        $users = User::all();
        $connectedUser = Auth::user();
        $pandingRequests = $connectedUser->pendingRequests;
        $friends = $connectedUser->friendships;

        $followers = $connectedUser->followers;
        $following = $connectedUser->following;
        $connections = $followers->concat($following);
        // usrs they are not following and not followed by they they status are not panding

        $otherusers = $users -> whereNotIn('id', $connections->pluck('id'))->where('id', '!=', $connectedUser->id);

        return view('profile', [
            'user' => $user,
            'connections' => $connections,
            'pandingRequests' => $pandingRequests,
        ]);
    }
}
