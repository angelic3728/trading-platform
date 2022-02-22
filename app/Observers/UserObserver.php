<?php

namespace App\Observers;

use Illuminate\Support\Str;

use App\User;
use App\ActivationToken;

use Mail;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {

        /**
         * Generate token
         */
        $token = Str::random(24);

        /**
         * Create Activation Token
         */
        ActivationToken::create([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        /**
         * Send mail to user
         */
        Mail::to($user)->send(new \App\Mail\User\Invite($user, $token));

    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
