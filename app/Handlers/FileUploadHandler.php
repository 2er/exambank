<?php
/**
 * Created by PhpStorm.
 * User: wuchuanchuan
 * Date: 2018/8/20
 * Time: 上午10:03
 */
namespace App\Handlers;

class FileUploadHandler
{
    protected $allowed_ext = ["xls", "xlsx"];

    public function save($file, $folder)
    {
        // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
        // 文件夹切割能让查找效率更高。
        $folder_name = "uploads/files/$folder/" . date("Ym/d", time());

        // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
        // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
        $upload_path = public_path() . '/' . $folder_name;

        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'xlsx';

        $filename =  date('His') . '_' . $file->getClientOriginalName();

        // 如果上传的不是允许的文件格式将终止操作
        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 将文件移动到我们的目标存储路径中
        $file->move($upload_path, $filename);

        return [
            'path' => "$upload_path/$filename",
            'extension' => $extension
        ];
    }
}
