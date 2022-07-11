<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public $newComment;


    public function updated($field){

        $this->validateOnly($field,[
            'newComment'=>'required|max:255'
        ]);

    }

    public function addComment(){

        $this->validate(
            ['newComment'=>'required']
        );

        $createdComment = Comment::create(
            ['body'=>$this->newComment,
            'user_id'=> 1]);

        $this->newComment="";

        session()->flash('message','Comment added successfully');
    }

    public function remove($commentId){
        $comment = Comment::find($commentId)->delete();

        session()->flash('message','Comment deleted successfully');

    }

    public function render()
    {
        return view('livewire.comments',[
            'comments' => Comment::latest()->paginate(4)
        ]);
    }
}
