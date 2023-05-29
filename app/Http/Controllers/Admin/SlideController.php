<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateSlideValidator;
use App\Models\Slide;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $active = "slides";
        $slides = Slide::paginate(5);
        return view('backend.slides.index', compact('active', 'slides'));
    }

    public function store(CreateSlideValidator $request)
    {
        DB::beginTransaction();

        try {
            $params = $request->all();

            if (data_get($params, 'image')) {
                foreach ($params['image'] as $file) {
                    $path = Storage::putFileAs('slides', $file, $file->getClientOriginalName());
                    Slide::create([
                        'image' => $path
                    ]);
                }
            }

            Session::flash('messages_success', 'Đã thêm slide thành công');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ['status' => false];
        }

        return ['status' => true];
    }

    public function delete()
    {
        DB::beginTransaction();
        
        try {
            Slide::where('id', request()->input('id'))->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ['status' => false];
        }

        return ['status' => true];
    }
}
