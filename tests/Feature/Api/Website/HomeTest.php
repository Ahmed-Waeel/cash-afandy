<?php

test('home endpoint can be accessed', function () {
    $response = $this->get(route('api.website.index'));

    $response->assertOk();
});
