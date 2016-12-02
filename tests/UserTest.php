<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * test user, signup login and logout
     *
     * @return void
     */
    public function testSignUpAndLogInAndLouOut()
    {
        /*
        $datas = [
            [
                'nickname'  =>  'nickname' . random_int(0, 1111),
                'phone'     =>  123123 . random_int(0, 1111),
                'password'  =>  'password',
            ],
            [
                'nickname'  =>  'nickname2' . random_int(0, 1111),
                'phone'     =>  '17012341234',
                'password'  =>  'password',
            ],
        ];

        foreach($datas as $data) {
            $this->post('/api/user/sign-up', $data)->assertResponseOk();
            $this->post('/api/user/log-out')->assertResponseOk();

            $loginData = [
                'phone'     =>  $data['phone'],
                'password'  =>  $data['password'],
            ];
            $this->post('/api/user/log-in', $loginData)->assertResponseOk();
            $this->post('/api/user/log-out')->assertResponseOk();
        }
         */
    }
}
