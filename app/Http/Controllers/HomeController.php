<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
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
        $users = User::get();
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
            'home_image' => $fileName
        ]);

        return back()->with('success', 'Home added successfully!');
    }
    public function add_house_view()
    {
        $users = User::get();
        return view('panel.pages.add_house', compact('users'));
    }
    public function house_detail(Request $request)
    {

        $query = Home::withCount('bookings')->where('status', 'approved');
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('house_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $selectedDate = $request->query('date');
        $selectedOption = $request->query('option', 'exact');
        $allowedOptions = ['exact', '1week', '2weeks', '3weeks'];
        if (!in_array($selectedOption, $allowedOptions)) {
            $selectedOption = 'exact';
        }

        $filterLabel = null;

        if ($selectedDate) {
            try {
                $selectedCarbon = Carbon::parse($selectedDate)->startOfDay();
                $selectedDate = $selectedCarbon->format('Y-m-d');

                if ($selectedOption === 'exact') {
                    $query->whereDate('booking_date', $selectedDate);
                    $filterLabel = "Exactly {$selectedDate}";
                } else {
                    $daysMap = ['1week' => 7, '2weeks' => 14, '3weeks' => 21];
                    $days = $daysMap[$selectedOption] ?? 7;
                    $from = $selectedCarbon->copy()->subDays($days)->format('Y-m-d');
                    $to = $selectedCarbon->copy()->addDays($days)->format('Y-m-d');
                    $query->whereBetween('booking_date', [$from, $to]);
                    $filterLabel = "Within ±{$days} days of {$selectedDate}";
                }
            } catch (\Exception $e) {
                $selectedDate = null;
                $filterLabel = null;
            }
        }

        $houses = $query->latest()->get();

        return view('panel.pages.house_detail', compact('houses', 'selectedDate', 'selectedOption', 'filterLabel'));
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
        $users = User::get();
        return view('panel.pages.dashboard', compact('users'));
    }

    public function showBookingPage()
    {
        $dbAvailableDates = Home::where('status', 'approved')
            ->whereNotNull('booking_date')
            ->whereDoesntHave('bookings')
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
            'booking_duration' => 'required|integer|min:1',
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

        return back()->with('error', 'Appointment has been rejected.'); // error সেশন ব্যবহার করেছি যাতে লাল রঙের মেসেজ দেখানো যায়
    }
}