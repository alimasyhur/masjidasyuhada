<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRelawan;
use App\Models\Member;
use App\Models\Relawan;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class RelawanController extends Controller
{
    public function index()
    {
        return view('public.relawans.index');
    }

    public function register()
    {
        return view('public.relawans.register');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string',
                'fullname' => 'required|string',
                'wa_number' => 'required|string',
                'address' => 'required|string',
                'frequency' => 'required|integer',
            ]);

            $existingRelawan = Relawan::where('wa_number', $request->wa_number)
                ->where('email', $request->email)
                ->first();

            if ($existingRelawan) {
                return back()->with('error', 'Email atau Nomor Whatsapp Anda sudah terdaftar');
            }


            $member = Member::where('wa_number', $request->wa_number)
                ->where('email', $request->email)
                ->first();

            if (!empty($member)) {
                return back()->with('error', 'Email atau Nomor Whatsapp Anda sudah terdaftar sebagai member. Tidak dapat mendaftar sebagai relawan');
            }

            $threeDigitPhone = substr($request->wa_number, -3);
            $randomDigit = rand(1, 999);
            $suffixDigit = str_pad($randomDigit, 3, '0', STR_PAD_LEFT);
            $prefixIdentity = 'RRF-MSP-' . $threeDigitPhone . $suffixDigit;
            Relawan::create([
                'identity' => $prefixIdentity,
                'email' => $request->email,
                'fullname' => $request->fullname,
                'wa_number' => $request->wa_number,
                'address' => $request->address,
                'frequency'=> $request->frequency,
                'is_checked' => false,
            ]);

            $relawan = Relawan::where('identity', $prefixIdentity)->first();

            return redirect()->route('public.relawans.register_success')
                ->with('success', 'Berhasil melakukan pendaftaran relawan')
                ->with('relawan', $relawan);
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi Kesalahan. Hubungi Admin!');
        }
    }

    public function registerSuccess(Relawan $relawan)
    {
        return view('public.relawans.register_success', compact('relawan'));
    }

    public function login()
    {
        $hasRelawan = Session::has('relwan');
        if (!$hasRelawan) {
            return view('public.relawans.login');
        }

        return redirect()->route('public.relawans.login_success');
    }

    public function storeLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'wa_number' => 'required|string',
        ]);

        $relawan = Relawan::where('wa_number', $request->wa_number)
            ->where('email', $request->email)
            ->first();

        if (empty($relawan)) {
            return back()->with('error', 'Email atau Nomor Whatsapp Anda tidak diketahui. Silkan melakukan registrasi');
        }

        Session::put('relawan', $relawan);

        return redirect()->route('public.relawans.login_success')
                ->with('success', 'Login berhasil');
    }

    public function loginSuccess()
    {
        $relawan = Session::get('relawan');

        return view('public.relawans.login_success', compact('relawan'));
    }

    public function logout()
    {
        Session::flush('relawan');
        return view('public.relawans.login');
    }

    public function adminIndex()
    {
        $relawans = Relawan::paginate(10);
        return view('admin.relawans.index', compact('relawans'));
    }

    public function show(Relawan $relawan)
    {
        return view('admin.relawans.show', compact('relawan'));
    }

    public function edit(Relawan $relawan)
    {
        return view('admin.relawans.edit', compact('relawan'));
    }

    public function update(Request $request, Relawan $relawan)
    {
        $request->validate([
            'email' => 'required|unique:relawans,email,' . $relawan->id,
            'fullname' => 'required',
            'wa_number' => 'required',
            'address' => 'required|string',
            'is_checked' => 'required|integer',
            'date_checked' => Carbon::now(),
        ]);

        $relawan->update($request->all());

        return redirect()->route('dashboard.relawans.index')->with('success', 'Relawan updated successfully!');
    }

    public function storeAttendance(Request $request)
    {
        try {
            $request->validate([
                'identity' => 'required|string',
            ]);

            $identity = 'RRF-MSP-' . $request->identity;

            $relawanAttendance = AttendanceRelawan::join('relawans', 'attendance_relawans.relawan_id', '=', 'relawans.id')
                ->where('relawans.identity', $identity)
                ->whereDate('attendance_relawans.date_attendance', Carbon::now())
                ->first();

            if (!empty($relawanAttendance)) {
                $message = 'Relawan ' . $relawanAttendance->identity . ' sudah presensi hari ini pada ' . $relawanAttendance->date_attendance;
                return redirect()->route('dashboard.relawans.index')->with('success', $message);
            }

            $relawan = Relawan::where('identity', $identity)->first();
            if (empty($relawan)) {
                $message = 'Identity '. $identity .' is not found';
                return redirect()->route('dashboard.relawans.index')->with('error', $message);
            }

            AttendanceRelawan::create([
                'relawan_id' => $relawan->id,
                'date_attendance' => Carbon::now(),
            ]);

            return redirect()->route('dashboard.relawans.index', $relawan)->with('success', 'Relawan attendance successfully saved!');
        } catch (Exception $e) {
            dd($e);
            return back()->with('error', 'Error saving attendance');
        }
    }
}
