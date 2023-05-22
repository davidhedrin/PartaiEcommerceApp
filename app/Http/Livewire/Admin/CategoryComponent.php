<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Exception;

use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class CategoryComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $image;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'image' => 'required',
        ]);
    }
    
    public function saveKagetoriToDb()
    {
        $this->validate([
            'name' => 'required',
            'image' => 'required',
        ]);
    }

    public function loadAllData()
    {
        $allCategory = Category::all();
        return [
            'allCategory' => $allCategory
        ];
    }

    public function render()
    {
        return view('livewire.admin.category-component', $this->loadAllData())->layout('layouts.admin');
    }
}
