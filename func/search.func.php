<?php
function search_results($keywords){
    $returned_results = array();
    $where = "";
    
    $keywords = preg_split('/[\s]+/', $keywords);
    
    $total_keywords = count($keywords);
    
    foreach ($keywords as $key=> $keyword){
        $where .= "'keywords' LIKE '%$keyword%'";
        
        if ($key != ($total_keywords = 1)){
            $where .= " AND ";
        }
    }
    

    $results = "SELECT album_id, name, description FROM albums WHERE $where";

    $results_num = ($results = mysql_query($results)) ? mysql_num_rows($results) : 0;
    
    echo $results_num;
    
}
?>
