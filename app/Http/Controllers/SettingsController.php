<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \DateTime;

use Validator;
use Storage;
use Image;

class SettingsController extends Controller
{

    public function index()
    {
        /**
         * Get Account Manager
         */
        $account_manager = auth()->user()->account_manager;

        return view('dashboard.settings', [
            'account_manager' => $account_manager,
        ]);
    }

    public function updateAvatar(Request $request)
    {

        /**
         * Validate Request
         */
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // print_r($validator->errors()); die();

        /**
         * If validation fails, go back
         */
        if ($validator->fails()) {

            return redirect()->route('settings')->withError($validator->errors()->first('avatar'));
        }

        /**
         * Create square avatar in jpg format
         */

        /**
         * File path
         *
         * Create md5 random name from the image source for the file name
         */
        $datetime = new DateTime();

        $datetime =  $datetime->format(DateTime::ATOM);
        $file_name = strtotime($datetime) * 1000;
        $file_extension = request()->file('avatar')->getClientOriginalExtension();
        $file_name = $file_name . "." . $file_extension;
        $file_path = 'users/' . $file_name;

        $avatar = Image::make($request->file('avatar'))->fit(100)->encode($file_extension, 90);

        /**
         * Store avatar
         */

        // print_r($avatar);
        // die();
        Storage::disk('public')->put($file_path, $avatar);

        // print_r($avatar); die();

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
