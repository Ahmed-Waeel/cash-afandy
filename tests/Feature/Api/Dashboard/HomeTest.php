<?php

test('home endpoint can be accessed', function () {
    $response = $this->get(route('api.dashboard.index'));

    $response->assertOk();
});
