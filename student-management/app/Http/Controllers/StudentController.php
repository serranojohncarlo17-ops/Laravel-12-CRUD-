<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    /** Display all Student
    */

    public function index()
    {
        $students = Student::latest()->get();

        return view('students.index', compact('students'));
        //
    }



    /**
     * Show the form for creating a new resource.
     * SHOWS THE FORM
     */
    public function create()
    {
        return view('students.create'); 
        //
    }



    /**
     * Store a newly created resource in storage.
     * CREATE: SAVE A NEW STUDENT
     */
    public function store(Request $request)
    {
        $validated = $request->validate([ 
            'student_number' => 
'required|string|max:50|unique:students,student_number', 
            'first_name' => 'required|string|max:255', 
            'last_name' => 'required|string|max:255', 
            'email' => 
'required|email|max:255|unique:students,email', 
            'course' => 'required|string|max:255', 
        ]); 
 
        Student::create($validated); 
 
        return redirect()->route('students.index') 
            ->with('success', 'Student added successfully!');
        //
    }



    /**
     * Display the specified resource.
     * READ: Display a specific student
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
        //
    }



    /**
     * Show the form for editing the specified resource.
     * UPDATE: show the edit form
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
        //
    }



    /**
     * Update the specified resource in storage.
     * UPDATE: save changes
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([ 
            'student_number' => [ 
                'required', 
                'string', 
                'max:50', 
                Rule::unique('students', 'student_number')
>ignore($student->id), 
            ], 
            'first_name' => 'required|string|max:255', 
            'last_name' => 'required|string|max:255', 
            'email' => [ 
                'required', 
                'email', 
                'max:255', 
                Rule::unique('students', 'email')
>ignore($student->id), 
            ], 
            'course' => 'required|string|max:255', 
        ]); 
 
        $student->update($validated); 
 
        return redirect()->route('students.index') 
            ->with('success', 'Student updated successfully!'); 
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE: remove a student
     */
    public function destroy(Student $student)
    {
        $student->delete(); 
 
        return redirect()->route('students.index') 
            ->with('success', 'Student deleted successfully!');
        //
    }
}
