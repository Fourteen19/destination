<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Admin\Admin;
use App\Models\Institution;
use Illuminate\Database\Seeder;


class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
/*
        //Persists records in DB
        Client::factory()
            ->times(2)
            ->has(Institution::factory()
                                ->count(3)
                                ->has(User::factory()
                                                ->count(3)))
            ->has(Admin::factory()
                                ->count(3))
            ->create();
*/

        //creates 2 clients
        Client::factory()
            ->times(2)

            //creates 3 institutions
            ->has(Institution::factory()->count(3)

                                //attaches 3 admins in pivot table
                                ->hasAttached(Admin::factory()->count(3))

                                //creates 3 institutions users 
                                ->has(User::factory()->count(3))

                            )

            //creates level 2 admins (client admin, ...)     
            //TO DO : MUST ATTACH TO A CLIENT. see state               
            ->has(Admin::factory()->count(3))

            ->create();



            //assigns roles to the client admin
            foreach(Admin::all() as $admin){

                print $adminRole = $admin->roles->map(function($role) {
                    return $role->name;
                });

                //if no role allocated to the admin
                if (count($adminRole) == 0){

                    //if the admin has an institution allocated, give a "level 1" role 
  
                    print $admin->institutions()->count();
  
                    /*if (!is_integer()){
                        

                    //if a client has been allocated to the user, set the adminas an " advisor"
                    } else {



                    }
*/
                }


            }

/*
                   ->hasAttached(Admin::factory()->count(3)) 
*/
/*            foreach(Institution::all() as $institution) {
                //dd($institution);
                //$institution->attach(Admin::factory()->times(3))->assignRole('Advisor')->create();
                //$admin->assignRole($role);

                //$member->save();
            }
*/

        $this->command->info('Client table seeded!');


        

    }
}
