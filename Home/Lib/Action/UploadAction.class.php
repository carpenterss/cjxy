<?php

class UploadAction extends Action
{
//    function __construct(){
//        $this->time=time();
//        $this->display(Customer/customer_x_e_add);
//    }
    //上传操作
    private $type_x_e_qyjbyhls = 0x000001;  //小贷企业基本银行流水
    private $type_x_e_gxht = 0x000002;      //小贷企业购销合同
    private $type_x_e_bb = 0x000003;        //小贷企业报表
    private $type_x_ht = 0x000004;          //小贷业务流程签订合同

    /**
     * @param $filetype 上传文件的类型
     */
    public function upload()
    {
        //导入上传文件类库
        import('ORG.Net.UploadFile');
        //获取ajax信息
        $chunk = I('chunk');
        $name = I('name');
        $token = I('token');
        $timestamp = I('timestamp');
        $verifyToken = md5('unique_salt' . $timestamp);
        $filetype = I('filetype');
        $total = I('total');
        $index = I('index');
        //获取操作员id
        $Uid = $_SESSION['UserId'];
        if ($chunk != 1) {
            //小文件上传
            if (!empty($_FILES) && $token == $verifyToken) {
                //上传参数配置
                $upload = new UploadFile();// 实例化上传类
                //不做大小限制
                $upload->maxSize = 500 * 1024 * 1024;
                $upload->savePath = './Uploads/' . $filetype . '/';
                //不做限制
                $upload->saveRule = I('name');
                $upload->uploadReplace = true;
                $upload->autoSub = 'true';
                $upload->subType = 'date';
                $upload->dateFormat = 'Y-m-d';
                // 上传文件
                $info = $upload->upload();
                if (!$info) {// 上传错误提示错误信息
                    var_dump($upload->getErrorMsg());
                    $data = array(
                        'status' => 0,//状态
                        'info' => $upload->getErrorMsg(),//错误信息
                    );
                } else {// 上传成功
                    $s_info = $upload->getUploadFileInfo();
                    $savename = substr($s_info[0]['savename'], 11);
                    $savepath = $s_info[0]['savepath'] . substr($s_info[0]['savename'], 0, 11);

                    $data = array(
                        // 'savename'=>$info['Filedata']['savename'],//保存名称
                        'savename' => $savename,
                        'savepath' => $savepath,//保存路径
                        'abspath' => $savepath . $savename,//相对路径
                        'filetype' => $filetype,
                        'status' => 1,//状态
                    );
                }
                $this->ajaxReturn($data);
            }
        } elseif ($chunk == 1) {
            //大文件上传
            if (!empty($_FILES) && $token == $verifyToken) {
                $upload = new UploadFile();// 实例化上传类
                $upload->maxSize = 500 * 1024 * 1024;
                $upload->savePath = './Uploads/' . $filetype . '/';
                $upload->autoSub = 'true';
                $upload->subType = 'date';
                $upload->dateFormat = 'Y-m-d';
                $info = $upload->upload();
                if (!$info) {// 上传错误提示错误信息
                    $data = array(
                        'status' => 0,//状态
                        'info' => $upload->getErrorMsg(),//错误信息
                    );
                } else {// 上传成功
                    $s_info = $upload->getUploadFileInfo();
                    $savename = substr($s_info[0]['savename'], 11);
                    $savepath = $s_info[0]['savepath'] . substr($s_info[0]['savename'], 0, 11);
//                    $savename = substr($savename, 0, -1);
                    if($index == 1 && file_exists($savepath . $name . 'donotfunk')){
                        unlink($savepath . $name . 'donotfunk');
                        unlink($savepath . $name);
                    }
                    $record = fopen($savepath . $name . 'donotfunk', "a");
                    $neirong = $savepath . $savename . "\r\n";
                    fwrite($record, $neirong);
                    fclose($record);
                }
                if ($total == $index) {

                    $mov = file_get_contents($savepath . $name . 'donotfunk');           //读取分割文件的信息
                    $list = explode("\r\n", $mov);
                    $fp = fopen($savepath . $name, "ab");                  //合并后的文件名
                    foreach ($list as $value) {
                        if (!empty($value)) {
                            $handle = fopen($value, "rb");
                            fwrite($fp, fread($handle, filesize($value)));
                            fclose($handle);
                            unset($handle);
                            unlink($value);
                        }
                    }
                    fclose($fp);
                    $data = array(
                        // 'savename'=>$info['Filedata']['savename'],//保存名称
                        'savename' => $name . "2",
                        'savepath' => $savepath,//保存路径
                        'abspath' => $savepath . $name,//相对路径
                        'filetype' => $filetype,
                        'status' => 1,//状态
                    );
                    $this->ajaxReturn($data);
                }

            }
        }
    }

    //删除图片
    public function del()
    {
        if (!IS_AJAX) {
            exit('需要AJAX提交信息');
        }
        $img_url = I('post.url');
        $len = strlen(__ROOT__);
        $img_url = substr($img_url, $len);
//        var_dump($img_url);
//        die;
        //获取缩略图地址        
//        $tb_img_url=get_tb_img_url($img_url);
        // echo $tb_img_url;die;
        if (@unlink("." . $img_url)) {
            $data = array(
                'status' => 1,
                'info' => ':)成功删除文件',
            );
        } else {
            $data = array(
                'status' => 0,
                'info' => ':(删除文件失败',
            );
        }
        $this->ajaxReturn($data);
    }

    //修改名称
    public function changeName()
    {
        if (!IS_AJAX) {
            exit('需要AJAX提交信息');
        }

        $old_url = I('post.url');                 //原来的地址
        $len = strlen(__ROOT__);
        $old_url = substr($old_url, $len);    //除去前缀,改成 ./Uploads/...
        $name = I('post.name');                   //新的名称不包含后缀
        $info = pathinfo($old_url);               //获取图片的信息
        $path = $info['dirname'] . '/';             //目录信息
        $ext = $info['extension'];                //后缀信息
        $new_url = $path . $name . '.' . $ext;          //生成新的图片地址信息

        $old_tb = get_tb_img_url($old_url);
        $new_tb = get_tb_img_url($new_url);
        //检查是否有同名文件;目标文件是否存在
        if (!file_exists($old_url)) {
            $data = array(
                'status' => 0,
                'info' => '原文件不存在!',
            );
        } elseif (file_exists($new_url)) {
            $data = array(
                'status' => 0,
                'info' => '新的命名已存在,起冲突,请改换别名!',
            );
        } else {
            $res = @rename($old_url, $new_url);//修改名称
            $res_tb = @rename($old_tb, $new_tb);//修改缩略图名称
            if ($res) {
                $data = array(
                    'status' => 1,
                    'info' => ':)成功修改图片标题',
                    'savepath' => $new_url,
                    'savename' => $name,
                );
            } else {
                $data = array(
                    'status' => 0,
                    'info' => ':(修改失败',
                );
            }
        }

        $this->ajaxReturn($data);
    }

//    function mergeFile($targetFile) {//合并
//        global $cacheFileName;
//        $num = 1;
//        $file = fopen($targetFile, 'wb');
//        while ($num > 0) {
//            $cacheFile = $cacheFileName . $num++ . '.dat';
//            if (file_exists($cacheFile)) {
//                $cfile = fopen($cacheFile, 'rb');
//                $content = fread($cfile, filesize($cacheFile));
//                fclose($cfile);
//                fwrite($file, $content);
//            }
//            else {
//                $num = -1;
//            }
//        }
//        fclose($file);
//    }
}