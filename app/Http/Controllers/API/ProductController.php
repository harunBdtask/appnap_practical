<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->with('category')->get();
        $data = collect($products)->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'category' => $item->category->title,
                'price' => $item->price,
                'document_path' => $item->document_path,
            ];
        });
        return response()->json($data);
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
    
    public function save(Request $request)
    {
        $id = $request->get('id') ?? null;
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $path = $file->move('post-documents/', $fileName);
            $request->merge(['document_path' => $path]);
        }
        if ($id) {
            $product = Product::findOrFail($id);
            if ($product->document_path && $request->hasFile('document')) {
                File::delete(public_path($product->document_path));
            }
            $product->update($request->all());
        }else {
            $product = new Product($request->all());
            $product->save();
        }
        return response()->json('The data successfully saved');
    }
    
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if ($product->document_path) {
            File::delete(public_path($product->document_path));
        }
        $product->delete();
        return response()->json('The data successfully deleted');
    }

    public function categories()
    {
        $categories = Category::query()->get();
        return response()->json($categories, 200);
    }
}