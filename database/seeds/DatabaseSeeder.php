<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Super',
            'email' => 'user1@test.eu',
            'password' => Hash::make('password'),
            'usertype_ID' => 1,
        ]);
      
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Admin',
            'email' => 'user2@test.eu',
            'password' => Hash::make('password'),
            'usertype_ID' => 2,
        ]);
      
        DB::table('users')->insert([
            'id' => 3,
            'name' => 'user',
            'email' => 'user3@test.eu',
            'password' => Hash::make('password'),
            'usertype_ID' => 3,
        ]);
      

        //Create the predefined data sets for the user types
        
        //super user admin
        DB::table('user_types')->insert([
            'id' => 1,
            'name' => 'Super',
        ]);
        
        //manager type user
        DB::table('user_types')->insert([
            'id' => 2,
            'name' => 'Admin',
        ]);
      
        //employee user type
        DB::table('user_types')->insert([
            'id' => 3,
            'name' => 'User',
        ]);
      
      
        //Add two cases for the user
      
      
        DB::table('cases')->insert([
            'id' => 1,
            'name' => 'CASE1',
            'user_id' => '3',
            'dataset_id' => 0,
            'visualisation_id' => 0,
            'analysisresult_id' => 0,
            'server_location' => 'CASE1',
        ]);
      
        DB::table('cases')->insert([
            'id' => 2,
            'name' => 'CASE2',
            'user_id' => '3',
            'dataset_id' => 0,
            'visualisation_id' => 0,
            'analysisresult_id' => 0,
        ]);
      
        DB::table('cases')->insert([
            'id' => 3,
            'name' => 'CASE3',
            'user_id' => '3',
            'dataset_id' => 0,
            'visualisation_id' => 0,
            'analysisresult_id' => 0,
        ]);
      
    }
}
