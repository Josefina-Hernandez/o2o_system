<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UsersTableUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:users {login_id : New login ID} {password : New password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update login ID / password in users table';

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
        // コマンドパラメータの取得
        $login_id = $this->argument('login_id');
        $password = bcrypt($this->argument('password'));

        if ($login_id && $password) {
            $user = User::find(1)->fill([
                'login_id' => $login_id,
                'password' => $password,
            ]);
            $user->save();
            // 正しく更新されていた場合にメッセージを出力
            $new_user = User::find(1);
            if ($new_user->login_id === $login_id && $new_user->password === $password) {
                $this->info('Users table updated successfully.');
            } else {
                $this->info('Users table update failed.');
            }
        }
    }
}
