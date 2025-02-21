<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
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
            ]);

            return redirect()->route('dashboard.events.index')->with('success', 'Event created successfully!');
        } catch (Exception $e) {
            dd($e);
            return back()->withErrors(['upload_error' => 'File upload failed. Please try again later.'])
                         ->withInput();
        }
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function publicShow(Event $event)
    {
        return view('public.event.show', compact('event'));
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
}
