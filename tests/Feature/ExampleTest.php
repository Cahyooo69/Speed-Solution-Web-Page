<?php

test('halaman home dapat diakses', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('halaman outlet dapat diakses', function () {
    $response = $this->get('/outlet');

    $response->assertStatus(200);
});

test('halaman produk dapat diakses', function () {
    $response = $this->get('/produk');

    $response->assertStatus(200);
});

test('halaman promo dapat diakses', function () {
    $response = $this->get('/promo');

    $response->assertStatus(200);
});

test('halaman tentang dapat diakses', function () {
    $response = $this->get('/tentang');

    $response->assertStatus(200);
});

test('api outlets dapat diakses', function () {
    $response = $this->get('/api/outlets');

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'success',
                 'data',
                 'message'
             ]);
});