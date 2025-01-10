<?php

namespace Modules\Users\Tests\Feature;

use Modules\Countries\App\Models\Country;

uses(
    \Tests\TestCase::class,
    // Uncomment the line below if you need database refresh
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test('register new user', function () {
    $country = Country::factory()->create();
    $register = $this->postJson('api/v1/register', [
        'name' => 'fake',
        'first_name' => 'fake',
        'last_name' => 'user',
        'country_id' => $country->id,
        'email' => 'user1@test.com',
        'password' => '123456',
        'password_confirmation' => '123456',
    ]);

    $register->assertStatus(200);
    $content = $register->getContent();
    expect($content)->toBeString();
    $data = $register->json();
    expect($data)->toHaveKey('result.token');
})->group('users');

test('verify email', closure: function () {
    Country::factory()->create();
    $user = testUser(123456);
    $verify = $this->withHeader('Authorization', "Bearer " . $user['token'])->postJson('api/v1/verify-email', [
        'verification_code' => $user['user']->verification_code,
    ]);
    $verify->assertStatus(200);
    $content = $verify->getContent();
    expect($content)->toBeString();
})->group('users');



test('login user', function () {

    $country = Country::factory()->create();
    $this->postJson('api/v1/register', [
        'name' => 'fake',
        'first_name' => 'fake',
        'last_name' => 'user',
        'country_id' => $country->id,
        'email' => 'login@test.com',
        'password' => '123456',
        'password_confirmation' => '123456',
    ]);


    $login = $this->postJson('api/v1/login', [
        'email' => 'login@test.com',
        'password' => '123456',
    ]);

    $login->assertStatus(200);
    $content = $login->getContent();
    expect($content)->toBeString();
    $data = $login->json();
    expect($data)->toHaveKey('result.token');
})->group('users');



test('refresh', function () {
    Country::factory()->create();
    $token = testUser()['token'];
    $response = $this->withHeader('Authorization', "Bearer" . $token)
        ->postJson('api/v1/refresh');
    $response->assertStatus(200);
    $content = $response->getContent();
    expect($content)->toBeString();
    $data = $response->json();
    expect($data)->toHaveKey('result.token');
})->group('users');

test('logout',  function () {
    Country::factory()->create();
    $token = testUser()['token'];
    $response = $this->withHeader('Authorization', "Bearer $token")->postJson('api/v1/logout');
    $response->assertStatus(200);
})->group('users');


test('get profile', closure: function () {
    Country::factory()->create();
    $token = testUser()['token'];
    $response = $this->withHeader('Authorization', "Bearer" . $token)->getJson('api/v1/me');

    $response->assertStatus(200);
    $content = $response->getContent();
    expect($content)->toBeString();
    $data = $response->json();
    expect($data)->toHaveKey('result.email');
})->group('users');

test('send Reset password Code email', closure: function () {
    Country::factory()->create();
    $user = testUser(123456);
    $reset = $this->postJson('api/v1/forgot-password', [
        'email' => $user['user']->email,
    ]);
    $reset->assertStatus(200);
    $content = $reset->getContent();
    expect($content)->toBeString();
})->group('users');

test('reset Password', closure: function () {
    Country::factory()->create();
    $user = testUser(123456, 505050);
    $reset = $this->postJson('api/v1/reset-password', [
        'email'                     => $user['user']->email,
        'code'                      => $user['user']->reset_token,
        'password'                  => '888888',
        'password_confirmation'     => '888888',
    ]);
    $reset->assertStatus(200);
    $content = $reset->getContent();
    expect($content)->toBeString();
})->group('users');
