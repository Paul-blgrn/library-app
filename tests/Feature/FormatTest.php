<?php

use App\Models\Format;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('standard user cannot view formats', function () {
    
    actingAs(User::factory()->create())
        ->get('/api/formats')
        ->assertForbidden();
});

test('standard user cannot create a format', function () {
        actingAs(User::factory()->create())
        ->post('/api/format/add')
        ->assertForbidden();
});
