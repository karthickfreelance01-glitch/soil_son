<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FollowUpController extends Controller
{
    public function index()
    {
        $patients = DB::table('patients')->get();

        $followups = DB::table('follow_ups')
            ->join('patients','patients.id','=','follow_ups.patient_id')
            ->select(
                'follow_ups.*',
                'patients.ip_number',
                'patients.name',
                'patients.present_address as address'
            )
            ->get();

        return view('followup.index',compact('patients','followups'));
    }

    public function getPatient($id)
    {
        return DB::table('patients')->where('id',$id)->first();
    }

    public function store(Request $request)
    {
        DB::table('follow_ups')->insert([
            'patient_id' => $request->patient_id,
            'op_number'  => $request->op_no,
            'status'     => $request->status,
            'feedback'   => $request->feedback,
            'created_at' => now()
        ]);
    
        return response()->json(['success'=>true]);
    }


   public function edit($id)
    {
        return DB::table('follow_ups')
            ->join('patients','follow_ups.patient_id','=','patients.id')
            ->select(
                'follow_ups.*',
                'patients.ip_number',
                'patients.name',
                'patients.present_address'
            )
            ->where('follow_ups.id',$id)
            ->first();
    }

    public function update(Request $request,$id)
    {
        DB::table('follow_ups')
            ->where('id',$id)
            ->update([
                'op_number' => $request->op_no,
                'status'    => $request->status,
                'feedback'  => $request->feedback
            ]);
    
        return response()->json(['success'=>true]);
    }


    public function delete($id)
    {
        DB::table('follow_ups')->where('id',$id)->delete();
        return back();
    }
}
