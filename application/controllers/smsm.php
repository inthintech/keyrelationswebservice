<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Smsm extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function __construct()
    {
      	parent::__construct();
        // Your own constructor code
        $this->load->model('smsmdata','',TRUE);
        $this->load->database();
		$this->tmdbApiKey='49b35ae23cb2dce9b78b40d209149e28';
    }
	
	/*
	// do not use language parameters since the cast and director are aplicable for all language.
	public function addMovie($fbId,$movieId)
	{
		
		
		$this->output->set_content_type('application/json');
		$output = array();
		
		//check for authentication
		
		if($this->smsmdata->returnUserData($fbId)==false){
			
			$this->output->set_status_header('503');
			array_push($output,array(
					'error'=>'User authentication failed';
				));
			$this->output->set_output(json_encode($output));
			exit;
		}
		
		$userId = $this->smsmdata->returnUserId($fbId);
		
		
		
		//check if movie exists in db
		if($this->smsmdata->returnMovieData($movieId)==true){
			
			// if the movie exist in db
			
			$this->smsmdata->updateMovieUserData($movieId,$userId);
			
		}
		else{
			
			//if the movie does not exist in db
			
			$service_url = 'https://api.themoviedb.org/3/movie/'.$movieId.'?api_key='.$this->tmdbApiKey;
			//echo $service_url;

			//make the api call and store the response
			$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$curl_response = curl_exec($curl);
			
			//if the api call is failed
			if ($curl_response === false) {
			    //$info = curl_getinfo($curl);
			    curl_close($curl);
			    //die('error occured during curl exec. Additioanl info: ' . var_export($info));
			    echo json_encode(array('error'=>'unable to get information from moviedb server'));
				$this->output->set_status_header('503');
			    exit;

			}
			curl_close($curl);
			$decoded = json_decode($curl_response);
			
			$this->smsmdata->updateMovieData($decoded->id,$decoded->title,$decoded->poster_path,$decoded->release_date);
			
			for($j=0;$j<count($decoded->genres);$j++)
				{
					
					$this->smsmdata->updateMovieGenreData($decoded->id,$decoded->genres[$j]->id);
					
				}
				
			$this->smsmdata->updateMovieUserData($movieId,$userId);
			
		}
				
			array_push($output,array(
					'success'=>'New movie added'
				));
			
			$this->output->set_output(json_encode($output));
			
	}
	
	public function userRegistration($fbId)
	{
		
		
		$this->output->set_content_type('application/json');
		$output = array();
		
		//check if user exists in db
		if($this->smsmdata->returnUserData($fbId)==true){
			
			// if the user exist in db
			
			array_push($output,array(
					'success'=>'User successfully registered'
				));
			
		}
		else{
			$result = $this->smsmdata->updateUserData($fbId);
		
			
			if($result){
				array_push($output,array(
					'success'=>'User successfully registered'
				));
			}
			else{
				array_push($output,array(
					'error'=>'Unable to register user'
				));
				$this->output->set_status_header('503');
			}
		}
			
			$this->output->set_output(json_encode($output));
			
	}
	
	private function getUserId($accessToken){
		
		$service_url = 'https://graph.facebook.com/v2.4/me?access_token='.$accessToken.'&fields=id';

		//make the api call and store the response
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		curl_close($curl);

		//if the api call is failed
		if ($curl_response === false) {
		    //$info = curl_getinfo($curl);
		    //curl_close($curl);
		    //die('error occured during curl exec. Additioanl info: ' . var_export($info));
			$this->output->set_status_header('503');
			echo json_encode(array('error'=>'unable to reach facebook servers'));
		    exit;

		}
		$decoded = json_decode($curl_response);
		
		//if the api call is success but error from facebook
		if (isset($decoded->error)) {
			//echo 'error';
		    //die('error occured: ' . $decoded->response->errormessage);
		    echo($curl_response);
		    $this->db->close();
		    exit;
		}

		$fbId = $decoded->id;
		$userId = 0;
		
		$result = $this->smsmdata->returnUserIdValue($fbid);
		
		foreach($result as $row)
		{
			$userId = $row->user_id;
		}
		
		return $userId;
		
	}
	
	
	public function getmylibrary($accessToken){
		
		$this->output->set_content_type('application/json');
		$output = array();
		
		$userId = $this->getUserId($accessToken);
		
		
		array_push($output,array(
					'success'=>$userId
				));
		
		$this->output->set_output(json_encode($output));

		
	}
	
	*/
	
	
	
	private function getUserId($accessToken){
		
		$service_url = 'https://graph.facebook.com/v2.4/me?access_token='.$accessToken.'&fields=id';

		//make the api call and store the response
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$curl_response = curl_exec($curl);
		curl_close($curl);
		$userId = NULL;
		
		//if the api call is failed
		if ($curl_response) {
			
				$decoded = json_decode($curl_response);
		
				//if the api call is success but error from facebook
				if (!isset($decoded->error)) {
					$fbId = $decoded->id;
						$userId = 0;
						$result = $this->smsmdata->returnUserId($fbId);
						foreach($result as $row){
							$userId = $row->user_id;
						}
				}
				
			}
			return $userId;
		}
	
	public function getUserLibrary($accessToken){
		
		/******************** API Start Module ********************/
		$this->output->set_content_type('application/json');
		$output = array();
		$errCode = 0;
		$userId = $this->getUserId($accessToken);
		$userAuthenticated = 0;
		
		if($userId){
			$userAuthenticated = 1;
		}
		else{
			array_push($output,array(
					'error'=>'unable to authenticate user'
				));
			$errCode=1;
		}
		/******************** API Start Module ********************/
		
		if($userAuthenticated==1){
			
			// continue the module only if user is authenticated
			
			$result = $this->smsmdata->returnUserLibrary($userId);
			
			if($result)
			{
				foreach($result as $row)
				{
					array_push($output,array(
						'id'=>$row->tmdb_movie_id,
						'title'=>$row->movie_name,
						'poster_path'=>$row->movie_poster_image,
						'release_year'=>$row->release_year,
						'is_suggested'=>$row->is_suggested_f,
						'imdb_rating'=>$row->imdb_rating,
						'suggested_cnt'=>$row->suggested_cnt
					));

				} 
			}
		}
		
		
		/******************** API End Module ********************/
		if($errCode<>0){
			$this->output->set_status_header('401');
		}
		$this->output->set_output(json_encode($output));
		/******************** API End Module ********************/

		
	}
	
	public function addUserMovie($accessToken,$movieId){
		
		/******************** API Start Module ********************/
		$this->output->set_content_type('application/json');
		$output = array();
		$errCode = 0;
		$userId = $this->getUserId($accessToken);
		$userAuthenticated = 0;
		
		if($userId){
			$userAuthenticated = 1;
		}
		else{
			array_push($output,array(
					'error'=>'unable to authenticate user'
				));
			$errCode=1;
		}
		/******************** API Start Module ********************/
		
		if($userAuthenticated==1){
			
			// continue the module only if user is authenticated
			
			//check if movie exists in db
		if($this->smsmdata->returnMovieData($movieId)==true){
			
			// if the movie exist in db
			
			$result = $this->smsmdata->updateMovieUserData($movieId,$userId);
			
			if($result==0){
				array_push($output,array(
					'code'=>'0','message'=>'movie already added'
				));
			}
			else{
				array_push($output,array(
					'code'=>'1','message'=>'movie added successfully'
				));
			}
			
		}
		else{
			
			//if the movie does not exist in db
			
			$service_url = 'https://api.themoviedb.org/3/movie/'.$movieId.'?api_key='.$this->tmdbApiKey;
			//echo $service_url;

			//make the api call and store the response
			$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$curl_response = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			
			//if the api call is failed
			if ($curl_response == false) {
			    //$info = curl_getinfo($curl);
			    //curl_close($curl);
				//$this->output->set_status_header('503');
				array_push($output,array(
					'error'=>'tmdb api call failed'
				));
				$this->output->set_status_header('500');

			}
			if($httpcode==200){
					curl_close($curl);
					$decoded = json_decode($curl_response);
					
					$service_url = 'http://www.omdbapi.com/?i='.$decoded->imdb_id;
		
					//make the api call and store the response
					$curl = curl_init($service_url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					$omdb_curl_response = curl_exec($curl);
					$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
					curl_close($curl);
					//if the api call is failed
					if ($curl_response == false) {
					}
					$OMDBdecoded = json_decode($omdb_curl_response);
					
					$this->smsmdata->updateMovieData($decoded->id,$decoded->title,$decoded->poster_path,$decoded->backdrop_path,$decoded->release_date,$OMDBdecoded->imdbID,$OMDBdecoded->imdbRating,$OMDBdecoded->Plot,$OMDBdecoded->Genre,$OMDBdecoded->Director,$OMDBdecoded->Actors);
					for($j=0;$j<count($decoded->genres);$j++)
					{
						$this->smsmdata->updateMovieGenreData($decoded->id,$decoded->genres[$j]->id);	
					}		
					
					$result = $this->smsmdata->updateMovieUserData($movieId,$userId);
					if($result==0){
						array_push($output,array(
							'code'=>'0','message'=>'movie already added'
						));
					}
					else{
						array_push($output,array(
							'code'=>'1','message'=>'movie added successfully'
						));
					}
				}
				
			}	
			
		}
		
		
		/******************** API End Module ********************/
		if($errCode<>0){
			$this->output->set_status_header('401');
		}
		$this->output->set_output(json_encode($output));
		/******************** API End Module ********************/

		
	}
	
	public function modUserSuggestion($accessToken,$movieId,$suggId){
		
		/******************** API Start Module ********************/
		$this->output->set_content_type('application/json');
		$output = array();
		$errCode = 0;
		$userId = $this->getUserId($accessToken);
		$userAuthenticated = 0;
		
		if($userId){
			$userAuthenticated = 1;
		}
		else{
			array_push($output,array(
					'error'=>'unable to authenticate user'
				));
			$errCode=1;
		}
		
		/******************** API Start Module ********************/
		
		if($userAuthenticated==1){
			
			// continue the module only if user is authenticated
			
			$result = $this->smsmdata->updateUserSuggestion($movieId,$userId,$suggId);
			
			//$result = true;
			
			
			if($result){
				array_push($output,array(
					'success'=>'movie suggestion changed'
				));
			}
			else{
				array_push($output,array(
					'error'=>'bad input'
				));
			}
			
		}
		
		
		/******************** API End Module ********************/
		if($errCode<>0){
			$this->output->set_status_header('401');
		}
		$this->output->set_output(json_encode($output));
		/******************** API End Module ********************/

		
	}
	
	public function searchMovie($accessToken,$movieName){
		
		/******************** API Start Module ********************/
		$this->output->set_content_type('application/json');
		$output = array();
		$errCode = 0;
		$userId = $this->getUserId($accessToken);
		$userAuthenticated = 0;
		
		if($userId){
			$userAuthenticated = 1;
		}
		else{
			array_push($output,array(
					'error'=>'unable to authenticate user'
				));
			$errCode=1;
		}
		
		/******************** API Start Module ********************/
		
		if($userAuthenticated==1){
			
			// continue the module only if user is authenticated
			
			
			$service_url = 'https://api.themoviedb.org/3/search/movie?api_key='.$this->tmdbApiKey.'&query='.preg_replace("/[^a-zA-Z0-9]+/", "", $movieName).'&page=1';
			//echo $service_url;
			//echo $service_url;

			//make the api call and store the response
			$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$curl_response = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			
			//if the api call is failed
			if ($curl_response == false) {
			    //$info = curl_getinfo($curl);
			    //curl_close($curl);
				//$this->output->set_status_header('503');
				array_push($output,array(
					'error'=>'tmdb api call failed'
				));
				$this->output->set_status_header('500');

			}
			if($httpcode==200){
					curl_close($curl);
					$decoded = json_decode($curl_response);
					for($i=0;$i<count($decoded->results);$i++)
					{
						if($decoded->results[$i]->original_language=="en"){
						if(isset($decoded->results[$i]->release_date)&&$decoded->results[$i]->release_date!=""){
							$ryear=substr($decoded->results[$i]->release_date,0,4);
						}
						else{
							$ryear='Unknown';
						}
						
						if(isset($decoded->results[$i]->poster_path)){
							$pp=$decoded->results[$i]->poster_path;
						}
						else{
							$pp='Unknown';
						}
						
						array_push($output,array(
							'id'=>$decoded->results[$i]->id,
							'title'=>$decoded->results[$i]->title,
							'poster_path'=>$pp,
							'release_year'=>$ryear,
							'language'=>$decoded->results[$i]->original_language));
					}
					}
				}			
		}
		
		
		/******************** API End Module ********************/
		if($errCode<>0){
			$this->output->set_status_header('401');
		}
		$this->output->set_output(json_encode($output));
		/******************** API End Module ********************/

		
	}
	
	public function findMovie($accessToken,$searchId){
		
		/******************** API Start Module ********************/
		$this->output->set_content_type('application/json');
		$output = array();
		$errCode = 0;
		$userId = $this->getUserId($accessToken);
		$userAuthenticated = 0;
		
		if($userId){
			$userAuthenticated = 1;
		}
		else{
			array_push($output,array(
					'error'=>'unable to authenticate user'
				));
			$errCode=1;
		}
		
		/******************** API Start Module ********************/
		
		if($userAuthenticated==1){
			
			// continue the module only if user is authenticated
			
			$result = $this->smsmdata->returnMovieLibrary($searchId,$userId);
			
			if($result)
			{
				foreach($result as $row)
				{
					array_push($output,array(
						'id'=>$row->tmdb_movie_id,
						'title'=>$row->movie_name,
						'poster_path'=>$row->movie_poster_image,
						'release_year'=>$row->release_year,
						'imdb_rating'=>$row->imdb_rating,
						'suggested_cnt'=>$row->cnt
					));

				} 
			}

		}
		
		
		/******************** API End Module ********************/
		if($errCode<>0){
			$this->output->set_status_header('401');
		}
		$this->output->set_output(json_encode($output));
		/******************** API End Module ********************/

		
	}
	
	public function removeUserMovie($accessToken,$movieId){
		
		/******************** API Start Module ********************/
		$this->output->set_content_type('application/json');
		$output = array();
		$errCode = 0;
		$userId = $this->getUserId($accessToken);
		$userAuthenticated = 0;
		
		if($userId){
			$userAuthenticated = 1;
		}
		else{
			array_push($output,array(
					'error'=>'unable to authenticate user'
				));
			$errCode=1;
		}
		
		/******************** API Start Module ********************/
		
		if($userAuthenticated==1){
			
			// continue the module only if user is authenticated
			
			$result = $this->smsmdata->deleteUserMovie($movieId,$userId);
			if($result){
				array_push($output,array(
					'success'=>'movie removed from library'
				));
			}
			else{
				array_push($output,array(
					'error'=>'bad input'
				));
			}

		}
		
		
		/******************** API End Module ********************/
		if($errCode<>0){
			$this->output->set_status_header('401');
		}
		$this->output->set_output(json_encode($output));
		/******************** API End Module ********************/

		
	}
	
	private function getIMDBRating($imdbID){
		
		$service_url = 'http://www.omdbapi.com/?i='.$imdbID;
		
		//make the api call and store the response
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$curl_response = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		//if the api call is failed
		if ($curl_response == false) {
			
			return 'NA';

		}
		
		if($httpcode==200){
			$decoded = json_decode($curl_response);
			return $decoded->imdbRating;	
		}
		else{
			return 'NA';
							
		}
	}
	
	public function getMovieInfo($accessToken,$movieId){
		
		/******************** API Start Module ********************/
		$this->output->set_content_type('application/json');
		$output = array();
		$errCode = 0;
		//$userId = $this->getUserId($accessToken);
		//$userAuthenticated = 0;
		$userAuthenticated = 1;
		$poster_path ='';
		$backdrop_path = '';
		$title = '';
		$imdbId = '';
		$ryear = '';
		
		$imdb_rating = '';
		$genre = '';
		$director = '';
		$actor = '';
		$plot = '';
		
		
		/*
		if($userId){
			$userAuthenticated = 1;
		}
		else{
			array_push($output,array(
					'error'=>'unable to authenticate user'
				));
			$errCode=1;
		}
		*/
		
		/******************** API Start Module ********************/
		
		if($userAuthenticated==1){
			
			
			/*
			
			// continue the module only if user is authenticated
			
			$service_url = 'https://api.themoviedb.org/3/movie/'.$movieId.'?api_key='.$this->tmdbApiKey;
			//echo $service_url;

			//make the api call and store the response
			$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$curl_response = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			
			//if the api call is failed
			if ($curl_response == false) {
			    
			    curl_close($curl);
				$errCode=1;

			}
			if($httpcode==200){
					curl_close($curl);
					$decoded = json_decode($curl_response);
					
					if(isset($decoded->release_date)&&$decoded->release_date!=""){
							$ryear=substr($decoded->release_date,0,4);
						}
					else{
						$ryear = 'NA';
					}
					$poster_path = $decoded->poster_path;
					$backdrop_path = $decoded->backdrop_path;
					$title = $decoded->original_title;
					$imdbId = $decoded->imdb_id;
						
			}
			
			$service_url = 'http://www.omdbapi.com/?i='.$imdbId;
			//echo $service_url;

			//make the api call and store the response
			$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$curl_response = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			
			//if the api call is failed
			if ($curl_response == false) {
			    
			    curl_close($curl);
				
				
			}
			if($httpcode==200){
					curl_close($curl);
					$decoded = json_decode($curl_response);
					
					$imdb_rating = $decoded->imdbRating;
					$genre = $decoded->Genre;
					$director = $decoded->Director;
					$actor = $decoded->Actors;
					$plot = $decoded->Plot;
						
			}
			*/
			
			$result = $this->smsmdata->returnMovieInfo($movieId);
			
			if($result)
			{
				foreach($result as $row)
				{
					array_push($output,array(
					'poster_path'=>$row->movie_poster_image,
					'backdrop_path'=>$row->movie_backdrop_image,
					'title'=>$row->movie_name,
					'ryear'=>$row->release_year,
					'imdb_rating'=>$row->imdb_rating,
					'genre'=>$row->omdb_genre,
					'director'=>$row->omdb_directed_by,
					'actor'=>$row->omdb_actors,
					'plot'=>$row->omdb_story_synopsis
				));

				} 
			}
				
		}
		
		
		/******************** API End Module ********************/
		if($errCode<>0){
			$this->output->set_status_header('401');
		}
		$this->output->set_output(json_encode($output));
		/******************** API End Module ********************/

		
	}
	
	/*
	public function getGenreData(){
		
		
			$query = $this->db->query("select tmdb_movie_id from smsm_movie");
			$result = $query->result();
			foreach($result as $row)
			{
			  //$dbMovieId = $row->movie_id;
			
			$service_url = 'https://api.themoviedb.org/3/movie/'.$row->tmdb_movie_id.'?api_key='.$this->tmdbApiKey;
			//echo $service_url;

			//make the api call and store the response
			$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$curl_response = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			
			//if the api call is failed
			if ($curl_response == false) {
			    //$info = curl_getinfo($curl);
			    //curl_close($curl);
				//$this->output->set_status_header('503');
				array_push($output,array(
					'error'=>'tmdb api call failed'
				));
				$this->output->set_status_header('500');

			}
			if($httpcode==200){
					curl_close($curl);
					$decoded = json_decode($curl_response);	
					for($j=0;$j<count($decoded->genres);$j++)
					{
						$this->smsmdata->updateMovieGenreData($decoded->id,$decoded->genres[$j]->id);	
					}		
					
				}
		
			}
	}*/
	
}


