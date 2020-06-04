<?php

namespace App\Http\Controllers;

use App\Models\Entires;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        $entires = Entires::all();
        $log = Log::orderBy('updated_at', 'DESC')->get();
        return view('welcome')
            ->with('entires', $entires)
            ->with('log', $log);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => true,
                'message' => 'You need to provide a valid data.'
            ]);
        } else {
            $entires = Entires::select('*')->where('id', $request->input('id'))->get();

            if (count($entires) == 1) {
                return view('edit')->with('entires', $entires);
            } else {
                return redirect()->back()->with([
                    'error' => true,
                    'message' => 'No data available with the provided id.'
                ]);
            }
        }
    }
}
