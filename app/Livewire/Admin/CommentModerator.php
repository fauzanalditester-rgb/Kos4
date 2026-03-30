<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class CommentModerator extends Component
{
    use WithPagination;

    public $replyText = '';
    public $replyingTo = null;

    public function reply($commentId)
    {
        $this->replyingTo = $commentId;
        $this->replyText = '';
    }

    public function submitReply()
    {
        $this->validate(['replyText' => 'required|string|max:1000']);

        Comment::create([
            'user_name' => 'Owner',
            'text' => $this->replyText,
            'is_admin_reply' => true,
            'reply_to_id' => $this->replyingTo,
        ]);

        $this->reset(['replyText', 'replyingTo']);
    }

    public function delete($id)
    {
        Comment::findOrFail($id)->delete();
    }

    public function cancelReply()
    {
        $this->reset(['replyText', 'replyingTo']);
    }

    public function render()
    {
        return view('livewire.admin.comment-moderator', [
            'comments' => Comment::whereNull('reply_to_id')->with('replies')->latest()->paginate(10),
        ])->layout('layouts.admin');
    }
}
