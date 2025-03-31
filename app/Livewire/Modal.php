<?php
// app/Livewire/Modal.php
namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Modal extends Component
{
    public $show = false;
    public $title = 'Modal Title';
    public $modalId = 'livewire-modal';

    #[On('open-modal')]
    public function openModal($modalId = null): void
    {
        echo "openModal\n";
        print "openModal\n";
        if ($modalId === null || $modalId === $this->modalId) {
            $this->show = true;
        }
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
