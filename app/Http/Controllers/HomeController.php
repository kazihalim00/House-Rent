<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function house_detail(Request $request)
    {
        $selectedDate = $request->query('date');
        $selectedOption = $request->query('option', 'exact');
        $allowedOptions = ['exact', '1week', '2weeks', '3weeks'];
        if (!in_array($selectedOption, $allowedOptions)) {
            $selectedOption = 'exact';
        }

        $housesQuery = Home::latest();
        $filterLabel = null;

        if ($selectedDate) {
            try {
                $selectedCarbon = Carbon::parse($selectedDate)->startOfDay();
                $selectedDate = $selectedCarbon->format('Y-m-d');

                if ($selectedOption === 'exact') {
                    $housesQuery->whereDate('booking_date', $selectedDate);
                    $filterLabel = "Exactly {$selectedDate}";
                } else {
                    $daysMap = ['1week' => 7, '2weeks' => 14, '3weeks' => 21];
                    $days = $daysMap[$selectedOption] ?? 7;
                    $from = $selectedCarbon->copy()->subDays($days)->format('Y-m-d');
                    $to = $selectedCarbon->copy()->addDays($days)->format('Y-m-d');
                    $housesQuery->whereBetween('booking_date', [$from, $to]);
                    $filterLabel = "Within ±{$days} days of {$selectedDate}";
                }
            } catch (\Exception $e) {
                $selectedDate = null;
                $filterLabel = null;
            }
        }

        $houses = $housesQuery->get();

        return view('panel.pages.house_detail', compact('houses', 'selectedDate', 'selectedOption', 'filterLabel'));
        $query = Home::query();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('house_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }
        $houses = $query->latest()->get();
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

    public function user_list(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search");
        }
        $users = $query->latest()->get();
        return view('panel.pages.user_list', compact('users'));
    }
    public function summery()
    {
        $users = User::get();

        return view('panel.pages.dashboard', compact('users'));

    }

    public function showBookingPage()
    {
        $dbAvailableDates = Home::whereNotNull('booking_date')
            ->pluck('booking_date')
            ->unique()
            ->values()
            ->map(function ($date) {
                return is_string($date) ? trim($date) : $date->format('Y-m-d');
            })
            ->toArray();

        return view('panel.pages.booking', [
            'dbAvailableDates' => $dbAvailableDates
        ]);
    }

    public function showBookForm($id)
    {
        $house = Home::findOrFail($id);
        return view('panel.pages.book_form', compact('house'));
    }

    public function processBooking(Request $request)
    {
        $request->validate([
            'house_id' => 'required|exists:homes,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'required',
            'check_in_date' => 'required|date|after_or_equal:today',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        Booking::create($data);

        return redirect()->route('house-detail')->with('success', 'Booking submitted successfully!');
    }


    public function show($id)
    {
        $home = Home::findOrFail($id);
        return view('panel.pages.show', compact('home'));
    }
}
