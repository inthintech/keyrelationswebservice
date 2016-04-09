<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cc extends CI_Controller {

	public function index()
	{
		show_404();
	}
	
	public function __construct()
    {
      	parent::__construct();
        // Your own constructor code
        $this->load->model('ccdata','',TRUE);
        $this->load->database();
		//$this->tmdbApiKey='49b35ae23cb2dce9b78b40d209149e28';
    }
	
	public function getplayers($key){
		
		set_time_limit(10000000);
		
		if(isset($key)){
		if($key=='49b35ae23cb2dce9b78b40d209149e28'){
			
			$service_url = 'http://msapi.pulselive.com/prapi/players';

			//make the api call and store the response
			$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$curl_response = curl_exec($curl);
			curl_close($curl);
			
			//if the api call is failed
			if ($curl_response) {
				
					$decoded = json_decode($curl_response);
					//echo $decoded->iccPlayerList[0]->id;
					//echo count($decoded->iccPlayerList);
					//echo '<br>';
					$count = 0;
					for($i=0;$i<count($decoded->iccPlayerList);$i++)
					{
						if($decoded->iccPlayerList[$i]->sex=="M"){
							$count++;
							/*
							$query = $this->db->query("select player_id from cc_player where icc_player_id=".$decoded->iccPlayerList[$i]->id);
							if($query->num_rows()>=1)
						   {
							  
						   }
						   else
						   {
							  $query = $this->db->query("insert into cc_player(icc_player_id,player_initials,player_lastname,player_firstname,crte_ts) values(".$decoded->iccPlayerList[$i]->id.",'".str_replace("'", "", $decoded->iccPlayerList[$i]->initials)."','".str_replace("'", "", $decoded->iccPlayerList[$i]->lastname)."','".str_replace("'", "", $decoded->iccPlayerList[$i]->firstname)."',CURRENT_TIMESTAMP)");
							  
						   }
							//$this->ccdata->updatePlayerData($decoded->iccPlayerList[$i]->id,$decoded->iccPlayerList[$i]->initials,$decoded->iccPlayerList[$i]->lastname,$decoded->iccPlayerList[$i]->firstname);
							*/
						}
					}
					echo 'Total count is '.$count;//3967
					echo '<br>';
					for($i=0;$i<count($decoded->iccPlayerList);$i++)
					{
						if($decoded->iccPlayerList[$i]->sex=="M"){
							//echo $decoded->iccPlayerList[$i]->name.' ';
							//echo date("Y-m-d", $decoded->iccPlayerList[$i]->dateOfBirth);
							//echo getdate($decoded->iccPlayerList[$i]->dateOfBirth);
							//echo '<br>';
							
							$query = $this->db->query("select player_id from cc_player where icc_player_id=".$decoded->iccPlayerList[$i]->id);
							if($query->num_rows()==0)
						   {
							  $query = $this->db->query("insert into cc_player(icc_player_id,player_initials,player_lastname,player_firstname,crte_ts) values(".$decoded->iccPlayerList[$i]->id.",'".str_replace("'", "", $decoded->iccPlayerList[$i]->initials)."','".str_replace("'", "", $decoded->iccPlayerList[$i]->lastname)."','".str_replace("'", "", $decoded->iccPlayerList[$i]->firstname)."',CURRENT_TIMESTAMP)");
						   }
							//$this->ccdata->updatePlayerData($decoded->iccPlayerList[$i]->id,$decoded->iccPlayerList[$i]->initials,$decoded->iccPlayerList[$i]->lastname,$decoded->iccPlayerList[$i]->firstname);
							
						}
					}
					echo 'Player List Updated.';
					
			}
				
		}	
		else{
			echo 'Authentication Failed. Unable to proceed.';
		}
	}
	else{
		echo 'No key is found.';
	}
	}
	
	public function updateplayers($key,$teamId){
		
		set_time_limit(10000000);
		
		$output = array();
		
		if($teamId==1){
		
		// india
		
		array_push($output,6609); // ms dhoni
		array_push($output,6939); // virat kohli
		array_push($output,6796); // rohit sharma
		array_push($output,7140); // shikar dhawan
		array_push($output,7103); // ravichandran ashwin
		array_push($output,2251); // ashish nehra
		array_push($output,7192); // Ajinkya Rahane
		array_push($output,6310); // Yuvraj Singh
		array_push($output,6623); // Suresh Raina
		array_push($output,6985); // Ravindra Jadeja
		array_push($output,7602); // Pawan Negi
		array_push($output,7286); // Mohammad Shami
		array_push($output,7579); // Jasprit Bumrah
		array_push($output,2221); // Harbhajan Singh
		array_push($output,7583); // Hardik Pandya
		array_push($output,7505); // Manish Pandey
		array_push($output,7285); // Bhuvneshwar Kumar
		
		}
		
		
		
		if($teamId==2){
		
		// australia
		
		array_push($output,6395); // shane watson
		array_push($output,7074); // steve smith
		array_push($output,6977); // david warner
		array_push($output,7149); // Aaron Finch
		array_push($output,7267); // Glenn Maxwell
		array_push($output,2846); // Ashton Agar
		array_push($output,7228); // James Faulkner
		array_push($output,7138); // John Hastings
		array_push($output,2747); // Usman Khawaja
		array_push($output,7584); // Andrew Tye
		array_push($output,7594); // Adam Zampa
		array_push($output,2919); // Peter Nevill
		array_push($output,7215); // Mitchell Marsh
		array_push($output,7112); // Josh Hazlewood
		array_push($output,7139); // Mitchell Starc
		array_push($output,7295); // Nathan Coulter-Nile
		
		}
		
		if($teamId==3){
		
		// pakistan
		
		array_push($output,6972); // Anwar Ali
		array_push($output,6873); // Wahab Riaz
		array_push($output,6264); // Shoaib Malik
		array_push($output,7131); // Mohammad Irfan
		array_push($output,2679); // Mohammad Amir
		array_push($output,7477); // Imad Wasim
		array_push($output,2237); // Shahid Afridi
		array_push($output,6476); // Mohammad Hafeez
		array_push($output,7601); // Mohammad Nawaz
		array_push($output,6858); // Sarfraz Ahmed
		array_push($output,7037); // Umar Akmal
		array_push($output,2353); // Mohammad Sami
		array_push($output,7349); // Sharjeel Khan
		array_push($output,6864); // Khalid Latif
		array_push($output,7011); // Ahmed Shehzad
		
		}
		
		if($teamId==4){
		
		// west indies
		
		array_push($output,6550); // Darren Sammy
		array_push($output,7256); // Samuel Badree
		array_push($output,2635); // Sulieman Benn
		array_push($output,6534); // Dwayne Bravo
		array_push($output,6894); // Andre Fletcher
		array_push($output,2303); // Chris Gayle
		array_push($output,7292); // Jason Holder	//double entry
		array_push($output,2553); // Denesh Ramdin
		array_push($output,2739); // Andre Russell
		array_push($output,2344); // Marlon Samuels
		array_push($output,6496); // Jerome Taylor	
		array_push($output,7211); // Carlos Brathwaite //double entry
		array_push($output,7165); // Ashley Nurse
		array_push($output,7207); // Johnson Charles
		//array_push($output,7295); // Evin Lewis // cannot find
		array_push($output,6766); // Lendl Simmons
		
		}
		
		if($teamId==5){
		
		// new zealand
		
		array_push($output,7127); // Kane Williamson
		array_push($output,6963); // Martin Guptill
		array_push($output,2791); // Trent Boult
		array_push($output,6832); // Nathan McCullum
		array_push($output,7277); // Colin Munro
		array_push($output,6914); // Luke Ronchi
		array_push($output,7409); // Ish Sodhi //double entry
		array_push($output,6663); // Ross Taylor
		array_push($output,7276); // Corey Anderson
		array_push($output,6892); // Grant Elliott //double entry
		array_push($output,7278); // Mitchell McClenaghan
		array_push($output,7145); // Adam Milne
		array_push($output,7567); // Henry Nicholls
		array_push($output,7482); // Mitchell Santner
		array_push($output,6875); // Tim Southee
		
		}
		
		if($teamId==6){
		
		// south africa
		
		array_push($output,7150); // Faf du Plessis
		array_push($output,2540); // Hashim Amla
		array_push($output,7281); // Quinton de Kock
		array_push($output,6579); // Jean-Paul Duminy
		array_push($output,7098); // David Miller
		array_push($output,7284); // Aaron Phangiso
		array_push($output,7418); // Rilee Rossouw
		array_push($output,7326); // David Wiese
		array_push($output,7297); // Kyle Abbott //double entry
		array_push($output,7251); // Farhaan Behardien
		array_push($output,2541); // AB de Villiers
		array_push($output,7156); // Imran Tahir
		array_push($output,7282); // Chris Morris
		array_push($output,7434); // Kagiso Rabada
		array_push($output,2542); // Dale Steyn
		
		}
		
		if($teamId==7){
		
		// bangladesh
		
		array_push($output,2390); // Mashrafe Mortaza
		array_push($output,7575); // Abu Hider
		array_push($output,7365); // Arafat Sunny
		array_push($output,7366); // Mohammad Mithun
		array_push($output,7572); // Nurul Hasan
		array_push($output,7459); // Soumya Sarkar
		array_push($output,7399); // Taskin Ahmed
		array_push($output,6781); // Tamim Iqbal
		array_push($output,7367); // Sabbir Rahman
		array_push($output,7183); // Nasir Hossain
		array_push($output,2565); // Mushfiqur Rahim
		array_push($output,7472); // Mustafizur Rahman
		array_push($output,6811); // Mahmudullah
		array_push($output,6740); // Shakib Al Hasan
		array_push($output,2856); // Al-Amin Hossain
		//array_push($output,7295); // Saqlain Sajib // not found
		array_push($output,7185); // Shuvagata Hom
		
		}
		
		if($teamId==8){
			
		// srilanka
		
		array_push($output,6962); // Angelo Mathews
		array_push($output,7093); // Dinesh Chandimal
		array_push($output,2283); // Tillakaratne Dilshan
		array_push($output,7528); // Shehan Jayasuriya
		array_push($output,7504); // Milinda Siriwardana
		array_push($output,7529); // Dasun Shanaka
		array_push($output,2586); // Chamara Kapugedera
		array_push($output,6513); // Nuwan Kulasekara
		array_push($output,7467); // Dushmantha Chameera
		array_push($output,7063); // Thisara Perera
		array_push($output,7226); // Sachithra Senanayake //double entry
		array_push($output,2271); // Rangana Herath
		array_push($output,7062); // Suranga Lakmal
		array_push($output,7065); // Lahiru Thirimanne
		array_push($output,7526); // Jeffrey Vandersay
		array_push($output,7289); // Kusal Perera
		
		}
		
		if($teamId==9){
			
		// england
		
		array_push($output,6731); // Eoin Morgan
		array_push($output,7481); // Sam Billings
		//array_push($output,6977); // Liam Dawson //not found
		array_push($output,7190); // Alex Hales
		array_push($output,7015); // Adil Rashid
		array_push($output,7421); // Jason Roy
		array_push($output,7533); // Reece Topley
		array_push($output,7475); // David Willey
		array_push($output,7370); // Moeen Ali
		array_push($output,7191); // Jos Buttler
		array_push($output,7338); // Chris Jordan
		array_push($output,2821); // Joe Root
		array_push($output,7189); // Ben Stokes
		array_push($output,7473); // James Vince
		array_push($output,2587); // Liam Plunkett
		
		}
		
		if($teamId==10){
		
		//zimbabwe	
			
		array_push($output,2377); // Hamilton Masakadza
		array_push($output,6982); // Malcolm Waller
		array_push($output,2548); // Graeme Cremer
		
		
		}
		
		if($teamId==11){
		
		//afganistan
			
		array_push($output,7043); // Mohammad Shahzad
		array_push($output,7172); // Michael Swart
		array_push($output,7116); // Wesley Barresi
		array_push($output,6724); // Peter Borren
		array_push($output,7003); // Asghar Stanikzai
		array_push($output,7001); // Mohammad Nabi
		array_push($output,7542); // Rashid Khan
		array_push($output,7233); // Hamza Hotak
		array_push($output,7179); // Dawlat Zadran
		
		}
		
		if($teamId==12){
		
		//netherlands
			
		array_push($output,7195); // Stephan Myburgh
		array_push($output,7245); // Timm van der Gugten
		array_push($output,6803); // Mudassar Bukhari
		}
		
		if($teamId==12){
		
		//scotland
			
		array_push($output,6940); // Kyle Coetzer
		array_push($output,6933); // Richard Berrington
		}
		
		if($teamId==13){
		
		//ireland
			
		array_push($output,6927); // Paul Stirling
		array_push($output,7066); // George Dockrell
		}
		
		if($teamId==14){
		
		//uae
			
		array_push($output,7405); // Mohammad Naveed
		
		}
		
		
		
		
		if(isset($key)){
		if($key=='49b35ae23cb2dce9b78b40d209149e28'){
			
			for($i=0;$i<count($output);$i++){
				//echo $output[$i];
				
				$service_url = 'http://msapi.pulselive.com/prapi/data?scope=T20&pid='.$output[$i];
				$nat = '';
				$batRating = 0;
				$batRank = 0;
				$bowlRating = 0;
				$bowlRank = 0;
				
				//make the api call and store the response
				$curl = curl_init($service_url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				$curl_response = curl_exec($curl);
				curl_close($curl);
				
				if ($curl_response) {
					$decoded = json_decode($curl_response);
					$nat = $decoded->playerEvents->nationality;
					for($j=count($decoded->playerEvents->events)-1;$j<count($decoded->playerEvents->events);$j++){
						$batRating = $decoded->playerEvents->events[$j]->battingRating;
						$batRank = $decoded->playerEvents->events[$j]->battingRanking;
						$bowlRating = $decoded->playerEvents->events[$j]->bowlingRating;
						$bowlRank = $decoded->playerEvents->events[$j]->bowlingRanking;
					}
					
					$query = $this->db->query("select icc_player_id from cc_player_attributes where icc_player_id=".$output[$i]);
					
					if($query->num_rows()==0)
					{
					   $query = $this->db->query("insert into cc_player_attributes(icc_player_id,player_nationality,player_batting_rating,player_batting_ranking,player_bowling_rating,player_bowling_ranking,updt_ts) values(".$output[$i].",'".str_replace("'", "", $nat)."',".$batRating.",".$batRank.",".$bowlRating.",".$bowlRank.",CURRENT_TIMESTAMP)");
					}
					else{
						$query = $this->db->query("update cc_player_attributes set player_nationality='".$nat."',player_batting_rating=".$batRating.",player_batting_ranking=".$batRank.",player_bowling_rating=".$bowlRating.",player_bowling_ranking=".$bowlRank.",updt_ts=CURRENT_TIMESTAMP where icc_player_id=".$output[$i]);
					}
					
				}
			}
			echo 'Player update done.';
		}
		else{
			echo 'Authentication Failed. Unable to proceed.';
		}
	}
	else{
		echo 'No key is found.';
	}
	}
	
	public function userRegistration($accessToken)
	{
		$this->output->set_content_type('application/json');
		$output = array();
		
		$service_url = 'https://graph.facebook.com/v2.4/me?access_token='.$accessToken.'&fields=id,name';

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
			//echo json_encode(array('error'=>'unable to reach facebook server'));
			array_push($output,array(
					'error'=>'unable to reach facebook server'
				));
		    exit;

		}
		$decoded = json_decode($curl_response);
		
		//if the api call is success but error from facebook
		if (isset($decoded->error)) {
			$this->output->set_status_header('503');
			//echo json_encode(array('error'=>'error returned by facebook server'));
			array_push($output,array(
					'error'=>'error returned by facebook server'
				));
		    exit;
		}

		$fbId = $decoded->id;
		$name = $decoded->name;
		$userId = 0;
		
		$query = $this->db->query("select user_id from cc_user where fb_id=".$fbId);
		
		if($query->num_rows()<>1){
			$query = $this->db->query("delete from cc_user where fb_id=".$fbId);
			$query = $this->db->query("insert into cc_user(fb_id,user_fullname,user_teamname,crte_ts) values(".$this->db->escape($fbId).",".$this->db->escape($name).",'My Team',CURRENT_TIMESTAMP)");
		}
        
		$query = $this->db->query("select user_id from cc_user where fb_id=".$fbId);
		
		foreach($query->result() as $row){
			$userId = $row->user_id;
		}
		
		$query = $this->db->query("select user_id from cc_userplayer where user_id=".$userId);
		
		if($userId<>0 && $query->num_rows()<>11){
			$query = $this->db->query("delete from cc_userplayer where user_id=".$userId);
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",2960)"); //Jason Roy
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",3917)"); //Quinton de Kock
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",1793)"); //Virat Kohli
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",2944)"); //Joe Root
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",548)"); //Jos Buttler
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",3707)"); //Shane Watson
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",2971)"); //Andre Russell
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",3031)"); //Mitchell Santner
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",3782)"); //David Willey
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",247)"); //Samuel Badree
			$query = $this->db->query("insert into cc_userplayer(user_id,player_id) values(".$userId.",2437)"); //Ashish Nehra
		}
		
		$query = $this->db->query("select user_id from cc_user where fb_id=".$fbId);
		
		$userCnt = $query->num_rows();
		
		$query = $this->db->query("select user_id from cc_userplayer where user_id=".$userId);
		
		$playerCnt = $query->num_rows();
		
		if($userCnt==1&&$playerCnt==11){
			//echo json_encode(array('success'=>'user is successfully registered'));
			array_push($output,array(
					'success'=>'user is successfully registered'
				));
		}
		else{
			$this->output->set_status_header('503');
			//echo json_encode(array('error'=>'user registration failed'));
			array_push($output,array(
					'error'=>'user registration failed'
				));
		}
		
		$this->output->set_output(json_encode($output));
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
			
			
			$service_url = 'https://api.themoviedb.org/3/search/movie?api_key='.$this->tmdbApiKey.'&query='.$movieName.'&page=1';
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


