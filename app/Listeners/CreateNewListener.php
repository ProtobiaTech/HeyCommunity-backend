<?php

namespace App\Listeners;

use App\Events\CreateNewTenant;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Database\Eloquent\Model;
use Faker;

class CreateNewListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreateNewTenant  $event
     * @return void
     */
    public function handle(CreateNewTenant $event)
    {
        $this->Tenant = $event->Tenant;
        $this->faker = Faker\Factory::create();

        Model::unguard();

        $this->userSeeder();
        $this->timelineSeeder();
        $this->activitySeeder();

        Model::reguard();
    }

    /**
     */
    protected function userSeeder()
    {
        $this->User = \App\User::create([
            'nickname'      =>  'admin-' . $this->Tenant->id,
            'email'         =>  $this->Tenant->email,
            'phone'         =>  $this->Tenant->phone,
            'password'      =>  $this->Tenant->password,
        ]);
    }

    /**
     */
    protected function activitySeeder()
    {
        foreach (array_fill(1, 5, 0) as $k => $v) {
            \App\Activity::create([
                'user_id'       =>      $this->User->id,
                'tenant_id'     =>      $this->Tenant->id,
                'title'         =>      $this->faker->sentence(),
                'content'       =>      implode('<br>', $this->faker->paragraphs(random_int(2, 10))),
                'avatar'        =>      $this->faker->imageUrl(200, 200),

                'start_date'    =>      $this->faker->dateTimeBetween('- 10 days', 'now'),
                'end_date'      =>      $this->faker->dateTimeBetween('now', '+ 30 days'),
            ]);
        }
    }

    /**
     */
    protected function timelineSeeder()
    {
        foreach (array_fill(1, 5, 0) as $k => $v) {
            \App\Timeline::create([
                'user_id'       =>      $this->User->id,
                'tenant_id'     =>      $this->Tenant->id,
                'title'         =>      $this->faker->sentence(),
                'content'       =>      implode('<br>', $this->faker->paragraphs(random_int(1, 2))),
                'attachment'    =>      $this->faker->imageUrl(),
            ]);
        }
    }
}
