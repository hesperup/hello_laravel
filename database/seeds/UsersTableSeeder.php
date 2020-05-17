<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       factory(User::class,50)->create()->each(function($user){
           $user->save();
       });
       $user = User::find(2);
        $user->is_admin = true;
        $user->save();
        
    }
}
