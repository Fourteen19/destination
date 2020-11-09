<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Admin\Admin;
use Spatie\Permission\Models\Role;
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




            $roles = Role::all();

            //assigns roles to the client admin
            foreach(Admin::all() as $admin){

                print $adminRole = $admin->roles->map(function($role) {
                    print $role->level;
                    return $role->name;
                });

                //if no role allocated to the admin
                if (count($adminRole) == 0){

                    $nb_institution_allocated = $admin->institutions()->count();

                    //if the admin has an institution allocated, give a "level 1" role
                    if ($nb_institution_allocated == 1){
                        $admin->assignRole('advisor');

                    //else the admin can be a 'Client Admin', 'Client Content Admin', 'Third Party Admin'
                    } else {

                        //picks a random item from the role collection
                        $role = $roles->random();

                        $admin->assignRole( $role->name );


                    }

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
