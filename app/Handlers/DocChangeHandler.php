<?php
/**
 * Created by PhpStorm.
 * User: wuchuanchuan
 * Date: 2018/8/21
 * Time: 下午2:58
 */

namespace App\Handlers;

use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class DocChangeHandler
{

    protected $writers = array('Word2007' => 'docx', 'ODText' => 'odt', 'RTF' => 'rtf', 'HTML' => 'html', 'PDF' => 'pdf');

    protected $extensions = ['doc','docx'];

    public function __construct()
    {
        $dompdfPath = base_path('vendor/dompdf/dompdf');
        Settings::loadConfig();
        if (file_exists($dompdfPath)) {
            Settings::setPdfRenderer(Settings::PDF_RENDERER_DOMPDF, $dompdfPath);
        }

        if (null === Settings::getPdfRendererPath()) {
            $this->writers['PDF'] = null;
        }
    }

    protected function check_writer($format)
    {
        return in_array($format,array_keys($this->writers));
    }

    public function change($sourceFile,$format)
    {

        if (!file_exists($sourceFile)) {
            return false;
        }

        $extension = pathinfo($sourceFile,PATHINFO_EXTENSION);

        if (!in_array(strtolower($extension),$this->extensions)) {
            return false;
        }

        if (!$this->check_writer($format)) {
            return false;
        }

        $file_name = pathinfo($sourceFile,PATHINFO_FILENAME);
        $php_word = IOFactory::load($sourceFile);

        $target_file = public_path('/uploads/files/examinations/html/') . $file_name . '.' . $this->writers[$format];

        return $php_word->save($target_file,$format);

    }

}