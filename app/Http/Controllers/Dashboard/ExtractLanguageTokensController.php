<?php

namespace App\Http\Controllers\Dashboard;

use Redot\Http\Controllers\Controller;
use Redot\Jobs\ExtractLanguageTokens;
use Redot\Models\Language;

class ExtractLanguageTokensController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Language $language)
    {
        ExtractLanguageTokens::dispatchSync($language);

        return $this->success(__('Language tokens have been extracted successfully.'));
    }
}
