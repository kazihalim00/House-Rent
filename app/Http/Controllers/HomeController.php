<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home;
use App\Models\User;
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
            'booking_date' => 'required',
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
            'booking_date' => $request->booking_date,
            'home_image' => $fileName
        ]);

        return back()->with('success', 'Home added successfully!');
    }

    public function house_detail()
    {
        $houses = Home::latest()->get();
        return view('panel.pages.house_detail', compact('houses'));
    }

    public function add_user(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required'
        ]);

        $fileName = null;
        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_img.' . $extension;
            $file->move(public_path('upload/img/'), $fileName);
        }


        User::create([
            'name' => $request->name,
            'email' => $request->email,

            'role' => $request->role,
            'password' => bcrypt($request->password),
            'user_image' => $fileName,

        ]);
        return back()->with('success', 'User Created Successfully!');
    }

    public function user_list()
    {
        $users = User::latest()->get();
        return view('panel.pages.user_list', compact('users'));
    }


    public function showBookingPage()
    {
    $dbAvailableDates = Home::whereNotNull('booking_date')
        ->pluck('booking_date')
        ->unique()
        ->values()
        ->map(function($date) {
            return is_string($date) ? trim($date) : $date->format('Y-m-d');
        })
        ->toArray();

    return view('panel.pages.booking', [
        'dbAvailableDates' => $dbAvailableDates
    ]);
    }
}
