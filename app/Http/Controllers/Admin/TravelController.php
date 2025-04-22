<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelCategory;
use App\Models\TravelPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TravelController extends Controller
{
    // Category CRUD
    public function categories(Request $request)
    {
        $query = TravelCategory::query();
        
        // Apply search if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('category_id', 'like', "%{$search}%")
                  ->orWhere('category_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $categories = $query->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category = new TravelCategory();
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category created successfully');
    }

    public function editCategory($id)
    {
        $category = TravelCategory::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category = TravelCategory::findOrFail($id);
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully');
    }

    public function deleteCategory($id)
    {
        $category = TravelCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully');
    }

    // Package CRUD
    public function packages(Request $request)
    {
        $query = TravelPackage::with('category');
        
        // Apply search if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('package_id', 'like', "%{$search}%")
                  ->orWhere('package_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('duration', 'like', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('category_name', 'like', "%{$search}%");
                  });
            });
        }
        
        $packages = $query->latest()->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    public function createPackage()
    {
        $categories = TravelCategory::all();
        return view('admin.packages.create', compact('categories'));
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:travel_categories,category_id',
            'package_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'duration' => 'required|string',
            'location' => 'required|string',
            'include_facilities' => 'required|string',
            'exclude_facilities' => 'required|string',
            'max_people' => 'required|integer|min:1',
            'available_seats' => 'required|integer|min:0',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean'
        ]);

        $package = new TravelPackage();
        $package->fill($request->except('image_url'));

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('packages', 'public');
            $package->image_url = $path;
        }

        $package->save();

        return redirect()->route('admin.packages')->with('success', 'Package created successfully');
    }

    public function editPackage($id)
    {
        $package = TravelPackage::findOrFail($id);
        $categories = TravelCategory::all();
        return view('admin.packages.edit', compact('package', 'categories'));
    }

    public function updatePackage(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:travel_categories,category_id',
            'package_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'duration' => 'required|string',
            'location' => 'required|string',
            'include_facilities' => 'required|string',
            'exclude_facilities' => 'required|string',
            'max_people' => 'required|integer|min:1',
            'available_seats' => 'required|integer|min:0',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $package = TravelPackage::findOrFail($id);
        $package->fill($request->except(['image_url', 'is_active']));
        $package->is_active = $request->has('is_active');

        if ($request->hasFile('image_url')) {
            // Delete old image if exists
            if ($package->image_url) {
                Storage::disk('public')->delete($package->image_url);
            }
            $path = $request->file('image_url')->store('packages', 'public');
            $package->image_url = $path;
        }

        $package->save();

        return redirect()->route('admin.packages')->with('success', 'Package updated successfully');
    }

    public function deletePackage($id)
    {
        $package = TravelPackage::findOrFail($id);
        if ($package->image_url) {
            Storage::disk('public')->delete($package->image_url);
        }
        $package->delete();

        return redirect()->route('admin.packages')->with('success', 'Package deleted successfully');
    }
} 