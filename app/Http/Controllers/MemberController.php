<?php

namespace App\Http\Controllers;

use App\Models\AttendanceMember;
use App\Models\Event;
use App\Models\Member;
use App\Models\MemberEvent;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return view('public.members.index');
    }

    public function register()
    {
        return view('public.members.register');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string',
                'fullname' => 'required|string',
                'wa_number' => 'required|string',
                'address' => 'required',
            ]);

            $existingMember = Member::where('wa_number', $request->wa_number)
                ->where('email', $request->email)
                ->first();

            if ($existingMember) {
                return back()->with('error', 'Email atau Nomor Whatsapp Anda sudah terdaftar');
            }

            $threeDigitPhone = substr($request->wa_number, -3);
            $randomDigit = rand(1, 999);
            $suffixDigit = str_pad($randomDigit, 3, '0', STR_PAD_LEFT);
            $prefixIdentity = 'MRF-MSP-' . $threeDigitPhone . $suffixDigit;
            Member::create([
                'identity' => $prefixIdentity,
                'email' => $request->email,
                'fullname' => $request->fullname,
                'wa_number' => $request->wa_number,
                'address' => $request->address,
                'point_total'=> 0,
                'is_checked' => false,
            ]);

            $member = Member::where('identity', $prefixIdentity)->first();

            return redirect()->route('public.members.register_success')
                ->with('success', 'Berhasil melakukan pendaftaran member')
                ->with('member', $member);
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi Kesalahan. Hubungi Admin!');
        }
    }

    public function registerSuccess(Member $member)
    {
        return view('public.members.register_success', compact('member'));
    }

    public function login()
    {
        $hasMember = Session::has('member');
        if (!$hasMember) {
            return view('public.members.login');
        }

        return redirect()->route('public.members.login_success');
    }

    public function storeLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'wa_number' => 'required|string',
        ]);

        $member = Member::where('wa_number', $request->wa_number)
            ->where('email', $request->email)
            ->first();

        if (empty($member)) {
            return back()->with('error', 'Email atau Nomor Whatsapp Anda tidak diketahu. Silkan melakukan registrasi');
        }

        Session::put('member', $member);

        return redirect()->route('public.members.login_success')
                ->with('success', 'Login berhasil');
    }

    public function loginSuccess()
    {
        $member = Session::get('member');

        $myEvent = MemberEvent::join('events', 'member_events.event_id', '=', 'events.id')
            ->where('member_events.member_id', $member->id)
            ->get();

        return view('public.members.login_success', compact('member', 'myEvent'));
    }

    public function logout()
    {
        Session::flush('member');
        return view('public.members.login');
    }

    public function adminIndex()
    {
        $members = Member::orderBy('point_total', 'asc')->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'email' => 'required|unique:members,email,' . $member->id,
            'fullname' => 'required',
            'wa_number' => 'required',
            'address' => 'required|string',
            'is_checked' => 'required|integer',
            'date_checked' => Carbon::now(),
        ]);

        $member->update($request->all());

        return redirect()->route('dashboard.members.index')->with('success', 'Member updated successfully!');
    }

    public function storeAttendance(Request $request)
    {
        try {
            $request->validate([
                'identity' => 'required|string',
                'event_id' => 'required|integer',
            ]);

            $identity = 'MRF-MSP-' . $request->identity;

            $event = Event::where('id', $request->event_id)->first();

            $memberAttendance = AttendanceMember::join('members', 'attendance_members.member_id', '=', 'members.id')
                ->where('members.identity', $identity)
                ->where('attendance_members.event_id', $request->event_id)
                ->whereDate('attendance_members.date_attendance', Carbon::now())
                ->first();

            if (!empty($memberAttendance)) {
                $message = 'Member ' . $memberAttendance->identity . ' sudah presensi hari ini pada ' . $memberAttendance->date_attendance;
                return redirect()->route('dashboard.events.attendance', $event)->with('success', $message);
            }

            $member = Member::where('identity', $identity)->first();
            if (empty($member)) {
                $message = 'Identity '. $identity .' is not found';
                return redirect()->route('dashboard.events.attendance', $event)->with('error', $message);
            }

            $newPoint = $member->point_total + $event->point;

            AttendanceMember::create([
                'member_id' => $member->id,
                'event_id' => $request->event_id,
                'date_attendance' => Carbon::now(),
            ]);

            $member->update([
                'point_total' => $newPoint,
            ]);

            return redirect()->route('dashboard.events.attendance', $event)->with('success', 'Member attendance successfully saved!');
        } catch (Exception $e) {
            dd($e);
            return back()->with('error', 'Error saving attendance');
        }
    }

    // public function create()
    // {
    //     return view('admin.events.create');
    // }

    // public function store(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'title' => 'required|unique:events',
    //             'description' => 'required',
    //             'broadcast_text' => 'required',
    //             'image_first' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
    //             'image_second' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
    //             'point' => 'required|integer',
    //         ]);

    //         $imagePath = date('Y') . '/' . date('m') . '/' . date('d') . '/' . 'images';
    //         if ($request->hasFile('image_first') && $request->file('image_first')->isValid()) {
    //             $imageFirstPath = $request->file('image_first')->store($imagePath, 'public');
    //             $imageFirstUrl = Storage::url($imageFirstPath);
    //         } else {
    //             return back()->withErrors(['image_first' => 'Image First is required or invalid']);
    //         }

    //         if ($request->hasFile('image_second') && $request->file('image_second')->isValid()) {
    //             $imageSecondPath = $request->file('image_second')->store($imagePath, 'public');
    //             $imageSecondUrl = Storage::url($imageSecondPath);
    //         }

    //         Event::create([
    //             'title' => $request->title,
    //             'description' => $request->description,
    //             'slug' => Str::slug($request->title),
    //             'broadcast_text' => $request->broadcast_text,
    //             'image_first' => $imageFirstUrl,
    //             'image_second' => $imageSecondUrl,
    //             'point' => $request->point,
    //         ]);

    //         return redirect()->route('dashboard.events.index')->with('success', 'Event created successfully!');
    //     } catch (Exception $e) {
    //         dd($e);
    //         return back()->withErrors(['upload_error' => 'File upload failed. Please try again later.'])
    //                      ->withInput();
    //     }
    // }



    // public function publicShow(Event $event)
    // {
    //     return view('public.event.show', compact('event'));
    // }

    // public function destroy(Event $event)
    // {
    //     $event->delete();
    //     return redirect()->route('dashboard.events.index')->with('success', 'Event deleted successfully!');
    // }
}
