<?php

namespace App\Http\Controllers\Dashboard;

use Redot\Http\Controllers\Controller;
use Redot\Jobs\PublishLanguageTokens;
use Redot\Models\Language;

class PublishLanguageTokensController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Language $language)
    {
        PublishLanguageTokens::dispatchSync($language);

        return $this->success(__('Language tokens published successfully.'), 'dashboard.languages.tokens.index', $language);
    }
}
