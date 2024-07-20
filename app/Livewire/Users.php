<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public function message($userId)
    {
        $authId = auth()->id();
        # check conversation exists
        $existingConversation = Conversation::where(function ($query) use ($authId, $userId) {
            $query->where('sender_id', $authId)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($authId, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $authId);
        })->first();

        if ($existingConversation) {
            return redirect()->route('chat', ['query'=>$existingConversation->id]);
        }
        
        # create conversation
        $createConversation = Conversation::create([
            'sender_id' => $authId,
            'receiver_id' => $userId
        ]);

        return redirect()->route('chat', ['query' => $createConversation->id]);
    }

    public function render()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('livewire.users', compact('users'));
    }
}
