<?php

namespace App\Http\Controllers;

use App\Models\History;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function getHistories()
    {
        return response()->json(['status' => true , 'data' => 'getHistories']);
    }

    public function getHistoryById($id)
    {
        $history = History::find($id);
        return response()->json(['status' => true , 'dataHistory' => $history]);
    }

    public function getHistory()
    {
        $history = History::where('user_id' , Auth::user()->id)->get();
        return response()->json(['status' => true , 'dataHistory' => $history]);
    }
    public function create(Request $request)
    {

        $item = new History;
        $item->type = $request->input('type');
        $item->user_id = Auth::user()->id;
        $item->user_name = Auth::user()->name;
        $item->category_id = $request->input('category_id');
        $item->category_name = $request->input('category_name');
        $item->amount = $request->input('amount');
        $item->remark = $request->input('remark');
        $item->time_date = Carbon::parse($request->input('date'));
        $item->save();
        return response()->json(['status' => true , 'data' => 'create']);
    }
    public function update(Request $request , $id)
    {
        $item = History::find($id);
        $item->type = $request->input('type');
        $item->user_id = Auth::user()->id;
        $item->user_name = Auth::user()->name;
        $item->category_id = $request->input('category_id');
        $item->category_name = $request->input('category_name');
        $item->amount = $request->input('amount');
        $item->remark = $request->input('remark');
        $item->time_date = Carbon::parse($request->input('date'));
        $item->save();
        return response()->json(['status' => true , 'data' => 'update']);
    }
    public function delete($id)
    {
        $item = History::find($id)->delete();
        return response()->json(['status' => true , 'data' => 'delete']);
    }
    //
}
