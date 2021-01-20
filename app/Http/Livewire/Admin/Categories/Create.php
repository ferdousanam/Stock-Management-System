<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\ProductCategory;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public $categories;
    public $data;

    protected $listeners = ['addCategory'];

    public function addCategory()
    {
        $this->dispatchBrowserEvent('showAddModal');
    }

    public function mount()
    {
        $this->categories = ProductCategory::all();
        $this->data = new ProductCategory();
    }

    public function submit($formData)
    {
        ProductCategory::create([
            'code' => str_pad(rand(0, pow(10, 6)-1), 6, '0', STR_PAD_LEFT),
            'title' => $formData['title'],
            'parent_id' => $formData['parent_id'],
            'slug' => Str::slug($formData['title']),
            'description' => $formData['description'],
        ]);
        $this->dispatchBrowserEvent('hideAddModal');
    }

    public function render()
    {
        return view('livewire.admin.categories.create');
    }
}
