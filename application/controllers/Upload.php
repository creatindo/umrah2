<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {


	var $pathFolder = array(
		'profile' => 'uploads/profil/', 
		'temp'    => 'uploads/temp/', 
		'video'   => 'uploads/video/', 
		'file'    => 'uploads/file/', 
		'image'    => 'uploads/image/', 
		);


	public function single()
	{
		$this->load->helper('security');
		

		$name = ($this->input->post('name')) ? $this->input->post('name') : do_hash(date("Y/m/d h:i:sa")) ; 
		$title = ($this->input->post('title')) ? $this->input->post('title') : "Form upload" ; 
		$photo = ($this->input->post('photo')) ? $this->input->post('photo') : "" ; 
		$ratio = ($this->input->post('ratio')) ? $this->input->post('ratio') : "1" ; 
		$folder = ($this->input->post('folder')) ? $this->input->post('folder') : "temp" ; 

		$upload_url = ($this->input->post('upload_url')) ? $this->input->post('upload_url') : site_url("upload/do_upload") ; 

		$data = array(
			'title'         => $title, 
			'photo'         => $photo, 
			'upload_url'    => $upload_url, 
			'folder'        => $folder, 
			'targetImgId'   => $this->input->post('targetImgId'),
			'hiddenInputId' => $this->input->post('hiddenInputId'),
			'ratio'         => $ratio,
			'new_name'      => $name
			);
		$this->load->view('modal/v_upload_single', $data, FALSE);
	}

	public function multi()
	{
		$this->load->helper('security');
		
		// $name = ($this->input->post('name')) ? $this->input->post('name') : do_hash(date("Y/m/d h:i:sa")) ; 
		// $title = ($this->input->post('title')) ? $this->input->post('title') : "Form upload" ; 
		// $photo = ($this->input->post('photo')) ? $this->input->post('photo') : "" ; 
		// $ratio = ($this->input->post('ratio')) ? $this->input->post('ratio') : "1" ; 
		$folder = ($this->input->post('folder')) ? $this->input->post('folder') : "gallery" ; 
		// $upload_url = ($this->input->post('upload_url')) ? $this->input->post('upload_url') : site_url("member/upload/do_upload") ; 

		$data = array(
			// 'title' => $title, 
			// 'photo' => $photo, 
			// 'upload_url' => $upload_url, 
			'folder' => $folder, 
			// 'targetImgId' => $this->input->post('targetImgId'),
			// 'hiddenInputId' => $this->input->post('hiddenInputId'),
			// 'ratio'=>$ratio,
			// 'new_name'=>$name,
			'id' => $this->input->post('id')
			);
		$this->load->view('modal/v_upload_multi', $data, FALSE);
	}

	public function do_upload()
	{
		// Default response value
		$response['success'] = FALSE;
        $response['message'] = 'Maaf, telah terjadi kesalahan.';

        if (empty($_FILES['cover_dokumen']['tmp_name'])) 
        {
        	$response['message'] = 'Foto belum ada.';
        }
        else
        {
        	$new_name = $this->input->post('new_name');

        	$this->load->helper('security');
			$targetPath              = $this->pathFolder[$this->input->post('folder')];

			$config['upload_path']   = "./".$targetPath;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']      = '5000';
			$config['overwrite']     = true;
			$config['file_name']     = $this->input->post('new_name');

			$this->load->model('m_public_function');
	        $upload_result = $this->m_public_function->upload($config);

	        if (empty($upload_result['message'])) {
	        	$response['file_name'] = $upload_result['upload_data']['file_name'];
                $response['url_image'] = base_url($targetPath).'/'.$upload_result['upload_data']['file_name'];
	        	$response['success'] = TRUE;
	        	$response['message'] = 'Upload berhasil';
	        } 
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function do_upload_multi()
	{
		// Default response value
		$response['success'] = FALSE;
        $response['message'] = 'Maaf, telah terjadi kesalahan.';

        if (empty($_FILES['cover_dokumen']['tmp_name'])) 
        {
        	$response['message'] = 'Foto belum ada.';
        }
        else
        {
        	$new_name = $this->input->post('new_name');
        	$id = $this->input->post('id');

        	$this->load->helper('security');
			$targetPath              = $this->pathFolder[$this->input->post('folder')].$id ;

			$config['upload_path']   = "./".$targetPath;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']      = '5000';
			// $config['overwrite']      = true;
			// $config['file_name']     = $this->input->post('new_name');

			$this->load->model('m_public_function');
	        $upload_result = $this->m_public_function->upload($config);
			

	        if (empty($upload_result['message'])) {
	        	$filename = $upload_result['upload_data']['file_name'];
				$filename_ext = pathinfo($filename, PATHINFO_EXTENSION);
				$thumb_filename = preg_replace('/^(.*)\.' . $filename_ext . '$/', '$1_x4.' . $filename_ext, $filename);
				
				$response['files'][0]['url']          =base_url($targetPath).'/'.$filename;
				$response['files'][0]['thumbnailUrl'] =base_url($targetPath).'/'.$thumb_filename;
				$response['files'][0]['name']         =$upload_result['upload_data']['file_name'];
				$response['files'][0]['type']         =$upload_result['upload_data']['file_type'];
				$response['files'][0]['size']         =$upload_result['upload_data']['file_size'];
				$response['files'][0]['deleteUrl'] 		=  base_url() . 'admin/gallery/delete_img/' .$id.'/'. urlencode($filename);
	            $response['files'][0]['deleteType'] 	= 'DELETE';

	            //custome save database
	            $this->load->model('m_t_gallery');
	            $data_insert = array(
	            	's_info_id' => $id,
	            	'gallery_image'=> $filename
	            	);
	            $this->m_t_gallery->insert($data_insert);

	        	$response['success'] = TRUE;
	        	$response['message'] = 'Upload berhasil';
	        } 
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function rename_file()
	{
		$info = $this->db->get('s_info');

		foreach ($info->result() as $i) {
			if (isset($i->info_img_display)) {
				# code...
				$file    = $i->info_img_display;
				$file2   = explode('.', $file);
				$filenew = $file2[0].'_x4.'.$file2[1];

				$oldDir = FCPATH . 'uploads/info_img/'.$file;
				$newDir = FCPATH . 'uploads/info_img/'.$i->info_id.'.'.$file2[1];

				$oldDir2 = FCPATH . 'uploads/info_img/'.$filenew;
				$newDir2 = FCPATH . 'uploads/info_img/'.$i->info_id.'_x4.'.$file2[1];
				if (file_exists($oldDir)) {
					rename($oldDir, $newDir);
					rename($oldDir2, $newDir2);
					// unlink($oldDir);				
				}
			}


			// $this->db->set('info_img_display', $i->info_id.'.jpg')
			// 		->where('info_id', $i->info_id)
			// 		->update('s_info');
		}

		$pegawai = $this->db->get('m_pegawai');

		foreach ($pegawai->result() as $j) {
			if (isset($j->pegawai_img)) {
				# code...
				$file    = $j->pegawai_img;
				$file2   = explode('.', $file);
				$filenew = $file2[0].'_x4.'.$file2[1];

				$oldDir = FCPATH . 'uploads/pegawai/'.$file;
				$newDir = FCPATH . 'uploads/pegawai/'.$j->pegawai_id.'.'.$file2[1];

				$oldDir2 = FCPATH . 'uploads/pegawai/'.$filenew;
				$newDir2 = FCPATH . 'uploads/pegawai/'.$j->pegawai_id.'_x4.'.$file2[1];
				if (file_exists($oldDir)) {
					rename($oldDir, $newDir);
					rename($oldDir2, $newDir2);
					// unlink($oldDir);				
				}
			}


			// $this->db->set('pegawai_img', $j->pegawai_id.'.jpg')
			// 		->where('pegawai_id', $j->pegawai_id)
			// 		->update('m_pegawai');
		}
	}


	public function do_upload_file()
	{
		// Default response value
		$response['success'] = FALSE;
        $response['message'] = 'Maaf, telah terjadi kesalahan.';


        	$new_name = $this->input->post('new_name');

        	$this->load->helper('security');
        	$folder 	= ($this->input->post('folder')) ? $this->input->post('folder') : "temp" ;
			$targetPath              = $this->pathFolder[$folder];

			$config['upload_path']   = "./".$targetPath;
			$config['allowed_types'] = '*';
			$config['overwrite']     = true;

			$this->load->model('m_public_function');
	        $upload_result = $this->m_public_function->upload_file($config);

	        if (empty($upload_result['message'])) {
	        	$response['file_name'] = $upload_result['upload_data']['file_name'];
                $response['url_file'] = base_url($targetPath).'/'.$upload_result['upload_data']['file_name'];
	        	$response['success'] = TRUE;
	        	$response['message'] = 'Upload berhasil';
	        }else{
	        	$response['message'] = $upload_result['message'];
	        } 
        

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

}

/* End of file upload.php */
/* Location: ./application/controllers/member/upload.php */