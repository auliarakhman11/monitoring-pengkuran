<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function kalender(Request $request)
    {

        return view('laporan.kalender', [
            'title' => 'Kalender',
        ]);
    }
}
