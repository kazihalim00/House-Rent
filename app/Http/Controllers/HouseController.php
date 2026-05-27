<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home;

class HouseController extends Controller
{
    public function show($id)
    {
        $home = Home::findOrFail($id);
        return view('panel.pages.show', compact('home'));
    }
}
