<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = DB::table('internships')->latest()->get();
        return view('intership.index', compact('internships'));
    }

    public function store(Request $r)
    {
        DB::table('internships')->insert([
            'student_details' => $r->student_details,
            'training_period' => $r->training_period,
            'pronoun'         => $r->pronoun,
            'created_at'      => now()
        ]);

        return response()->json(true);
    }

    public function edit($id)
    {
        return DB::table('internships')->where('id',$id)->first();
    }

    public function update(Request $r,$id)
    {
        DB::table('internships')->where('id',$id)->update([
            'student_details' => $r->student_details,
            'training_period' => $r->training_period,
            'pronoun'         => $r->pronoun,
            'updated_at'      => now()
        ]);

        return response()->json(true);
    }

    public function delete($id)
    {
        DB::table('internships')->where('id',$id)->delete();
        return back();
    }

    public function view($id)
    {
        $internship = DB::table('internships')->where('id',$id)->first();
        return view('intership.view',compact('internship'));
    }
}
