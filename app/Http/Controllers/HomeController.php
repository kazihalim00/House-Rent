<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Booking;
use App\Models\Home;
use App\Models\Review;
use App\Models\TeamMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function store(Request $request)
    {
        // Normalize phone number
        $phone = trim($request->phone);

        // Remove +88 or 88 from the beginning
        if (str_starts_with($phone, '+88')) {
            $phone = substr($phone, 3);
        } elseif (str_starts_with($phone, '88')) {
            $phone = substr($phone, 2);
        }

        // Update request with normalized phone
        $request->merge([
            'phone' => $phone,
        ]);

        // Validation
        $request->validate([
            'house_name' => 'required',
            'owner_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|string|max:20|unique:homes,phone',
            'address' => 'required',
            'city' => 'required',
            'division' => 'required',
            'home_price' => 'required',
            'bed' => 'required',
            'bath' => 'required',
            'about' => 'required',
            'booking_date' => 'required',
            'home_image' => 'required',
            'home_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload Images
        $images = [];

        if ($request->hasFile('home_image')) {
            foreach ($request->file('home_image') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/img'), $fileName);
                $images[] = $fileName;
            }
        }

        // Save Home
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
            'status' => 'approved',
        ]);

        return back()->with('success', 'Home added successfully!');
    }

    public function add_house_view()
    {
        $users = User::get();
        return view('panel.pages.add_house', compact('users'));
    }

    // after booking period(date) finish the status will show available again
    public function house_detail(Request $request)
    {
        $query = Home::withCount([
            'bookings',
            'bookings as active_bookings_count' => function ($q) {
                $q->where('status', 'approved')->whereRaw('DATE_ADD(check_in_date, INTERVAL booking_duration MONTH) > ?', [Carbon::now()->format('Y-m-d')]);
            }
        ])->where('status', 'approved');

        // Search Filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q
                    ->where('house_name', 'like', "%{$request->search}%")
                    ->orWhere('address', 'like', "%{$request->search}%")
                    ->orWhere('city', 'like', "%{$request->search}%");
            });
        }

        // Location Filter
        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q
                    ->where('city', 'like', "%{$request->location}%")
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

            $query
                ->whereDate('booking_date', '<=', $endDate->format('Y-m-d'))
                ->whereDoesntHave('bookings', function ($q) use ($startDate, $endDate) {
                    $q
                        ->where('status', 'approved')
                        ->whereDate('check_in_date', '<=', $endDate->format('Y-m-d'))
                        ->whereRaw('DATE_ADD(check_in_date, INTERVAL booking_duration MONTH) > ?', [$startDate->format('Y-m-d')]);
                });
        }

        $houses = $query->latest()->paginate(6)->withQueryString();

        return view('panel.pages.house_detail', compact('houses'));
    }

    public function add_user(Request $request)
    {
        $phone = trim($request->phone);

        if (str_starts_with($phone, '+88')) {
            $phone = substr($phone, 3);
        } elseif (str_starts_with($phone, '88')) {
            $phone = substr($phone, 2);
        }

        $request->merge([
            'phone' => $phone,
        ]);

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|string|max:20|unique:users,phone',
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
            'phone' => $request->phone,
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
            $query
                ->where('name', 'like', "%$search%")
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

    //admin dashboard
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

        //owner can't book
        if ($house->user_id === $currentUser->id) {
            return redirect()->route('house-detail')->with('error', 'You cannot book your own house!');
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

        if ($house->user_id === Auth::id()) {
            return back()->with('error', 'You cannot book your own house!');
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        Booking::create($data);

        return redirect()->route('house-detail')->with('success', 'Booking submitted successfully!');
    }

    public function show($id)
    {
        $home = Home::findOrFail($id);
        $reviews = Review::where('house_id', $id)->with('user')->latest()->get();
        $activeBookingExists = $home
            ->bookings()
            ->where('status', 'approved')
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
        $user = Auth::user();

        if ($user->role == 'Admin') {
            $bookings = Booking::with(['user', 'house'])->latest()->get();
        } else {
            // Show requests
            $bookings = Booking::where('user_id', $user->id)
                ->orWhereHas('house', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with(['user', 'house'])
                ->latest()
                ->get();
        }


        return view('panel.pages.booking_list', compact('bookings'));
    }

    public function approveBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $house = Home::findOrFail($booking->house_id);

        if ($house->user_id !== Auth::id() && Auth::user()->role !== 'Admin') {
            return back()->with('error', 'Unauthorized action.');
        }

        $booking->status = 'approved';
        $booking->save();

        $approvedCheckIn = Carbon::parse($booking->check_in_date);
        $approvedCheckOut = $approvedCheckIn->copy()->addMonths($booking->booking_duration);

        // Find other pending bookings for the same house
        $otherPendingBookings = Booking::where('house_id', $booking->house_id)
            ->where('id', '!=', $booking->id)
            ->where('status', 'pending')
            ->get();

        foreach ($otherPendingBookings as $otherBooking) {
            $otherCheckIn = Carbon::parse($otherBooking->check_in_date);
            $otherCheckOut = $otherCheckIn->copy()->addMonths($otherBooking->booking_duration);

            // reject status show if other got approve in booking
            if ($approvedCheckIn->lessThan($otherCheckOut) && $approvedCheckOut->greaterThan($otherCheckIn)) {
                $otherBooking->status = 'rejected';
                $otherBooking->save();
            }
        }

        return back()->with('success', 'Booking request approved!');
    }

    public function rejectBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $house = Home::findOrFail($booking->house_id);

        if ($house->user_id !== Auth::id() && Auth::user()->role !== 'Admin') {
            return back()->with('error', 'Unauthorized action.');
        }

        $booking->status = 'rejected';
        $booking->save();

        return back()->with('success', 'Booking request rejected.');
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
        $houseId = $booking->house_id;
        $wasApproved = $booking->status === 'approved';

        $booking->delete();

        if ($wasApproved) {
            // If owner delete approve then other user become pending
            Booking::where('house_id', $houseId)
                ->where('status', 'rejected')
                ->update(['status' => 'pending']);
        }

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
            ->latest()
            ->take(3)
            ->get();

        // Members: only active members, sorted by order
        $members = TeamMember::where('status', 'active')
            ->orderBy('order', 'asc')
            ->get();

        // Cards: only available house
        $houses = Home::where('status', 'approved')
            ->whereDoesntHave('bookings', function ($q) {
                $q->where('status', 'approved');
                $q->whereRaw(
                    'DATE_ADD(check_in_date, INTERVAL booking_duration MONTH) > ?',
                    [\Carbon\Carbon::now()->toDateString()]
                );
            })
            ->latest()
            ->take(6)
            ->get();

        // Reviews: general or admin
        $reviews = Review::where(function ($q) {
            $q->whereNull('house_id')
                ->orWhereHas('user', fn($q2) => $q2->where('role', 'admin'));
        })
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

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
        $members = TeamMember::orderBy('order', 'asc')->get();

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
            'order' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'github' => 'required',
            'linkedin' => 'required',
            'portfolio' => 'required',
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

        $member->save();

        return redirect()->back()->with('success', 'Team member updated successfully!');
        return redirect('/see-team-member')
            ->with('success', 'Team member updated successfully!');
    }

    public function delete_team_member($id)
    {
        $member = TeamMember::findOrFail($id);

        return view('panel.pages.delete_team_member', compact('member'));
    }

    public function destroy_team_member($id)
    {
        $member = TeamMember::findOrFail($id);

        if ($member->image && file_exists(public_path('upload/team/' . $member->image))) {
            unlink(public_path('upload/team/' . $member->image));
        }

        $member->delete();

        return redirect()
            ->route('see-team-member')
            ->with('success', 'Team member deleted successfully.');
    }
}
