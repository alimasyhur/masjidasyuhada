<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;

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

            $randomDigit = rand(1, 9999);
            $suffixDigit = str_pad($randomDigit, 4, '0', STR_PAD_LEFT);
            $prefixIdentity = 'RF-MSP-' . date('Y') . date('m') . date('d') . $suffixDigit;
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
            return back()->with('error', 'Email atau Nomor Whatsapp Anda sudah terdaftar');
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

        return view('public.members.login_success', compact('member'));
    }

    public function logout()
    {
        Session::flush('member');
        return view('public.members.login');
    }

    // public function adminIndex()
    // {
    //     $events = Event::paginate(10);
    //     return view('admin.events.index', compact('events'));
    // }

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

    // public function show(Event $event)
    // {
    //     return view('admin.events.show', compact('event'));
    // }

    // public function publicShow(Event $event)
    // {
    //     return view('public.event.show', compact('event'));
    // }

    // public function edit(Event $event)
    // {
    //     return view('admin.events.edit', compact('event'));
    // }

    // public function update(Request $request, Event $event)
    // {
    //     $request->validate([
    //         'title' => 'required|unique:events,title,' . $event->id,
    //         'description' => 'required',
    //         'broadcast_text' => 'required',
    //         'image_first' => 'required|string',
    //         'image_second' => 'required|string',
    //         'point' => 'required|integer',
    //     ]);

    //     $event->update($request->all());

    //     return redirect()->route('dashboard.events.index')->with('success', 'Event updated successfully!');
    // }

    // public function destroy(Event $event)
    // {
    //     $event->delete();
    //     return redirect()->route('dashboard.events.index')->with('success', 'Event deleted successfully!');
    // }
}
