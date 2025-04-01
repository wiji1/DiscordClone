<?php

namespace App\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public $isOpen = false;
    public $modalId = '';
    public $title = '';
    public $content = '';
    public $modalSize = 'md'; // sm, md, lg, xl

    protected $listeners = ['open-modal' => 'openModal', 'close-modal' => 'closeModal'];

    public function openModal($data = [])
    {
        logger($data);

        $this->isOpen = true;
        $this->modalId = $data['modalId'] ?? 'default-modal';
        $this->title = $data['title'] ?? 'Modal Title';
        $this->content = $data['content'] ?? '';
        $this->modalSize = $data['size'] ?? 'md';
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
