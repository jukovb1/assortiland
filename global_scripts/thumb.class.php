<?php
/**
 * thumb.class.php
 *
 * Класс создавания превью из больших изображений
 *
 * Данный файл НЕ является частью системы управления контентом
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */


class thumb
{
    private $actual_width;  // актуальная ширина
    private $actual_height; // актуальная высота
    private $filename;      // имя файла
    private $cut;           // статус обрезки по рамке
    private $rotate;        // актуальнок вращение

    private $mime_type_settings = array();
    private $save_status;               // сохранение в файл (по-умолчанию true)
    private $new_name_format    = 'thumb.%s_%sx%s_r%s'; //формат имени thumb
    private $default_width      = 640;  // ширина по-умолчанию
    private $default_height     = 480;  // высота по-умолчанию
    private $jpeg_quality       = 90;   // качество файлов jpeg
    private $default_rotate     = 0;    // поворот по-умолчанию

    public function __construct($save_in_file=true) {

        $this->actual_width = (isset($_GET['w']))?$_GET['w']:false;
        $this->actual_height = (isset($_GET['h']))?$_GET['h']:false;
        if (!$this->actual_width && !$this->actual_height) {
            // вписать в рамку по умолчанию
            $this->actual_width = $this->default_width;
            $this->actual_height = $this->default_height;
        }

        $this->filename = $_GET['name'];
        $this->cut = isset($_GET['c']) || isset($_GET['tc']);

        $this->rotate = (isset($_GET['r']))?$_GET['r']:$this->default_rotate;

        $this->set_mime_types();

        $this->save_status = $save_in_file;
        $this->init();
    }
    
    
    private function init() {
        $info = getimagesize($this->filename);

        if (!file_exists($this->filename) || !is_file($this->filename)) exit;
        if (!$info || !isset($this->mime_type_settings[$info['mime']])) exit;
        
        $settings = $this->mime_type_settings[$info['mime']];

        $cur_width  = $info[0];
        $cur_height = $info[1];
        $dst_x = $dst_y = 0;

        if ($this->rotate!=0){
            $this->rotate = -$this->rotate;
            $this->rotate = intval(-$this->rotate) % 4;
            if ($this->rotate % 2 && $cur_width != $cur_height) {
                list($cur_width, $cur_height) = array($cur_height, $cur_width);
                list($this->actual_width, $this->actual_height) = array($this->actual_height, $this->actual_width);
            }
        }

        if (!$this->actual_width && $this->actual_height) {
            // вписываем по высоте
            $new_width  = $this->actual_width = floor($cur_width * $this->actual_height / $cur_height);
            $new_height = $this->actual_height;
        } elseif ($this->actual_width && !$this->actual_height) {
            // вписываем по ширине
            $new_width  = $this->actual_width;
            $new_height = $this->actual_height = floor($cur_height * $this->actual_width / $cur_width);
        } elseif ($this->cut) {
            // вписываем с обрезкой
            $scale_w = $this->actual_width / $cur_width;
            $scale_h = $this->actual_height / $cur_height;
            $scale = max($scale_w, $scale_h);
            $new_width  = floor($cur_width * $scale);
            $new_height = floor($cur_height * $scale);
            $dst_x = floor(($this->actual_width - $new_width) / 2);
            $dst_y = floor(($this->actual_height - $new_height) / 2);
        } else {
            // вписываем без обрезки
            $scale_w = $this->actual_width / $cur_width;
            $scale_h = $this->actual_height / $cur_height;
            $scale = min($scale_w, $scale_h);
            $new_width  = $this->actual_width = floor($cur_width * $scale);
            $new_height = $this->actual_height = floor($cur_height * $scale);
        }

        if ($this->rotate &&($this->actual_width > $cur_width || $this->actual_height > $cur_height)) {
            header('Content-type: ' . $info['mime']);
            readfile($this->filename);
            exit;
        }

        $thumbFilename = dirname($this->filename) . '/'
            . sprintf($this->new_name_format, basename($this->filename, $settings['ext']), $this->actual_width, $this->actual_height, $this->rotate)
            . $settings['ext']
        ;

        if (file_exists($thumbFilename) && filemtime($thumbFilename) >= filemtime($this->filename)) {
            header('Content-type: ' . $info['mime']);
            readfile($thumbFilename);
            exit;
        }
        $cur_img = call_user_func($settings['create'], $this->filename);
        if ($this->rotate!=0){
            ini_set("memory_limit", "202M");
            $cur_img = imagerotate($cur_img, $this->rotate * 90,0);
        }
        $tmp_img  = imagecreatetruecolor($this->actual_width, $this->actual_height);

        // Copy and resize old image into new image
        imagecopyresampled(
            $tmp_img, $cur_img,
            $dst_x, $dst_y,
            0, 0,
            $new_width, $new_height,
            $cur_width, $cur_height
        );
        imagedestroy($cur_img);
        header('Content-type: ' . $info['mime']);
        call_user_func($settings['save'], $tmp_img, $thumbFilename);
        imagedestroy($tmp_img);
        exit;
    }

    private function save_gif($img, $filename = false) {
        if ($filename !== false && $this->save_status) {
            imagegif($img, $filename);
        }
        imagegif($img);
    }

    private function save_jpg($img, $filename = false) {
        if ($filename !== false && $this->save_status) {
            imagejpeg($img, $filename, $this->jpeg_quality );
        }
        imagejpeg($img, '', $this->jpeg_quality );
    }

    private function save_png($img, $filename = false) {
        if ($filename !== false && $this->save_status) {
            imagepng($img, $filename);
        }
        imagepng($img);
    }


    private function set_mime_types(){
        $this->mime_type_settings = array(
            'image/gif'  => array(
                'ext'       => '.gif',
                'create'    => 'imagecreatefromgif',
                'save'      => array(&$this, 'save_gif'),
            ),
            'image/jpeg'  => array(
                'ext'       => '.jpeg',
                'create'    => 'imagecreatefromjpeg',
                'save'      => array(&$this, 'save_jpg'),
            ),
            'image/jpeg'  => array(
                'ext'       => '.jpg',
                'create'    => 'imagecreatefromjpeg',
                'save'      => array(&$this, 'save_jpg'),
            ),
            'image/pjpeg'  => array(
                'ext'       => '.jpg',
                'create'    => 'imagecreatefromjpeg',
                'save'      => array(&$this, 'save_jpg'),
            ),
            'image/png'  => array(
                'ext'       => '.png',
                'create'    => 'imagecreatefrompng',
                'save'      => array(&$this, 'save_png'),
            ),
        );
    }

}
