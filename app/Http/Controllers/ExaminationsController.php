<?php

namespace App\Http\Controllers;
use App\Models\Examination;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationRequest;
use App\Handlers\FileUploadHandler;
use App\Handlers\XlsReaderHandler;

class ExaminationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function plan(Request $request, FileUploadHandler $uploader, XlsReaderHandler $reader, Examination $examination)
    {
        $data = $request->all();

        if ($request->plan) {
            $result = $uploader->save($request->plan, 'plans');
            if ($result) {
                $data['plan'] = $result['path'];
                $data['extension'] = $result['extension'];
            } else {
                return redirect()->back()->with('danger','考试计划上传失败');
            }
        } else {
            return redirect()->back()->with('danger','请上传考试计划');
        }

        $plan_data = $reader->read($data['plan'],$data['extension']);
        if ($plan_data == false) {
            return redirect()->back()->with('danger','考试计划读取失败');
        }

        $examinations = $examination->getExaminationsByPlan($plan_data,$msg);
        if ($examinations == false) {
            return redirect()->back()->with('danger',$msg);
        }

        return view('examinations.index', compact('examinations'));
    }

	public function select(Request $request, Subject $subject)
	{
	    $subject_id = $request->subject_id;
	    $branch_id = $request->branch_id;
	    $department_id = $request->department_id;

	    $examinations = $subject->getExaminationsBySelect(compact('subject_id','branch_id','department_id'),$msg);

        return view('examinations.index', compact('examinations'));
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