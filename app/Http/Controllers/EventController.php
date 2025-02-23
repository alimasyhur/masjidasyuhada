<?php

namespace App\Http\Controllers;

use App\Models\AttendanceMember;
use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\MemberEvent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $events = Event::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->get();
        return view('public.event.home', compact('events'));
    }

    public function adminIndex()
    {
        $events = Event::paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|unique:events',
                'description' => 'required',
                'broadcast_text' => 'required',
                'image_first' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
                'image_second' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                'point' => 'required|integer',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);

            $imagePath = date('Y') . '/' . date('m') . '/' . date('d') . '/' . 'images';
            if ($request->hasFile('image_first') && $request->file('image_first')->isValid()) {
                $imageFirstPath = $request->file('image_first')->store($imagePath, 'public');
                $imageFirstUrl = Storage::url($imageFirstPath);
            } else {
                return back()->withErrors(['image_first' => 'Image First is required or invalid']);
            }

            if ($request->hasFile('image_second') && $request->file('image_second')->isValid()) {
                $imageSecondPath = $request->file('image_second')->store($imagePath, 'public');
                $imageSecondUrl = Storage::url($imageSecondPath);
            }

            Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'slug' => Str::slug($request->title),
                'broadcast_text' => $request->broadcast_text,
                'image_first' => $imageFirstUrl,
                'image_second' => $imageSecondUrl,
                'point' => $request->point,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return redirect()->route('dashboard.events.index')->with('success', 'Event created successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['upload_error' => 'File upload failed. Please try again later.'])
                         ->withInput();
        }
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function attendance(Event $event)
    {
        $attendanceMembers = AttendanceMember::select(
                'attendance_members.event_id',
                'attendance_members.member_id',
                'members.identity',
                'members.email',
                'members.fullname',
                'members.wa_number',
                'attendance_members.date_attendance',
            )->join('members', 'attendance_members.member_id', '=', 'members.id')
            ->where('attendance_members.event_id', $event->id)
            ->orderBy('attendance_members.date_attendance', 'desc')
            ->get();

        $totalAttendance = count($attendanceMembers);

        return view('admin.events.attendance', compact('event', 'attendanceMembers', 'totalAttendance'));
    }

    public function publicShow(Event $event)
    {
        $member = Session::get('member');
        $eventID = $event->id;

        $isRegistered = false;
        $isLogin = false;

        if (!empty($member)) {
            $memberID = $member->id;
            $memberEvent = MemberEvent::where('member_id', $memberID)
                ->where('event_id', $eventID)
                ->first();

            $isLogin = true;
            if (!empty($memberEvent)) {
                $isRegistered = true;
            }
        }

        return view('public.event.show', compact('event', 'isRegistered', 'isLogin'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|unique:events,title,' . $event->id,
            'description' => 'required',
            'broadcast_text' => 'required',
            'image_first' => 'required|string',
            'image_second' => 'required|string',
            'point' => 'required|integer',
        ]);

        $event->update($request->all());

        return redirect()->route('dashboard.events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('dashboard.events.index')->with('success', 'Event deleted successfully!');
    }

    public function register(Event $event)
    {
        $member = Session::get('member');
        $existMemberEvent = MemberEvent::where('member_id', $member->id)
            ->where('event_id', $event->id)
            ->count();
        if (empty($existMemberEvent)) {
            MemberEvent::create([
                'event_id' => $event->id,
                'member_id' => $member->id,
            ]);
        }

        return redirect()->route('event.show', $event)->with('success', 'Berhasil mendaftar event!');
    }
}
