<?php

namespace App\Http\Controllers\FAQs;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:faqs');
    }
    public function index()
    {
        $faq =Faq::get();
        if ($faq->count() > 0) {
            return responseApi(200, 'Response posts data successfully', $faq);
        }
        return responseApi(404, 'No Faqs found.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'question.*' =>'required|string',
            'answer.*' =>'required|string',
        ]);
        $faq = Faq::create($request->all());
        return responseApi(201, 'Faq created successfully.', $faq);
    }
    public function update(Request $request,$faq_id)
    {
        $request->validate([
            'question.*' =>'required|string',
            'answer.*' =>'required|string',
        ]);
        try{
            DB::beginTransaction();
            $faq = Faq::whereId($faq_id)->first();
            if (!$faq) {
                return responseApi(404, 'faq not found.');
            }
            $faq->update($request->except(['_method']));
            DB::commit();
            return responseApi(200, 'faq updated successfully');
        }catch (\Exception $e) {
            DB::rollBack();
            return responseApi(500, 'Failed to update faq.');
        }
    }
    public function destroy($faq_id)
    {
        $faq = Faq::whereId($faq_id)->first();
        if (!$faq) {
            return responseApi(404, 'faq not found.');
        }
        $faq->delete();
        return responseApi(204, 'faq deleted successfully');
    }
}
