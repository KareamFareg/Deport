<?php

namespace App\Http\Middleware;

use App\Helpers\UtilHelper;
use Closure;

class PreventBadWords
{

    public function handle($request, Closure $next)
    {

        if ($request->hasAny(['comment', 'description'])) {
            $badWords = \App\Models\BadWords::where('language_id', app()->getLocale())->select('words')->first();
            if ($request->has('description')) {
                $request->merge(['description' => str_replace($badWords->words, [''], UtilHelper::formatNormal($request->description))]);
            }
            if ($request->has('comment')) {
                $request->merge(['comment' => str_replace($badWords->words, [''], UtilHelper::formatNormal($request->comment))]);
            }
        }

        return $next($request);

    }
}
