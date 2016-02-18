<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Model;
use Hash, File;
use App\User;
use App\Timeline;
use App\Activity;
use App\Tenant;

class SystemController extends Controller
{
    /**
     */
    public function getInstall()
    {
        if (!File::exists(base_path() . '/install.lock')) {
            // default user
            Model::unguard();
            \App\User::create([
                'nickname'      =>      'Rod',
                'email'         =>      'supgeek.rod@gmail.com',
                'phone'         =>      '17090402884',
                'password'      =>      Hash::make('hey community'),
            ]);

            \App\User::create([
                'nickname'      =>      'Robot',
                'email'         =>      'robot@hey-community.online',
                'phone'         =>      '12312312312',
                'password'      =>      Hash::make('hey community'),
            ]);
            Model::reguard();

            // defaunt tenants
            $tenants = [
                [
                    'site_name'         =>      'Hey Community Demo',
                    'sub_domain'        =>      'demo.hey-community.online',
                    'email'             =>      'demo@hey-community.com',
                    'password'          =>      Hash::make('hey community'),
                ],
                [
                    'site_name'         =>      'Test Community Demo',
                    'sub_domain'        =>      'test.hey-community.online',
                    'email'             =>      'test@hey-community.com',
                    'password'          =>      Hash::make('hey community'),
                ],
            ];
            if (env('APP_DEBUG')) {
                $tenants[] = [
                    'site_name'         =>      'Dev Community',
                    'domain'            =>      'localhost:6888',
                    'sub_domain'        =>      'localhost:6888',
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

    /**
     */
    public function getState(Request $request)
    {
        if ($request->has('pw') && Hash::check($request->pw, '$2y$10$8e634fQcF26g5vlSrE89IubBRYsuVmNBjf/nWPNW85F8rLWSABt6S')) {
            $assign['users']        =   User::paginate();
            $assign['tenants']      =   Tenant::paginate();
            $assign['timelines']    =   Activity::all();
            $assign['activities']   =   Timeline::all();
            return view('admin.home.state', $assign);
        } else {
            return redirect()->route('home');
        }
    }
}
