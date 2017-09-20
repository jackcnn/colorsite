<?php
/**
 * Date: 2016/7/8
 * Time: 14:33
 */
namespace yii\helpers;
use yii\base\NotSupportedException;

/**
 *自己写的helper
 *
 */
class UHelper
{

    /*
     * 利用phpqrcode 生成二维码图片
     * */
    public static function qrcode($text='', $outfile = false, $box=[0,0] , $level = 3, $size = 14, $margin = 2, $saveandprint=false)
    {
        include \Yii::getAlias('@vendor').'/phpqrcode/phpqrcode.php';
        if($outfile){
            \yii\helpers\FileHelper::createDirectory(dirname($outfile));
        }
        \phpqrcode\QRcode::png($text,$outfile,$level,$size,$margin,$saveandprint);

        if($box[0]>0 && $box[1]>0){//修改图片尺寸
            \yii\imagine\Image::thumbnail($outfile,$box[0],$box[1])->save($outfile);
        }
    }

    /*
     * phpexcel生成需要的缓存文件
     *$title,$data 出入数组
     * */
    public static function phpexcelSetCache($title,$data,$cacheName){

        $cache=new \yii\caching\FileCache();


        $title=$cache->set('phpexceltitle_'.$cacheName,$title);

        $data=$cache->set('phpexceldata_'.$cacheName,$data);


    }

    /*
     *根据缓存的数据生成excel文件
     * */
    public static function downloadExcel($cacheName){

        $cache=new \yii\caching\FileCache();

        $title=$cache->get('phpexceltitle_'.$cacheName);
        $data=$cache->get('phpexceldata_'.$cacheName);


        require_once(\Yii::getAlias('@vendor').'/phpexcel/PHPExcel.php');

        // Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();


        // Set document properties
        $objPHPExcel->getProperties()->setCreator("LURONGZE")
            ->setLastModifiedBy("LURONGZE")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        /*
         * Add some data
         * */
        $letters=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

        $sheet=$objPHPExcel->setActiveSheetIndex(0);

        /*
         * 设置头部信息
         * */
        foreach($title as $k=>$v){

            $sheet->setCellValue($letters[$k].'1', $v);

            $sheet->getColumnDimension($letters[$k])->setWidth(20);

        }

        /*
         * 添加数据
         * */
        foreach($data as $key=>$value){
            $i=0;
            foreach($value as $k=>$v){

                $sheet->setCellValue($letters[$i].($key+2), $v);
                $i++;
            }
        }


        $cache->delete('phpexceltitle_'.$cacheName);

        $cache->delete('phpexceldata_'.$cacheName);


        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('导出时间：'.date('Y年m月d日H时i分s秒',time()));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }


}