<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Modal extends Component
{
    public $isOpen = false;
    public $modalId = '';
    public $title = '';
    public $content = '';
    public $modalSize = 'md'; // sm, md, lg, xl
    public $showFooter = true;
    public $confirmText = 'Confirm';
    public $cancelText = 'Close';

    #[On('open-modal')]
    public function openModal($data = [])
    {
        $this->isOpen = true;
        $this->modalId = $data['modalId'] ?? 'default-modal';
        $this->title = $data['title'] ?? 'Modal Title';

        $content = $data['content'] ?? '';
        $this->content = $this->resolveContent($content);

        $this->modalSize = $data['size'] ?? 'md';
        $this->showFooter = $data['showFooter'] ?? true;
        $this->confirmText = $data['confirmText'] ?? 'Confirm';
        $this->cancelText = $data['cancelText'] ?? 'Close';
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetExcept('isOpen');
    }

    public function confirm()
    {
        $this->dispatch('modal-confirmed', modalId: $this->modalId);
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.modal');
    }

    protected function resolveContent($content)
    {
        if (empty($content)) return '';

        if (is_object($content) || class_exists($content)) {
            return $content;
        }

        if (is_string($content) && str_starts_with($content, 'App\\Livewire\\')) {
            $class = str_replace('\\\\', '\\', $content);
            if (class_exists($class)) {
                return $class;
            }
        }

        return $content;
    }
}
