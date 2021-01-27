<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\ProductCategory;
use Livewire\Component;

class Edit extends Component
{
    public $categories;
    public $category_id;
    public $data;
    public $dataToUpdate;

    protected $listeners = ['editCategory' => 'editCategory'];

    public function mount()
    {
        //
    }

    public function editCategory($id)
    {
        $this->categories = ProductCategory::all();
        $this->category_id = $id;
        $this->data = ProductCategory::find($id);
        $this->dispatchBrowserEvent('showEditModal');
    }

    public function submit($formData)
    {
        $this->data->update([
            'title' => $formData['title'],
            'parent_id' => $formData['parent_id'],
            'description' => $formData['description'],
        ]);
        $this->dispatchBrowserEvent('hideEditModal');
    }

    public function render()
    {
        return view('livewire.admin.categories.edit');
    }
}
