<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

	public function index()
	{
			
	}

	public function dd($m='')
	{

		$this->load->model($m);
		$limit   =$this->input->post('limit');
		$page    =$this->input->post('page')-1;
		if ($this->input->post('q')) {
			$this->db->like($this->$m->label, $this->input->post('q'));
		}
		$this->db->limit($limit,($page*$limit));
		$data_db =$this->{$m}->get_all();
		$res     =array();
		if ($data_db) {
			foreach ($data_db as $r) {
				$item=array();
				$item['id']    = $r->{$this->$m->primary_key};
				$item['title'] = $r->{$this->$m->label};

				$res[] = $item;
			}
		}
		$output["items"]=$res;
		$output["total_count"]=$this->{$m}->count_rows();
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function route()
	{
		$this->load->model('Menu_model');
		$w = array('controller IS NOT NULL' => NULL );
		$s=$this->Menu_model->get_all($w);
		if ($s) {
			foreach ($s as $r) {
				echo '$route[\''.$r->link.'\'] = \''.$r->controller.'\'; <br/>';
			}
		}
	}

}

/* End of file Form.php */
/* Location: ./application/controllers/Form.php */