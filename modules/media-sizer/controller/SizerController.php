<?php
/**
 * SizerController
 * @package media-sizer
 * @version 0.0.1
 */

namespace MediaSizer\Controller;

use LibMedia\Library\Local;
use LibUpload\Model\Media;

class SizerController extends \MediaSizer\Controller
{
    public function resizeAction(){
        $file = $this->req->param->file;
        $file = implode('/', $file);

        $webp = false;
        $file = preg_replace('!\.webp$!', '', $file, -1, $count);
        if($count)
            $webp = true;

        $opt = (object)[
            'file' => $file
        ];

        if(preg_match('!_([0-9]+)x([0-9]+)\.([a-z]+)$!i', $file, $match)){
            $opt->size = (object)[
                'width' => $match[1],
                'height'=> $match[2]
            ];
            $opt->file = preg_replace('!_([0-9]+)x([0-9]+)\.([a-z]+)$!i', '.$3', $file);
        }

        $media = Media::getOne(['path'=>$opt->file]);
        $urls  = json_decode($media->urls);
        $opt->file = $urls[0];

        $result = Local::get($opt);
        if(!$result)
            return $this->show500();
        
        $target = $result->none;
        if($webp && isset($result->webp))
            $target = $result->webp;

        $file = dirname($result->base) . '/' . basename($target);
        if(!is_file($file))
            return $this->show404();

        $file_mime = mime_content_type($file);
        header('Content-Type: ' . $file_mime);
        readfile($file);
        exit;
    }
}