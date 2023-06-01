<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeButton extends Component
{
    public $model;
    public $likesCount;
    public $liked;

    public function mount($model)
    {
        $this->model = $model;
        $this->likesCount = $model->likes()->count();
        $this->liked = $model->likedBy(Auth::user()->id);
    }

    public function toggleLike()
    {
        if ($this->liked) {

            $this->model->unlike();
            $this->likesCount--;
            $this->liked = false;
        } else {

            if ($this->model->like()) {
                $this->likesCount++;
                $this->liked = true;
            }

        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
