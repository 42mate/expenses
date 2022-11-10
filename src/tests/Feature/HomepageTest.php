<?php

it('has homepage page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});


it('has login page', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

it('has login create user page', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});


it('has recover password page', function () {
    $response = $this->get('/password/reset');

    $response->assertStatus(200);
});
