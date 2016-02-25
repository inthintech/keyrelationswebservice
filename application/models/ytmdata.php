<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Ytmdata extends CI_Model
{
 
    public function returnGenre()
    {
        $query = $this->db->query("select genre_id id,genre_name name from ytm_genre order by genre_name");
    
        if($query)
       {
          return $query->result();
       }
       else
       {
          return false;
          
       }
    }

  
}
?>