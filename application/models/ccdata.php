<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Ccdata extends CI_Model
{
	/*
    
	
	public function returnUserData($fbId)
    {
        
		$query = $this->db->query("select user_id from smsm_user where fb_id='".$fbId."'");
				
        if($query->num_rows()>=1)
       {
          return true;
       }
       else
       {
          return false;
          
       }
    }
	
	public function returnUserId($fbId)
    {
        
		$query = $this->db->query("select user_id from smsm_user where fb_id='".$fbId."'");
		
		if($query->num_rows()==1)
       {
          
       }
       else
       {
          $query = $this->db->query("insert into smsm_user(fb_id) values('".$fbId."')");
		  $query = $this->db->query("select user_id from smsm_user where fb_id='".$fbId."'");
		  
          
       }
		return $query->result();
        
    }
	
	public function updateUserData($fbId)
    {
		$query = $this->db->query("insert into smsm_user(fb_id) values('".$fbId."')");
		
		if($query)
       {
          return true;
       }
       else
       {
          return false;
          
       }
		
	}
	*/
	public function updatePlayerData($iccId,$init,$lastName,$firstName){
		$query = $this->db->query("select player_id from cc_player where icc_player_id=".$iccId);
				
        if($query->num_rows()>=1)
       {
          
       }
       else
       {
          $query = $this->db->query("insert into cc_player(icc_player_id,player_initials,player_lastname,player_firstname,crte_ts) values(".$iccId.",'".str_replace("'", "", $init)."','".str_replace("'", "", $lastName)."','".str_replace("'", "", $firstName)."',CURRENT_TIMESTAMP)");
          
       }
	}
	
	
	public function returnMovieData($movieId)
    {
        
		$query = $this->db->query("select movie_id from smsm_movie where tmdb_movie_id=".$movieId);
				
        if($query->num_rows()>=1)
       {
          return true;
       }
       else
       {
          return false;
          
       }
    }
	
	public function updateMovieData($id,$title,$poster_path,$backdrop_path,$release_date,$OMDBimdbID,$OMDBimdbRating,$OMDBPlot,$OMDBGenre,$OMDBDirector,$OMDBActors)
    {
		$query = $this->db->query("select movie_id from smsm_movie where tmdb_movie_id=".$id);
		
		if($query->num_rows()>=1)
       {
          $query = $this->db->query("update smsm_movie set movie_backdrop_image='".$backdrop_path."',imdb_id='".$OMDBimdbID."',omdb_genre='".$OMDBGenre."',omdb_story_synopsis='".str_replace("'", "", $OMDBPlot)."',omdb_directed_by='".$OMDBDirector."',omdb_actors='".$OMDBActors."' where tmdb_movie_id=".$id);
       }
       else
       {
          
		  $query = $this->db->query("insert into smsm_movie(tmdb_movie_id,movie_name,movie_poster_image,movie_backdrop_image,release_year,imdb_rating,imdb_id,omdb_genre,omdb_story_synopsis,omdb_directed_by,omdb_actors) values(".$id.",'".str_replace("'", "", $title)."','".$poster_path."','".$backdrop_path."','".$release_date."','".$OMDBimdbRating."','".$OMDBimdbID."','".$OMDBGenre."','".str_replace("'", "", $OMDBPlot)."','".str_replace("'", "", $OMDBDirector)."','".str_replace("'", "", $OMDBActors)."')");
          
       }
		
		
	}
	
	public function updateMovieUserData($movieId,$userId)
    {
			$query = $this->db->query("select movie_id from smsm_movie where tmdb_movie_id=".$movieId);
		  $result = $query->result();
		  foreach($result as $row)
		  {
			$dbMovieId = $row->movie_id;
		  }
		
		$query = $this->db->query("select movie_id from smsm_movieuser where actv_f='Y' and user_id=".$userId." and movie_id=".$dbMovieId);
		
        if($query->num_rows()>=1)
       {
          return 0;
       }
       else
       {
          
		  $query = $this->db->query("insert into smsm_movieuser(movie_id,user_id,actv_f,is_suggested_f,crte_ts) values(".$dbMovieId.",".$userId.",'Y','Y',CURRENT_TIMESTAMP)");
		  return 1;
          
       }
	   
	}
	
	public function updateMovieGenreData($movieId,$genreId)
    {
		$query = $this->db->query("insert into smsm_moviegenre(movie_id,genre_id) values((select movie_id from smsm_movie where tmdb_movie_id=".$movieId."),(select genre_id from smsm_genre where tmdb_genre_id=".$genreId."))");
	}
    
	
	public function returnUserId($fbId)
    {
        
		$query = $this->db->query("select user_id from smsm_user where fb_id='".$fbId."'");
		
		if($query->num_rows()==1)
       {
          
       }
       else
       {
          $query = $this->db->query("insert into smsm_user(fb_id) values('".$fbId."')");
		  $query = $this->db->query("select user_id from smsm_user where fb_id='".$fbId."'");
		  
          
       }
		return $query->result();
        
    }
	
	public function returnMovieInfo($movieId)
    {
        
		$query = $this->db->query("select movie_poster_image,movie_backdrop_image,movie_name,release_year,imdb_rating, 
omdb_genre,omdb_directed_by,omdb_actors,omdb_story_synopsis
from smsm_movie where tmdb_movie_id=".$movieId);
		
		if($query->num_rows()==1)
       {
          return $query->result();
       }
       else
       {
          return false;
       }
	
    }
	
	public function returnUserLibrary($userId)
    {
        
		$query = $this->db->query("select b.tmdb_movie_id,b.movie_name,b.movie_poster_image,b.release_year,is_suggested_f,imdb_rating,
(select count(1) from smsm_movieuser where movie_id=a.movie_id and is_suggested_f='Y' and actv_f='Y')suggested_cnt
from smsm_movieuser a
join smsm_movie b
on a.movie_id=b.movie_id
where a.actv_f='Y' and a.user_id=".$userId."
order by a.crte_ts desc");
		
		if($query->num_rows()>=1)
       {
          return $query->result();
       }
       else
       {
          return false;
       }
	
    }
	
	public function returnMovieLibrary($searchId,$userId)
    {
        
		switch($searchId){
			
			// most suggested movies
			case 99:
				$query = $this->db->query("select b.tmdb_movie_id,b.movie_name,b.movie_poster_image,b.release_year,imdb_rating,COUNT(*) cnt  
from smsm_movieuser a
join smsm_movie b
on a.movie_id=b.movie_id
where a.is_suggested_f='Y' and a.actv_f='Y' and a.movie_id not in
(select movie_id from smsm_movieuser where actv_f='Y' and user_id=".$userId.")
group by b.tmdb_movie_id,b.movie_name,b.movie_poster_image,b.release_year,imdb_rating
order by CNT desc LIMIT 50");
				break;
			
			// movies suggested by genre
			default:
				$query = $this->db->query("select b.tmdb_movie_id,b.movie_name,b.movie_poster_image,b.release_year,imdb_rating,COUNT(*) cnt  
from smsm_movieuser a
join smsm_movie b
on a.movie_id=b.movie_id
join smsm_moviegenre c
on b.movie_id=c.movie_id
where c.genre_id=".$searchId." and a.is_suggested_f='Y' and a.actv_f='Y' and a.movie_id not in
(select movie_id from smsm_movieuser where actv_f='Y' and user_id=".$userId.")
group by b.tmdb_movie_id,b.movie_name,b.movie_poster_image,b.release_year,imdb_rating
order by CNT desc");
				break;
			
		}
		
		if($query->num_rows()>=1)
       {
          return $query->result();
       }
       else
       {
          return false;
       }
	
    }
	
	public function updateUserSuggestion($movieId,$userId,$suggId)
    {
         
		 $query = $this->db->query("select movie_id from smsm_movie where tmdb_movie_id=".$movieId);
			
			$result = $query->result();
		  
		  foreach($result as $row)
		  {
			$dbMovieId = $row->movie_id;
		  }
		
		if($suggId==1){
			//suggest movie
			if($this->db->query("update smsm_movieuser set is_suggested_f='Y' where user_id=".$userId." and movie_id=".$dbMovieId)){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			//unsuggest movie
			if($this->db->query("update smsm_movieuser set is_suggested_f='N' where user_id=".$userId." and movie_id=".$dbMovieId)){
				return true;
			}
			else{
				return false;
			}
		}
		
    }
	
	public function deleteUserMovie($movieId,$userId)
    {
         
		 $query = $this->db->query("select movie_id from smsm_movie where tmdb_movie_id=".$movieId);
		 if($query->num_rows()==0)
       {
          return false;
       }
		 
			
			$result = $query->result();
		  
		  foreach($result as $row)
		  {
			$dbMovieId = $row->movie_id;
		  }
			
			//remove movie from library
			if($this->db->query("update smsm_movieuser set actv_f='N' where user_id=".$userId." and movie_id=".$dbMovieId)){
				return true;
			}
			else{
				return false;
			}
    }
	
  
}
?>