<?php

test('health check screen can be rendered', function () {
    $response = $this->get(route('website.health-check'));

    $response->assertOk();
});
