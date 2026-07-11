<?php

test('home page can be rendered', function () {
    $response = $this->get(route('website.index'));

    $response->assertOk();
});
