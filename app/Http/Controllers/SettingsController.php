<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Validator;
use Storage;
use Image;

class SettingsController extends Controller
{

    public function index()
    {
        return view('dashboard.settings');
    }

    public function updateAvatar(Request $request)
    {

        /**
         * Validate Request
         */
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|file|image',
        ]);

        /**
         * If validation fails, go back
         */
        if($validator->fails()){

            return redirect()->route('settings')->withError($validator->errors()->first('avatar'));

        }

        /**
         * Create square avatar in jpg format
         */
        $avatar = Image::make($request->file('avatar'))->fit(500)->encode('jpg', 90);

        /**
         * File path
         *
         * Create md5 random name from the image source for the file name
         */
        $file_path = 'users/'.md5((string) $avatar).'.jpg';

        /**
         * Store avatar
         */
        Storage::disk('public')->put($file_path, $avatar);

        /**
         * Update user
         */
        $user = auth()->user();
        $user->avatar = $file_path;
        $user->save();

        /**
         * Go back
         */
        return redirect()->route('settings')->withStatus('Your avatar has been saved');

    }

    public function updateUser(Request $request)
    {

        /**
         * Validate Request
         */
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore(auth()->id())],
            'phone' => 'required',
        ]);

        /**
         * Update user
         */
        $user = auth()->user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        /**
         * Go back
         */
        return redirect()->route('settings')->withStatus('Your account settings have been saved');

    }

    public function updatePassword(Request $request)
    {

        /**
         * Validate Request
         */
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        /**
         * Update user
         */
        $user = auth()->user();
        $user->password = bcrypt($request->password);
        $user->save();

        /**
         * Go back
         */
        return redirect()->route('settings')->withStatus('Your password has been saved');

    }
}
