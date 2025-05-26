<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function switchLocale(Request $request)
    {
        $locale = $request['locale'];

        if (in_array($locale, ['ru', 'en'])) {
            if (auth()->check()) {
                auth()->user()->update(['locale' => $locale]);
            }

            session()->put('locale', $locale);
            App::setLocale($locale);
        }

        return redirect()->back();
    }
}
