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
	
	// do not use language parameters since the cast and director are aplicable for all language.
	public function getFilterData($type)
	{
		$this->output->set_content_type('application/json');
		$output = array();
		$result = $this->ytmdata->returnFilterData($type);
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
	
	//use language filter
	public function getFilterList($type,$lang)
	{
		$this->output->set_content_type('application/json');
		$output = array();
		$result = $this->ytmdata->returnFilterList($type,$lang);
		if($result){
			foreach($result as $row)
			{
				array_push($output,array(
					'id'=>$row->id,
					'name'=>$row->name,
					'count'=>$row->cnt
				));

			}
		}	
		else {
			$this->output->set_status_header('503');
			exit;
		}
		$this->output->set_output(json_encode($output));
	
	}
	
	public function getMovieList($type,$lang,$filterId)
	{
		//type = 0 for all movies
		$this->output->set_content_type('application/json');
		$output = array();
		$result = $this->ytmdata->returnMovieList($type,$lang,$filterId);
		if($result){
			foreach($result as $row)
			{
				array_push($output,array(
					'name'=>$row->movie_name,
					'release_year'=>$row->release_year,
					'link'=>$row->youtube_link
				));

			}
		}	
		else {
			$this->output->set_status_header('503');
			exit;
		}
		$this->output->set_output(json_encode($output));
	
	}
	
	public function putNewMovie($name,$year,$link,$actor,$actress,$director,$genre,$language)
	{
		$this->output->set_content_type('application/json');
		$output = array();
		$result = $this->ytmdata->insertNewMovie(urldecode($name),$year,$link,$actor,$actress,$director,$genre,$language);
		if($result){
			
				array_push($output,array(
					'success'=>'New movie added'
				));
			
		}	
		else {
			$this->output->set_status_header('503');
			exit;
		}
		$this->output->set_output(json_encode($output));
	
	}	
}