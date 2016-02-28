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
	
	public function updateUserData($fbId)
    {
		$query = $this->db->query("insert into smsm_user(fb_id) values('".$fbId."')");
	}
	
	public function updateMovieData($movieId,$name,$img,$backimg,$year)
    {
		$query = $this->db->query("insert into smsm_movie(tmdb_movie_id,movie_name,movie_poster_image,movie_backdrop_image,release_year) values(".$movieId.",'".$name."','".$img."','".$backimg."','".$year."')");
	}
	
	public function updateMovieGenreData($movieId,$genreId)
    {
		$query = $this->db->query("insert into smsm_moviegenre(movie_id,genre_id) values((select movie_id from smsm_movie where tmdb_movie_id=".$movieId."),(select genre_id from smsm_genre where tmdb_genre_id=".$genreId."))");
	}
    
  
}
?>