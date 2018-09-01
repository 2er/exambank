<?php

namespace App\Http\Controllers;
use App\Handlers\DocChangeHandler;
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

    public function show(DocChangeHandler $changer, Examination $examination)
    {
        $file_path = public_path('/uploads/files/examinations/'.$examination->file_path);
        $file_name = pathinfo($file_path,PATHINFO_FILENAME);
        $html_file_path = public_path('/uploads/files/examinations/html/'.$file_name.'.html');

        if (!file_exists($html_file_path)) {
            $change_res = $changer->change($file_path,'HTML');
            if ($change_res == false) {
                return redirect()->back()->with('danger','试卷预览失败');
            }
        }

        $html = file_get_contents($html_file_path);
        $html = preg_replace('/<title>PHPWord<\/title>/','<title>'.$examination->title.'</title>',$html);

        return $html;
    }

    public function export(Request $request, Examination $examination)
    {
        $examinations = $request->examinations;

        if (empty($examinations)) {
            return response()->json([
                'status' => '0',
                'msg' => '请先选中导出试卷'
            ]);
        }

        $zip_url = $examination->createZipByExaminationIds($examinations);
        if ($zip_url == false) {
            return response()->json([
                'status' => '0',
                'msg' => '导出失败'
            ]);
        }

        // 修改试卷状态
        $update_res = $examination->updateExaminationsStatus($examinations);
        if ($update_res == false) {
            return response()->json([
                'status' => '0',
                'msg' => '导出失败'
            ]);
        }

        return response()->json([
            'status' => '1',
            'url' => $zip_url
        ]);
    }

    /*//
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
    //*/
}