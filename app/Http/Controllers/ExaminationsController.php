<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationRequest;

class ExaminationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Examination $examination)
	{
	    $examinations = $examination->withOrder($request->order)->paginate(20);
		return view('examinations.index', compact('examinations'));
	}

    public function show(Examination $examination)
    {
        return view('examinations.show', compact('examination'));
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