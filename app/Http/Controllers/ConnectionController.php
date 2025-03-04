<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use App\Notifications\ConnectionAcceptedNotification;
use App\Notifications\ConnectionRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function index(){
        $user = Auth::user();

        $pendingRequests = $user->receivedConnections()->where('status', 'pending')
            ->with('sender')
            ->where('status', 'pending')
            ->get();

        $connections = $user->connections()
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function ($connection) use ($user) {
                $connectedUser = $connection->sender_id == $user->id
                    ? $connection->receiver
                    : $connection->sender;

                return [
                    'connection' => $connection,
                    'user' => $connectedUser
                ];
            });

        return view('connections.index', compact('pendingRequests', 'connections'));
    }

    public function sendRequest(User $user) {
        $sender = Auth::user();

        $existingConnection = Connection::where(function ($query) use ($sender, $user) {
            $query->where('sender_id', $sender->id)
                ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($sender, $user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $sender->id);
        })->first();

        if ($existingConnection) {
            return redirect()->back()->with('error', 'Connection request already sent');
        }

        $connection = Connection::create([
            'sender_id' => $sender->id,
            'receiver_id' => $user->id,
            'status' => 'pending'
        ]);

        $user->notify(new ConnectionRequestNotification($sender));

        return redirect()->back()->with('success', 'Connection request sent');
    }

    public function accept(Connection $connection) {
        if ($connection->receiver_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $connection->update([
            'status' => 'accepted'
        ]);

        $connection->sender->notify(new ConnectionAcceptedNotification(Auth::user()));

        return redirect()->back()->with('success', 'Connection request accepted');
    }

    public function reject(Connection $connection) {
        if ($connection->receiver_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $connection->update([
            'status' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Connection request rejected');
    }

    public function remove(Connection $connection) {
        $user = Auth::user();

        if ($connection->sender_id !== $user->id && $connection->receiver_id !== $user->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $connection->delete();

        return redirect()->back()->with('success', 'Connection removed');
    }
}
