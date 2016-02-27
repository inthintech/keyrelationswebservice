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
	
	public function updateMovieData($movieId,$name,$img,$backimg,$year)
    {
		$query = $this->db->query("insert into smsm_movie(tmdb_movie_id,movie_name,movie_poster_image,release_year) values(".$movieId.",'".$name."','".$img."','".$backimgimg."','".$year."')");
	}
	
	public function updateMovieGenreData($movieId,$genreId)
    {
		$query = $this->db->query("insert into smsm_moviegenre(movie_id,genre_id) values((select movie_id from smsm_movie where tmdb_movie_id=".$movieId."),(select genre_id from smsm_genre where tmdb_genre_id=".$genreId."))");
	}
    
  
}
?>