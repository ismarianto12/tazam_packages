<?php

namespace Bryanjack\Dash\App\Commands;

use App\Models\User;
use Bryanjack\Dash\DashSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class DashAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dash:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating user admin';

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
        $this->info('--Creating Admin if not exist..');
        Role::firstOrCreate(['name' => 'admin']);

        $this->info('--To create user admin, input the email:');
        $username = $this->askValid("What's the username?", 'username', ['required', 'min:3']);
        $email = $this->askValid("What's the email?", 'email', ['required', 'min:3']);
        $password = $this->askValid("What's the password?", 'password', ['required', 'min:3']);

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $username;
        $user->username = $username;
        $user->status = 1;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->email_verified_at = now();
        $user->save();
        $user->syncRoles('admin');
    }

    protected function askValid($question, $field, $rules)
    {
        $value = $this->ask($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }


    protected function validateInput($rules, $fieldName, $value)
    {
        $validator = Validator::make([
            $fieldName => $value
        ], [
            $fieldName => $rules
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
}
