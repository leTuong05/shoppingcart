<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductValidator;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function showCreateForm()
    {
        $active = "products";
        $categories = Category::all();

        return view('backend.products.form-create', compact('categories', 'active'));
    }

    public function create(ProductValidator $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            
            $params['slug'] = Str::slug($params['name']);
            
            $product = Product::create($params);

            if (data_get($params, 'image')) {
                foreach ($params['image'] as $file) {
                    $path = Storage::putFileAs('images', $file,  $file->getClientOriginalName());

                    ProductImage::create([
                        'image' => $path,
                        'product_id' => $product->id
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->withErrors(['message_error'=>'Fail Create!!!']);
        }
        
        return redirect()->route('admin.product');
    }

    public function showEditForm($id)
    {
        $active = "products";
        $product = Product::where('id', $id)->first();
        $categories = Category::all();

        return view('backend.products.form-edit', compact('product','categories', 'active'));
    }

    public function update(ProductValidator $request, ProductImage $productImage,  $id)
    {   
        DB::beginTransaction();
        try {
            $params = $request->all();

            $product = Product::find($id);

            $params['slug'] = Str::slug($params['name']);

            $product->update([
                'name' => $params['name'],
                'description' => $params['description'],
                'category_id' => $params['category_id'],
                'slug' => $params['slug'],
                'price' => $params['price'],
                'quantity' => $params['quantity'],
            ]);

            if (data_get($params, 'image')) {
                foreach ($params['image'] as $file) {
                    // tu file 0 -> file 9
                    $path = Storage::putFileAs('images', $file,  $file->getClientOriginalName());

                    ProductImage::create([
                        'image' =>  $path,
                        'product_id' => $product->id
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->withErrors(['message_error'=>'Fail Create!!!']);
        }
        return redirect()->route('admin.product');
    }

    public function delete($id)
    {
        Product::where('id', $id)->delete();

        return response()->json([
            'success' => 'Record has been deleted successfully!'
        ]);
    }
    
    public function index()
    {
        $active = 'products';
        $params = request()->all();
        $search = $params['search'] ?? '';
        $products = Product::where('name', 'LIKE', "%{$search}%")->paginate(10);
        $categories = Category::all();

        return view('backend.products.index', compact('products', 'search', 'categories', 'active'));
    }

    
}
