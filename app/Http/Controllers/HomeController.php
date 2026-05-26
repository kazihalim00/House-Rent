<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home;
class HomeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'house_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'division' => 'required',
            'home_price' => 'required',
            'bed' => 'required',
            'bath' => 'required',
            'about' => 'required',
            'home_image' => 'required'
        ]);

        $fileName = null;
        if ($request->hasFile('home_image')) {
            $file = $request->file('home_image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move(public_path('/upload/img/'), $fileName);
        }
        Home::create([
            'house_name' => $request->house_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'division' => $request->division,
            'home_price' => $request->home_price,
            'bed' => $request->bed,
            'bath' => $request->bath,
            'about' => $request->about,
            'home_image' => $fileName
        ]);
        return back()->with('success', 'Home added successfully!');
    }

    public function house_detail()
    {
        $houses = Home::latest()->get();
        return view('panel.pages.house_detail', compact('houses'));
    }
}
