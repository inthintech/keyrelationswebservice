<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ytm extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function __construct()
    {
      	parent::__construct();
        // Your own constructor code
        $this->load->model('ytmdata','',TRUE);
        $this->load->database();
    }
	
	public function getgenrelist()
	{
		$this->output->set_content_type('application/json');
		$output = array();
		$result = $this->ytmdata->returnGenre();
		if($result){
			foreach($result as $row)
			{
				array_push($output,array(
					'id'=>$row->id,
					'name'=>$row->name,
				));

			}
		}	
		else {
			$this->output->set_status_header('503');
			exit;
		}
		$this->output->set_output(json_encode($output));
	
	}	
}