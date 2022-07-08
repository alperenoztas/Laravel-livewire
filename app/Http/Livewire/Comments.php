<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;

class Comments extends Component
{

    public $comments =[
        [
            'body' => 'Lorem ipsum dolor sit amet consectetur.',
            'created_at' => '3 min ago',
            'creator' => 'Alperen'
        ],
    ];

    public function addComment(){

        array_unshift($this->comments,[
            'body' => $this->newComment,
            'created_at' => Carbon::now()->diffForHumans(),
            'creator' => 'Ayla'
        ]);

        $this->newComment="";
    }

    public $newComment;

    public function render()
    {
        return view('livewire.comments');
    }
}
