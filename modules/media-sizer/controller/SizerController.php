<?php
/**
 * SizerController
 * @package media-sizer
 * @version 0.0.1
 */

namespace MediaSizer\Controller;

use LibUpload\Model\Media;
use LibMedia\Formatter\Media as _Media;

class SizerController extends \MediaSizer\Controller
{
    public function resizeAction(){
        $file = $this->req->param->file;
        $file = implode('/', $file);

        $comp = null;

        if(preg_match('!\.[a-z]+\.(webp)$!', $file, $match)){
            $file = preg_replace('!\.(webp|avif)$!', '', $file);
            $comp = $match[1];
        }

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

        $opt->file = ltrim($opt->file, '/');

        $media = Media::getOne(['path'=>$opt->file]);
        if(!$media)
            return $this->show404();
        $urls = json_decode($media->urls);
        $opt->file = $urls[0];

        $format = _Media::single([$opt->file], 'file', [], $opt, []);
        $object = $format[$opt->file] ?? null;
        if(!$object)
            return $this->show404();

        $object->setForce(true);
        if(isset($opt->size)){
            $osize  = '_' . $opt->size->width . 'x' . $opt->size->height;
            $object = $object->{$osize};
        }

        $final_url = $object->target;
        
        if($comp)
            $final_url = $object->{$comp};

        if($final_url != $this->req->url)
            return $this->res->redirect($final_url, 301);

        $base = $this->config->libUpload->base ?? null;
        if(!$base)
            $base = (object)['local'=>'media','host'=>''];

        $base_file = null;
        $host_len  = strlen($base->host);
        $file_host = substr($final_url, 0, $host_len);

        $path = substr($final_url, $host_len);
        $target_file = realpath(BASEPATH . '/' . $base->local . '/' . $path);
        if(!$target_file || !is_file($target_file)){
            $opt->compression = $comp;
            $args = isset($opt->size)
                ? [$opt->size->width, $opt->size->height]
                : [null, null];
            if($comp)
                $args[] = $comp;

            if(!call_user_func_array([$object, 'reManipulate'], $args))
                return $this->show404();

            $target_file = realpath(BASEPATH . '/' . $base->local . '/' . $path);
            if(!$target_file)
                return $this->show404();
        }

        $file_mime = mime_content_type($target_file);
        header('Content-Type: ' . $file_mime);
        readfile($target_file);
        exit;
    }
}