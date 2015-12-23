<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Model;
use Hash, File;

class SystemController extends Controller
{
    /**
     */
    public function getInstall()
    {
        if (!File::exists(base_path() . 'install.lock')) {
            // default user
            Model::unguard();
            \App\User::create([
                'nickname'      =>      'Rod',
                'email'         =>      'supgeek.rod@gmail.com',
                'phone'         =>      '17090402884',
                'password'      =>      Hash::make('19940120.'),
            ]);
            Model::reguard();

            // defaunt tenants
            $tenants = [
                [
                    'site_name'         =>      'Hey Community Demo',
                    'domain'            =>      'demo.hey-community.online',
                    'email'             =>      'demo@hey-community.com',
                    'password'          =>      Hash::make('hey community'),
                ],
                [
                    'site_name'         =>      'Test Community Demo',
                    'domain'            =>      'test.hey-community.online',
                    'email'             =>      'test@hey-community.com',
                    'password'          =>      Hash::make('hey community'),
                ],
            ];
            if (env('APP_DEBUG')) {
                $tenants[] = [
                    'site_name'         =>      'Dev Community',
                    'domain'            =>      'localhost:6888',
                    'email'             =>      'admin@hey-community.local',
                    'password'          =>      Hash::make('hey community'),
                ];
            }
            foreach ($tenants as $tenant) {
                Model::unguard();
                $Tenant = \App\Tenant::create($tenant);
                Model::reguard();
                event(new \App\Events\CreateNewTenant($Tenant));
            }

            File::put(base_path() . '/install.lock', '');
        }

        //
        return redirect()->route('home');
    }
}
