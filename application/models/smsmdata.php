<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Smsmdata extends CI_Model
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
	
	public function updateMovieData($movieId,$name,$img,$year)
    {
		$query = $this->db->query("insert into smsm_movie(tmdb_movie_id,movie_name,movie_poster_image,release_year) values(".$movieId.",'".$name."','".$img."','".$year."')");
	}
	
	public function updateMovieUserData($movieId,$userId)
    {
			$query = $this->db->query("select movie_id from smsm_movie where tmdb_movie_id=".$movieId);
		  $result = $query->result();
		  foreach($result as $row)
		  {
			$dbMovieId = $row->movie_id;
		  }
		
		$query = $this->db->query("select movie_id from smsm_movieuser where user_id=".$userId." and movie_id=".$dbMovieId);
		
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
	
	public function returnUserLibrary($userId)
    {
        
		$query = $this->db->query("select b.tmdb_movie_id,b.movie_name,b.movie_poster_image,b.release_year,is_suggested_f  
from smsm_movieuser a
join smsm_movie b
on a.movie_id=b.movie_id
where a.user_id=".$userId."
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
				$query = $this->db->query("select b.tmdb_movie_id,b.movie_name,b.movie_poster_image,b.release_year,COUNT(*) CNT  
from smsm_movieuser a
join smsm_movie b
on a.movie_id=b.movie_id
where a.is_suggested_f='Y' and a.actv_f='Y' and a.movie_id not in
(select movie_id from smsm_movieuser where user_id=".$userId.")
group by b.tmdb_movie_id,b.movie_name,b.movie_poster_image,b.release_year
order by CNT desc");
				break;
			
			// movies suggested by genre
			default:
				$query = $this->db->query("select b.tmdb_movie_id,b.movie_name,b.movie_poster_image,b.release_year,COUNT(*) CNT  
from smsm_movieuser a
join smsm_movie b
on a.movie_id=b.movie_id
join smsm_moviegenre c
on b.movie_id=c.movie_id
where c.genre_id=".$searchId." and a.is_suggested_f='Y' and a.actv_f='Y' and a.movie_id not in
(select movie_id from smsm_movieuser where user_id=".$userId.")
group by b.tmdb_movie_id,b.movie_name,b.movie_poster_image,b.release_year
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