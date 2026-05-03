<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class PagesController extends Controller
{
    public function about()
    {
        $photo = file_exists(public_path('assets/about.jpg')) ? 'assets/about.jpg' : null;
        return view('about')->with('photo', $photo);
    }

    public function uploadAboutPhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image']);
        $request->file('photo')->move(public_path('assets'), 'about.jpg');
        return redirect()->route('about');
    }

    public function services()
    {
        return view('services');
    }

    public function contacts()
    {
        return view('contacts');
    }

    public function storeMessage(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'subject' => 'nullable|string|max:255',
            'body'    => 'required|string',
        ], [
            'body.required' => 'Напишіть повідомлення.',
        ]);

        Message::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'body'    => $request->body,
        ]);

        return redirect()->route('contacts')->with('message_sent', true);
    }

    public function adminMessages()
    {
        $messages = Message::with('user')->orderBy('is_read')->orderByDesc('created_at')->get();
        return view('admin.messages')->with('messages', $messages);
    }

    public function markRead($id)
    {
        $message = Message::findOrFail($id);
        $message->is_read = true;
        $message->save();
        return redirect()->route('admin.messages');
    }
}