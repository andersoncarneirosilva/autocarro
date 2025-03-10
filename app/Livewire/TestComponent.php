<?php

namespace App\Livewire;

use Livewire\Component;

class TestComponent extends Component
{
    protected $layout = 'components.layouts.app'; // Verifique aqui

    public function render()
    {
        return view('livewire.test-component');
    }
}
