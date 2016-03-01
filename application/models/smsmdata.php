<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Smsmdata extends CI_Model
{
 
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
	
	public function updateMovieData($movieId,$name,$img,$year)
    {
		$query = $this->db->query("insert into smsm_movie(tmdb_movie_id,movie_name,movie_poster_image,release_year) values(".$movieId.",'".$name."','".$img."','".$year."')");
	}
	
	public function updateMovieUserData($movieId,$userId)
    {
		$query = $this->db->query("insert into smsm_movieuser(movie_id,user_id,actv_f,is_suggested_f) values(".$movieId.",".$userId.",'Y','Y')");
	}
	
	public function updateMovieGenreData($movieId,$genreId)
    {
		$query = $this->db->query("insert into smsm_moviegenre(movie_id,genre_id) values((select movie_id from smsm_movie where tmdb_movie_id=".$movieId."),(select genre_id from smsm_genre where tmdb_genre_id=".$genreId."))");
	}
    
  
}
?>