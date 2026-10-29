<?php

namespace App\View\Components;

use App\Models\BookCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = BookCategory::orderBy('name', 'asc')->get();
        // mengambil data kategori setiap component/navbar.blade.php dipake
        return view('components.navbar', [
            // nama yang dipake di blade navbarCategories    
            'navbarCategories' => $categories
        ]);
    }
}
