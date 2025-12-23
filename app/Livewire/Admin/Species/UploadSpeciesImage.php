<?php

namespace App\Livewire\Admin;

use App\Models\Species as model;
use App\Helpers\ImageHelper;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class UploadSpeciesImage extends Component
{
    use WithPagination;

    public $model = model::class;
    public $view = 'livewire.admin.upload-species-image';

    public function render()
    {
        
        return view($this->view, compact('species'));
    }
}
