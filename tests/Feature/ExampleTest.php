<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('api/', [
            "APP_KEY"=>"base64:fB4lz4MiADyaPfyO3KcIJZD0F+NHB77Zptl4uy56gWY="
        ]);

        $response->assertStatus(200);
    }

    public function test_app_failed_without_auth(): void
    {
        $response = $this->get('api/');
        $response->assertStatus(401);
    }

    public function test_app_failed_with_wrong_auth(): void
    {
        $response = $this->get('api/', [
            "APP_KEY"=>"base64:fB4lz4MiADyaPfyO3KcIJZD0F+NHB77Zptl4uy56gWY12="
        ]);
        $response->assertStatus(401);
    }

    public function test_admin_login():void
    {
        $response= $this->post(
                            'api/signin',
                            [
                                "name"=> "Super_admin",
                                "password"=> "Password",
                                "role"=>"admin"
                            ],
                            [
                                "APP_KEY"=>"base64:fB4lz4MiADyaPfyO3KcIJZD0F+NHB77Zptl4uy56gWY="
                            ]);
        
        $response->assertStatus(200);
    }

    // public function test_create_institution():void
    // {
    //     $response= $this->post(
    //                         'api/institution/create',
    //                         [
    //                             "admin_name"=>"Man 1",
    //                             "admin_email"=>"email@mail.com",
    //                             "name"=> "Institution 1",
    //                             "address"=> "Institution 1 Add",
    //                             "telephone"=> "Institution 1 Tel",
    //                             "email"=> "institution1@mail.com"
    //                         ],
    //                         [
    //                             "APP_KEY"=>"base64:fB4lz4MiADyaPfyO3KcIJZD0F+NHB77Zptl4uy56gWY=",
    //                             "authorization"=>'SUPER_ADMIN $2y$12$ampezlIc4jwbqd5F27YBKOiIeCiBpskPdjM5TlULIfjUexaT3fABa'
    //                         ]);
        
    //     $response->assertStatus(200);

    // }

    // public function test_institution_creation(): void
    // {
    //     $response= $this->post('/', [
    //         "APP_KEY"=>"base64:fB4lz4MiADyaPfyO3KcIJZD0F+NHB77Zptl4uy56gWY=",

    //     ]);
    // }
}
