<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Content;
use App\Models\Admin\Admin;
use App\Models\Institution;
use Illuminate\Database\Seeder;
use App\Models\HomepageSettings;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\StaticClientContent;


class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //creates 2 clients
        Client::factory()
            ->times(2)

            //creates 3 institutions
            ->has(Institution::factory()->count(3)

                                //creates admins attached to the institution, ie. advisors
                                ->hasAttached(Admin::factory()->count(1)->state(function (array $attributes, Institution $institution) {
                                    return ['client_id' => $institution->client_id];
                                }))

                                //creates 3 institutions users
                                ->has(User::factory()->count(1000)->state(function (array $attributes, Institution $institution) {
                                    return ['client_id' => $institution->client_id];
                                }))

            )

            ->has(HomepageSettings::factory()->state(function (array $attributes=[], Client $client) {
                return ['client_id' => $client->id, 'school_year' => 7];
            }))

            ->has(HomepageSettings::factory()->state(function (array $attributes=[], Client $client) {
                return ['client_id' => $client->id, 'school_year' => 8];
            }))

            ->has(HomepageSettings::factory()->state(function (array $attributes=[], Client $client) {
                return ['client_id' => $client->id, 'school_year' => 9];
            }))

            ->has(HomepageSettings::factory()->state(function (array $attributes=[], Client $client) {
                return ['client_id' => $client->id, 'school_year' => 10];
            }))

            ->has(HomepageSettings::factory()->state(function (array $attributes=[], Client $client) {
                return ['client_id' => $client->id, 'school_year' => 11];
            }))

            ->has(HomepageSettings::factory()->state(function (array $attributes=[], Client $client) {
                return ['client_id' => $client->id, 'school_year' => 12];
            }))

            ->has(HomepageSettings::factory()->state(function (array $attributes=[], Client $client) {
                return ['client_id' => $client->id, 'school_year' => 13];
            }))

            ->has(HomepageSettings::factory()->state(function (array $attributes=[], Client $client) {
                return ['client_id' => $client->id, 'school_year' => 14];
            }))



            //creates level 2 admins (client admin, ...)
            ->has(Admin::factory()->count(3))

            ->has(StaticClientContent::factory()->count(1))
/*
            //creates a homepage
            ->has(Page::factory()->count(1)->state(function (array $attributes, Client $client) {
                return ['client_id' => $client->id];
            }))
*/

            ->create();



        //update clients subdomains
        DB::table('clients')->where('id', 1)->update(['subdomain' => 'ck']);
        DB::table('clients')->where('id', 2)->update(['subdomain' => 'rfmedia']);



        //Each client has homepage settings for each client
       /*  foreach(Client::all() as $client)
        {
            for($i=7;$i<=14;$i++)
            {
                $year = $i;

                $client->has(HomepageSettings::factory()->state(function (array $attributes=[], Client $client) use ($year){
                    return ['client_id' => $client->id, 'school_year' => $year];
                }));

            }
        } */


        //////////////////

        $roles = Role::all();

        //assigns roles to the client admin
        foreach(Admin::all() as $admin){

            //return an array
            $adminRole = $admin->roles->map(function($role) {
                return $role->name;
            });

            //if no role allocated to the admin
            if (count($adminRole) == 0){

                $nbInstitutionAllocated = $admin->institutions()->count();

                //if the admin has an institution allocated, give a "level 1" role
                if ($nbInstitutionAllocated == 1){

                    $admin->assignRole('advisor');

                //else the admin can be a 'Client Admin', 'Client Content Admin', 'Third Party Admin'
                } else {

                    //picks a random item from the role collection
                    $role = $roles->random();

                    $admin->assignRole( $role->name );

                }

            }

        }


        $this->command->info('Client table seeded!');

    }
}
