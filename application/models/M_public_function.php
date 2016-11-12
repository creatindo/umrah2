<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_public_function extends MY_Model {

    public function upload_file($config)
    {
        $this->load->library('upload', $config);

        if(!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'],0775,true);
        }

        
        if (!$this->upload->do_upload('x_upload_file')) {
            $error = array('error' => $this->upload->display_errors());
            $response = array(
                'message' => $error
            );
        } else {
            
            $this->load->library('image_lib');
            // upload
            $upload_data = $this->upload->data();
            $targetFile  = $upload_data['full_path'];
            $file_name   = $upload_data['file_name'];
            $raw_name    = $upload_data['raw_name'];
            $file_ext    = $upload_data['file_ext'];
            
            $folder= str_replace("./", "", $config['upload_path']);
            $response =  array(
                
                'upload_data' => $upload_data
            );
            $response['message']="";

            
        }
        return $response;
    }
    /**
     * Create watermark 
     * @param string $image
     * @param string $path
     * @param string $ukuran gambar
     * @return watermark
     */
    public function upload($config)
    {
        $this->load->library('upload', $config);

        if(!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'],0775,true);
        }

        
        if (!$this->upload->do_upload('cover_dokumen')) {
            $error = array('error' => $this->upload->display_errors());
            $response = array(
                'message' => $error
            );
        } else {
            
            $this->load->library('image_lib');
            // upload
            $upload_data = $this->upload->data();
            $targetFile  = $upload_data['full_path'];
            $file_name   = $upload_data['file_name'];
            $image_width = $upload_data['image_width'];
            $raw_name    = $upload_data['raw_name'];
            $file_ext    = $upload_data['file_ext'];
            
            $folder= str_replace("./", "", $config['upload_path']);
            $response =  array(
                
                'upload_data' => $upload_data
            );
            $response['message']="";
            // crop
            if ($this->input->post('w')) {
                $response['message'].=$this->crop($targetFile);
                $image_width = $this->input->post('w');
            }

            // watermark
            //$response['message'].=$this->watermark($targetFile, $image_width);
            // thumnail
            //$response['message'].=$this->thumbnail($targetFile,$raw_name,$file_ext);

            
        }
        return $response;
    }
    public function crop($targetFile)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $targetFile; 
        // $config['new_image'] = './uploads/member/profil/' . $this->ion_auth->get_user_id() . '.jpg';
        $config['width']  = $this->input->post('w');
        $config['height'] = $this->input->post('h');
        $config['x_axis'] = $this->input->post('x');
        $config['y_axis'] = $this->input->post('y');

        $this->image_lib->clear();
        $this->image_lib->initialize($config);

        if(!$this->image_lib->crop()){
            return strip_tags($this->image_lib->display_errors());
        }

        return '';
    }

    function watermark($targetFile, $image_width)
    {
        $path_logo = './theme/global/images/logo-white/';
        if ($image_width > 3000) {
            $wm = $path_logo.'3000.png';
        }else if ($image_width > 2500) {
            $wm = $path_logo.'2500.png';
        }else if ($image_width > 2300) {
            $wm = $path_logo.'2300.png';
        }else if ($image_width > 2200) {
            $wm = $path_logo.'2200.png';
        }else if ($image_width > 2100) {
            $wm = $path_logo.'2100.png';
        }else if ($image_width > 2000) {
            $wm = $path_logo.'2000.png';
        }else if ($image_width > 1900) {
            $wm = $path_logo.'1900.png';
        }else if ($image_width > 1800) {
            $wm = $path_logo.'1800.png';
        }else if ($image_width > 1700) {
            $wm = $path_logo.'1700.png';
        }else if ($image_width > 1600) {
            $wm = $path_logo.'1600.png';
        }else if ($image_width > 1500) {
            $wm = $path_logo.'1500.png';
        }else if ($image_width > 1400) {
            $wm = $path_logo.'1400.png';
        }else if ($image_width > 1300) {
            $wm = $path_logo.'1300.png';
        }else if ($image_width > 1200) {
            $wm = $path_logo.'1200.png';
        }else if ($image_width > 1100) {
            $wm = $path_logo.'1100.png';
        }else if ($image_width > 1000) {
            $wm = $path_logo.'1000.png';
        }else if ($image_width > 900) {
            $wm = $path_logo.'900.png';
        }else if ($image_width > 800) {
            $wm = $path_logo.'800.png';
        }else if ($image_width > 700) {
            $wm = $path_logo.'700.png';
        }else if ($image_width > 600) {
            $wm = $path_logo.'600.png';
        }else if ($image_width > 500) {
            $wm = $path_logo.'500.png';
        }else if ($image_width > 400) {
            $wm = $path_logo.'400.png';
        }else if ($image_width > 300) {
            $wm = $path_logo.'300.png';
        }else if ($image_width > 200) {
            $wm = $path_logo.'200.png';
        }else if ($image_width > 100) {
            $wm = $path_logo.'100.png';
        }else{
            $wm = $path_logo.'50.png';
        }

        $config['image_library']    = 'gd2';
        $config['source_image']     = $targetFile;
        $config['wm_overlay_path']  = $wm;
        $config['wm_opacity']       = 100;
        $config['wm_type']          = 'overlay';
        $config['wm_vrt_alignment'] = 'middle';
        $config['wm_hor_alignment'] = 'center';


        // $this->image_lib->clear();
        $this->image_lib->initialize($config);
        if (!$this->image_lib->watermark()) {
             return strip_tags($this->image_lib->display_errors());
        }
        return '';
    }

    public function thumbnail($targetFile,$raw_name='d',$file_ext)
    {
        $imageNewSize[] = array('width' => 400, 'height'=> 600, 'name'=> 'x4');
        $imageNewSize[] = array('width' => 200, 'height'=> 400, 'name'=> 'x2');
        foreach ($imageNewSize as $key => $value) {
            $config['image_library']  = 'gd2';
            $config['source_image']   = $targetFile;
            $config['new_image']      = $raw_name.'_'.$imageNewSize[$key]['name'].$file_ext;
            // $config['create_thumb']   = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = $imageNewSize[$key]['width'];
            $config['height']         = $imageNewSize[$key]['height'];

            $this->image_lib->clear();
            $this->image_lib->initialize($config);

            if (!$this->image_lib->resize()) {
                return strip_tags($this->image_lib->display_errors());
            }
            return '';

        }
    }
}
