<?php
/**
 * Created by PhpStorm.
 * User: wuchuanchuan
 * Date: 2018/8/21
 * Time: 下午2:58
 */

namespace App\Handlers;
use PhpOffice\PhpSpreadsheet\IOFactory;


class XlsReaderHandler
{

    protected $extensions = ['xls' => 'Xls', 'xlsx' => 'Xlsx', 'csv' => 'Csv'];

    public function __construct()
    {

    }

    public function read($file_path,$extension)
    {
        if (!isset($this->extensions[strtolower($extension)])) {
            return false;
        }
        $file_type = $this->extensions[strtolower($extension)];
        $reader = IOFactory::createReader($file_type);
        $spreadsheet = $reader->load($file_path);
        return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    }

}