<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class Comments extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $newComment;
    public $image;

    protected $listeners = ['fileUpload'=>'handleFileUpload'];

    public function handleFileUpload($imageData){
        $this->image = $imageData;

    }


    public function updated($field){

        $this->validateOnly($field,[
            'newComment'=>'required|max:255'
        ]);

    }

    public function addComment(){

        $this->validate(
            ['newComment'=>'required']
        );
        $this->storeImage();

        $createdComment = Comment::create([
            'body'=>$this->newComment,
            'user_id'=> 1,
            'image'=>$this->image,

        ]);

        $this->newComment= "";
        $this->image    ="";

        session()->flash('message','Comment added successfully');
    }

    public function storeImage(){
        if(!$this->image){
            return null;
        }

        $img = ImageManagerStatic::make($this->image)->encode('jpg');
        $name = Str::random().'.jpg';
        Storage::disk('public')->put($name,$img);
        return $name;
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
