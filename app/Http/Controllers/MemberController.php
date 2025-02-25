<?php

namespace App\Http\Controllers;

use App\Models\AttendanceMember;
use App\Models\Event;
use App\Models\Member;
use App\Models\MemberEvent;
use App\Models\Relawan;
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

    public function loginMsp()
    {
        return view('public.members.login_msp');
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

            $relawan = Relawan::where('wa_number', $request->wa_number)
                ->where('email', $request->email)
                ->first();

            if (!empty($relawan)) {
                return back()->with('error', 'Email atau Nomor Whatsapp Anda sudah terdaftar sebagai relawan. Tidak dapat mendaftar sebagai member');
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

        if (!empty($member)) {
            Session::put('member', $member);

            return redirect()->route('public.members.login_success')
                ->with('success', 'Login berhasil');
        }

        $relawan = Relawan::where('wa_number', $request->wa_number)
                ->where('email', $request->email)
                ->first();

        if (!empty($relawan)) {
            Session::put('relawan', $relawan);

            return redirect()->route('public.relawans.login_success')
                ->with('success', 'Login berhasil');
        }

        return back()->with('error', 'Email atau Nomor Whatsapp Anda tidak diketahu. Silkan melakukan registrasi');
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
        Session::flush('relawan');
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
}
