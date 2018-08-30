<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationRequest;

class ExaminationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Subject $subject)
	{
	    $subject_id = $request->subject_id;

	    if (empty($subject_id)) {
            return redirect()->back()->with('danger','请先选择课程');
        }

        $subject = $subject->find($subject_id);

	    $examinations = $subject->roundExaminationsGroupBySubjectIds([$subject_id]);

        $subjects = $subject->all();

		return view('examinations.index', compact('examinations', 'subjects', 'subject'));
	}

    public function show(Examination $examination)
    {
        $file_path = $examination->file_path;
        $file_name = pathinfo($file_path,PATHINFO_FILENAME);
        $html_file_path = public_path('/uploads/files/examinations/'.$file_name.'.html');
        return file_get_contents($html_file_path);
    }

	public function create(Examination $examination)
	{
		return view('examinations.create_and_edit', compact('examination'));
	}

	public function store(ExaminationRequest $request)
	{
		$examination = Examination::create($request->all());
		return redirect()->route('examinations.show', $examination->id)->with('message', 'Created successfully.');
	}

	public function edit(Examination $examination)
	{
        $this->authorize('update', $examination);
		return view('examinations.create_and_edit', compact('examination'));
	}

	public function update(ExaminationRequest $request, Examination $examination)
	{
		$this->authorize('update', $examination);
		$examination->update($request->all());

		return redirect()->route('examinations.show', $examination->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Examination $examination)
	{
		$this->authorize('destroy', $examination);
		$examination->delete();

		return redirect()->route('examinations.index')->with('message', 'Deleted successfully.');
	}
}