<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TimelineTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * test get index
     *
     * @return void
     */
    public function testGetIndex()
    {
        // $this->get('/api/timeline/index')->seeJson(['is_like' => false]);
    }

    /**
     * test store a new timeline
     *
     * @return void
     */
    public function testStore()
    {
        /*
        $User = factory(App\User::class)->create();
        $this->actingAs($User);


        $data = [
            'content'   =>      'this is content',
        ];
        $this->post('/api/timeline/store', $data)->assertResponseOk();
         */
    }
}
