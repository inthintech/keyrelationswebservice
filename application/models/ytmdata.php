<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Ytmdata extends CI_Model
{
 
    public function returnFilterData($type)
    {
        switch($type){
			case 1://genre
				 $query = $this->db->query("select genre_id id,genre_name name from ytm_genre order by genre_name");
				break;
			case 2://actor
				$query = $this->db->query("select male_lead_id id,male_lead_name name from ytm_male_lead order by male_lead_name");
				break;
			case 3://actress
				$query = $this->db->query("select female_lead_id id,female_lead_name name from ytm_female_lead order by female_lead_name");
				break;
			case 4://director
				$query = $this->db->query("select director_id id,director_name name from ytm_director order by director_name");
				break;
			case 5://release year
				$query = $this->db->query("select release_year_id id,release_year name from ytm_release_year order by release_year");
				break;
            case 6://language
				$query = $this->db->query("select language_id id,language_name name from ytm_language order by language_name");
				break;
            default :
                show_404();
                exit;
			
		}
       
        if($query)
       {
          return $query->result();
       }
       else
       {
          return false;
          
       }
    }
    
    public function returnFilterList($type,$lang)
    {
        switch($type){
			case 1://genre
				 $query = $this->db->query("select b.genre_id id,b.genre_name name,count(1) cnt from ytm_movie a
join ytm_genre b
on a.genre_id=b.genre_id
where a.actv_f='Y' and a.language_id=".$lang." group by b.genre_id,b.genre_name
order by b.genre_name");
				break;
			case 2://actor
				$query = $this->db->query("select b.male_lead_id id,b.male_lead_name name,count(1) cnt from ytm_movie a
join ytm_male_lead b
on a.male_lead_id=b.male_lead_id
where a.actv_f='Y' and a.language_id=".$lang."
group by b.male_lead_id,b.male_lead_name
order by b.male_lead_name");
				break;
			case 3://actress
				$query = $this->db->query("select b.female_lead_id id,b.female_lead_name name,count(1) cnt from ytm_movie a
join ytm_female_lead b
on a.female_lead_id=b.female_lead_id
where a.actv_f='Y' and a.language_id=".$lang."
group by b.female_lead_id,b.female_lead_name
order by b.female_lead_name");
				break;
			case 4://director
				$query = $this->db->query("select b.director_id id,b.director_name name,count(1) cnt from ytm_movie a
join ytm_director b
on a.director_id=b.director_id
where a.actv_f='Y' and a.language_id=".$lang."
group by b.director_id,b.director_name
order by b.director_name");
				break;
			case 5://release year
				$query = $this->db->query("select b.release_year_id id,b.release_year name,count(1) cnt from ytm_movie a
join ytm_release_year b
on a.release_year_id=b.release_year_id
where a.actv_f='Y' and a.language_id=".$lang."
group by b.release_year_id,b.release_year
order by b.release_year");
				break;
            default :
                show_404();
                exit;
			
		}
       
        if($query)
       {
          return $query->result();
       }
       else
       {
          return false;
          
       }
    }
    
    public function insertNewMovie($name,$year,$link,$actor,$actress,$director,$genre,$language)
    {
        
        $query = $this->db->query("insert into ytm_movie(movie_name,release_year_id,youtube_link,male_lead_id,female_lead_id,director_id,genre_id,actv_f,crte_ts,language_id) values('".$name."',".$year.",'".$link."',".$actor.",".$actress.",".$director.",".$genre.",'Y',current_timestamp,".$language.")");
        
        if($query)
       {
          return true;
       }
       else
       {
          return false;
          
       }
    }

  
}
?>