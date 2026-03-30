<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentBoard extends Component
{
    public $user_name = '';
    public $text = '';

    protected $rules = [
        'user_name' => 'required|string|max:100',
        'text' => 'required|string|max:1000',
    ];

    public function submit()
    {
        $this->validate();

        Comment::create([
            'user_name' => $this->user_name,
            'text' => $this->text,
            'is_admin_reply' => false,
        ]);

        $this->reset(['text']);
    }

    public function render()
    {
        return view('livewire.comment-board', [
            'comments' => Comment::whereNull('reply_to_id')
                ->with('replies')
                ->latest()
                ->take(20)
                ->get(),
        ]);
    }
}
