<!-- Pagination -->

<div class="pagination">

<?php


if($pagination->total_pages() > 1 ){

  echo "<nav aria-label='Page navigation'>
              <ul class='pagination'>";



      if($pagination->has_previous_page()) {
        echo "<li><a href=\"index.php?page=";
        echo $pagination->previous_page();
        echo "\"><span aria-hidden=\"true\">&laquo;</span><li></a> ";
      }

      for($i=1; $i <= $pagination->total_pages(); $i++) {
        if($i == $page) {
          echo " <li><span class=\"selected\">{$i}</span></li> ";
        } else {
          echo " <li><a href=\"index.php?page={$i}\">{$i}</a></li> ";
        }
      }

      if($pagination->has_next_page()) {
        echo "<li> <a href=\"index.php?page=";
        echo $pagination->next_page();
        echo "\">&raquo;</a></li> ";
      }

      echo "  </ul>
            </nav>";

}

 ?>

 </div>


