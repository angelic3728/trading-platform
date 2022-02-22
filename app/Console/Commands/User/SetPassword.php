<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;

use App\User;

class SetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:set-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets password for user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        /**
         * Ask for user id
         */
        $user_id = $this->ask('User ID');

        /**
         * Ask for password
         */
        $password = $this->secret('New Password');

        /**
         * Update Password
         */
        $user = User::find($user_id);
        $user->password = bcrypt($password);
        $user->save();

    }
}
