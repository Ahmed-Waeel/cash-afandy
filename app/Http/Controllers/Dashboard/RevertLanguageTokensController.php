<?php

namespace App\Http\Controllers\Dashboard;

use Redot\Http\Controllers\Controller;
use Redot\Jobs\RevertLanguageTokens;
use Redot\Models\Language;

class RevertLanguageTokensController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Language $language)
    {
        RevertLanguageTokens::dispatchSync($language);

        return $this->success(__('Language tokens reverted successfully.'), 'dashboard.languages.tokens.index', $language);
    }
}
