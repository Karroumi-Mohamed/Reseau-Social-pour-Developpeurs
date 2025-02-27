<?php

namespace App\View\Components\Profile;

use App\Models\User;
use Illuminate\View\Component;

class PictureForm extends Component
{
    public function __construct(
        public User $user
    ) {}

    public function render()
    {
        return view('components.profile.picture-form');
    }
}