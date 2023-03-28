<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required',
        ]);

        Session::put('language', $request->language);

        return redirect()->back();
    }
}
