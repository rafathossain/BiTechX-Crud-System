<?php

namespace App\Http\Controllers;

use App\Models\Entires;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    private function createLog($email, $action, $ip){
        $newLog = new Log();
        $newLog->email = $email;
        $newLog->action = $action;
        $newLog->ip = $ip;
        $newLog->save();
    }

    public function addEntires(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'file' => 'required|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => true,
                'message' => 'Your provided data is invalid.'
            ]);
        } else {
            $email = $request->input('email');
            $password =  Hash::make($request->input('password'));
            
            $checkExisting = Entires::select('*')->where('email', $email)->get();

            if(count($checkExisting) == 0){
                $filePath = $request->file('file')->store('public/files');

                $newEntire = new Entires();
                $newEntire->email = $email;
                $newEntire->password = $password;
                $newEntire->file = $filePath;

                if($newEntire->save()){
                    $this->createLog($email, 'Added Entires', $request->ip());

                    return redirect()->back()->with([
                        'error' => false,
                        'message' => 'Your entires has been added to database.'
                    ]);
                } else {
                    $this->createLog($email, 'Something went wrong.', $request->ip());

                    return redirect()->back()->with([
                        'error' => true,
                        'message' => 'Something went wrong. Please try again.'
                    ]);
                }
            } else {
                $this->createLog($email, 'Email already exist in the database.', $request->ip());

                return redirect()->back()->with([
                    'error' => true,
                    'message' => 'Your email address already exist in the database.'
                ]);
            }
        }
    }

    public function updateEntires(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'file' => 'required|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => true,
                'message' => 'Your provided data is invalid.'
            ]);
        } else {
            $id = $request->input('id');
            $email = $request->input('email');
            $password =  Hash::make($request->input('password'));
            
            $checkExisting = Entires::select('*')->where('id', $id)->get();

            if(count($checkExisting) == 1){
                Storage::delete($checkExisting[0]->file);
                $filePath = $request->file('file')->store('public/files');

                $update = Entires::where('id', $id)->update([
                    'email' => $email,
                    'password' => $password,
                    'file' => $filePath
                ]);

                if($update){
                    $this->createLog($email, 'Information updated', $request->ip());

                    return redirect('/')->back()->with([
                        'error' => false,
                        'message' => 'Your entires has been updated.'
                    ]);
                } else {
                    $this->createLog($email, 'Something went wrong.', $request->ip());

                    return redirect()->back()->with([
                        'error' => true,
                        'message' => 'Something went wrong. Please try again.'
                    ]);
                }
            } else {
                $this->createLog($email, 'No entires found in the database.', $request->ip());

                return redirect()->back()->with([
                    'error' => true,
                    'message' => 'No entires found in the database.'
                ]);
            }
        }
    }

    public function deleteEntires(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Your provided data is invalid.'
            ]);
        } else {
            $id = $request->input('id');
            
            $checkExisting = Entires::select('*')->where('id', $id)->get();

            if(count($checkExisting) == 1){
                Storage::delete($checkExisting[0]->file);

                $delete = Entires::where('id', $id)->delete();

                if($delete){
                    $this->createLog($checkExisting[0]->email, 'Entry deleted successfully.', $request->ip());

                    return response()->json([
                        'error' => false,
                        'message' => 'Your entry has been deleted.'
                    ]);
                } else {
                    $this->createLog($checkExisting[0]->email, 'Something went wrong.', $request->ip());

                    return response()->json([
                        'error' => true,
                        'message' => 'Something went wrong. Please try again.'
                    ]);
                }
            } else {
                $this->createLog("N/A", 'No entires found in the database.', $request->ip());

                return response()->json([
                    'error' => true,
                    'message' => 'No entires found in the database.'
                ]);
            }
        }
    }
}
