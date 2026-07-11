<?php

use Illuminate\Http\UploadedFile;

test('tinymce can upload a file', function () {
    $response = $this->post(route('global.tinymce.upload'), [
        'file' => UploadedFile::fake()->image('file.jpg'),
    ]);

    $response->assertOk();
    $response->assertJsonStructure(['location']);
});
