<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Models\Home;
use App\Models\User;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'house_name' => 'required',
            'owner_name' => 'required',
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
            'home_image' => 'required',
            'home_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $images = [];
        if ($request->hasFile('home_image')) {
            $files = $request->file('home_image');

            foreach ($files as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/img'), $fileName);
                $images[] = $fileName;
            }
        }

        Home::create([
            'house_name' => $request->house_name,
            'owner_name' => $request->owner_name,
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
            'home_image' => json_encode($images),
            'user_id' => Auth::id(),
            'status' => 'approved'
        ]);

        return back()->with('success', 'Home added successfully!');
    }
    public function add_house_view()
    {
        $users = User::get();
        return view('panel.pages.add_house', compact('users'));
    }

    //after booking period finish the status will show available again
    public function house_detail(Request $request)
    {
        $query = Home::withCount([
            'bookings',
            'bookings as active_bookings_count' => function ($q) {
                $q->whereRaw('DATE_ADD(check_in_date, INTERVAL booking_duration MONTH) > ?', [Carbon::now()->format('Y-m-d')]);
            }
        ])->where('status', 'approved');

        // Search Filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('house_name', 'like', "%{$request->search}%")
                    ->orWhere('address', 'like', "%{$request->search}%")
                    ->orWhere('city', 'like', "%{$request->search}%");
            });
        }

        // Location Filter
        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('city', 'like', "%{$request->location}%")
                    ->orWhere('address', 'like', "%{$request->location}%");
            });
        }

        // Price Filter
        if ($request->filled('min_price')) {
            $query->where('home_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('home_price', '<=', $request->max_price);
        }

        // Rooms Filter
        if ($request->filled('rooms')) {
            $query->where('bed', '>=', $request->rooms);
        }

        // Availability Date Filter
        if ($request->filled('date')) {
            $filterDate = Carbon::parse($request->date);
            $option = $request->input('option', 'exact');


            $startDate = $filterDate->clone();
            $endDate = $filterDate->clone();

            if ($option === '1week') {
                $startDate->subDays(7);
                $endDate->addDays(7);
            } elseif ($option === '2weeks') {
                $startDate->subDays(14);
                $endDate->addDays(14);
            } elseif ($option === '3weeks') {
                $startDate->subDays(21);
                $endDate->addDays(21);
            }

            $query->whereDate('booking_date', '<=', $endDate->format('Y-m-d'))
                ->whereDoesntHave('bookings', function ($q) use ($startDate, $endDate) {
                    $q->whereDate('check_in_date', '<=', $endDate->format('Y-m-d'))
                        ->whereRaw('DATE_ADD(check_in_date, INTERVAL booking_duration MONTH) > ?', [$startDate->format('Y-m-d')]);
                });
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
                ->orWhere('email', 'like', "%$search%");
        }

        $users = $query->latest()->get();
        return view('panel.pages.user_list', compact('users'));
    }

    public function edit_user($id)
    {
        $user = User::findOrFail($id);
        return view('panel.pages.edit_user', compact('user'));
    }

    public function update_user(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:Admin,User',
            'password' => 'nullable|string|min:6',
            'user_image' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_img.' . $extension;
            $file->move(public_path('upload/img/'), $fileName);
            $user->user_image = $fileName;
        }

        $user->save();

        return redirect('/user-list')->with('success', 'User updated successfully.');
    }

    public function delete_user($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function summery()
    {

        $total_users = User::count();
        $total_houses = Home::count();
        $total_bookings = Booking::count();
        $total_appointments = Appointment::count();

        $recent_users = User::take(5)->get();

        $currentMonthBookings = Booking::with('house')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        $monthly_revenue = 0;
        foreach ($currentMonthBookings as $booking) {
            if ($booking->house) {
                $monthly_revenue += ($booking->house->home_price * $booking->booking_duration);
            }
        }

        return view('panel.pages.dashboard', compact(
            'total_users',
            'total_houses',
            'total_bookings',
            'total_appointments',
            'recent_users',
            'monthly_revenue'
        ));
    }
    public function showBookingPage()
    {
        $dbAvailableDates = Home::where('status', 'approved')
            ->whereNotNull('booking_date')
            ->whereDoesntHave('bookings', function ($q) {
                $q->whereRaw('DATE_ADD(check_in_date, INTERVAL booking_duration MONTH) > ?', [Carbon::now()->toDateString()]);
            })
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
        $currentUser = Auth::user();

        if ($house->user_id === $currentUser->id) {
            return redirect()->route('house-detail')->with('error', 'You cannot book your own house!');
        }

        $activeBookingExists = $house->bookings()->whereRaw('DATE_ADD(check_in_date, INTERVAL booking_duration MONTH) > ?', [Carbon::now()->format('Y-m-d')])->exists();
        if ($activeBookingExists) {
            return redirect()->route('house-detail')->with('error', 'This house has an active booking and cannot be booked again yet.');
        }

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
            'booking_duration' => 'required|integer|min:1',
        ]);

        $house = Home::findOrFail($request->house_id);
        $currentUser = Auth::user();

        if ($house->user_id === $currentUser->id) {
            return back()->with('error', 'You cannot book your own house!');
        }

        $checkInDate = Carbon::parse($request->check_in_date)->format('Y-m-d');
        $bookingDuration = intval($request->booking_duration);
        $overlapExists = $house->bookings()->where(function ($q) use ($checkInDate, $bookingDuration) {
            $q->whereDate('check_in_date', '<', Carbon::parse($checkInDate)->addMonths($bookingDuration)->format('Y-m-d'))
                ->whereRaw('DATE_ADD(check_in_date, INTERVAL booking_duration MONTH) > ?', [Carbon::parse($checkInDate)->format('Y-m-d')]);
        })->exists();

        if ($overlapExists) {
            return back()->with('error', 'This property is already booked for the selected date range.');
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();

        Booking::create($data);

        return redirect()->route('house-detail')->with('success', 'Booking submitted successfully!');
    }

    public function show($id)
    {
        $home = Home::findOrFail($id);
        $reviews = Review::where('house_id', $id)->with('user')->latest()->get();
        $activeBookingExists = $home->bookings()
            ->whereRaw('DATE_ADD(check_in_date, INTERVAL booking_duration MONTH) > ?', [Carbon::now()->format('Y-m-d')])
            ->exists();

        return view('panel.pages.show', compact('home', 'activeBookingExists', 'reviews'));
    }
    public function pending_houses()
    {
        $houses = Home::where('status', 'pending')->latest()->get();
        return view('panel.pages.pending_houses', compact('houses'));
    }

    public function approve_house($id)
    {
        $house = Home::findOrFail($id);
        $house->status = 'approved';
        $house->save();

        return back()->with('success', 'House Approved Successfully! Now it is visible to everyone.');
    }

    public function bookingList()
    {
        $bookings = Booking::with(['user', 'house'])
            ->latest()
            ->get();

        return view('panel.pages.booking_list', compact('bookings'));
    }

    public function reject_house($id)
    {
        $house = Home::findOrFail($id);
        $house->status = 'rejected';
        $house->save();

        return back()->with('success', 'House listing has been rejected.');
    }
    public function book_appointment(Request $request, $id)
    {
        $request->validate([
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required|string',
            'message' => 'nullable|string|max:1000',
        ]);

        Appointment::create([
            'house_id' => $id,
            'user_id' => Auth::id(),
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'message' => $request->message,
            'status' => 'pending',
        ]);


        return back()->with('success', 'Appointment request submitted successfully! The owner will be notified.');
    }
    public function appointmentList()
    {
        $appointments = Appointment::with(['house', 'user'])->latest()->get();

        return view('panel.pages.appointment_list', compact('appointments'));
    }
    public function approveAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'approved';
        $appointment->save();

        return back()->with('success', 'Appointment has been approved successfully!');
    }

    public function rejectAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'rejected';
        $appointment->save();

        return back()->with('error', 'Appointment has been rejected.');
    }
    public function deleteAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return back()->with('success', 'Appointment deleted successfully!');
    }

    public function deleteBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return back()->with('success', 'Booking deleted successfully!');
    }
    public function review()
    {
        $reviews = Review::whereNull('house_id')->with('user')->latest()->get();
        return view('panel.pages.review', compact('reviews'));
    }


    public function store_review(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'house_id' => 'nullable|exists:homes,id'
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'house_id' => $request->house_id
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted.');
    }

    public function delete_review($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Review deleted successfully!');

    }

    // if house booked then it will not show in home page
    public function overview()
    {
        // Hero: all approved house 
        $heroHouses = Home::where('status', 'approved')
            ->latest()->take(3)->get();
        $members = TeamMember::get();
        // Cards: only available house
        $houses = Home::where('status', 'approved')
            ->whereDoesntHave('bookings', function ($q) {
                $q->whereRaw(
                    'DATE_ADD(check_in_date, INTERVAL booking_duration MONTH) > ?',
                    [Carbon::now()->toDateString()]
                );
            })
            ->latest()->take(6)->get();

        // Reviews: general or admin 
        $reviews = Review::where(function ($q) {
            $q->whereNull('house_id')
                ->orWhereHas('user', fn($q2) => $q2->where('role', 'admin'));
        })
            ->with('user')->latest()->take(6)->get();

        return view('frontend.pages.home', compact('heroHouses', 'houses', 'reviews', 'members'));
    }

    public function add_team_member(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'image' => 'required',
            'short_bio' => 'required',
            'github' => 'required',
            'linkedin' => 'required',
            'portfolio' => 'required',
            'order' => 'required',
            'status' => 'required',
        ]);
        $filename = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('upload/team/'), $filename);

        }
        TeamMember::create([
            'name' => $request->name,
            'role' => $request->role,
            'short_bio' => $request->short_bio,
            'github' => $request->github,
            'linkedin' => $request->linkedin,
            'portfolio' => $request->portfolio,
            'order' => $request->order,
            'status' => $request->status,
            'image' => $filename,

        ]);

        return back()->with('success', 'Team member added successfully!');

    }

    public function see_team_members()
    {
        $members = TeamMember::get();

        return view('panel.pages.see_team_members', compact('members'));

    }
    public function edit_team_member($id)
    {

        $member = TeamMember::findOrFail($id);

        return view('panel.pages.edit_team_member', compact('member'));
    }
    public function update_team_member(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'short_bio' => 'required',
            'order' => 'nullable',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'github' => 'nullable',
            'linkedin' => 'nullable',
            'portfolio' => 'nullable',
        ]);


        if ($request->hasFile('image')) {

           
            if ($member->image && file_exists(public_path('upload/team/' . $member->image))) {
                unlink(public_path('upload/team/' . $member->image));
            }

            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/team/'), $fileName);

            $member->image = $fileName;
        }

        $member->name = $request->name;
        $member->role = $request->role;
        $member->short_bio = $request->short_bio;
        $member->github = $request->github;
        $member->linkedin = $request->linkedin;
        $member->portfolio = $request->portfolio;
        $member->order = $request->order ?? 0;
        $member->status = $request->status;

        // ⭐ IMPORTANT FIX
        $member->save();

        return redirect('/see-team-members')
            ->with('success', 'Team member updated successfully!');
    }
}