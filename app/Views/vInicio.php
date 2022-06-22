<div class="row justify-content-center">
  <?php 
    foreach ($accesos as $key => $value) {
      if ($value['uri'] != '') {
        echo '<div class="col-md-3">
          <a href="' . $value['uri'] . '">
            <div class="card-counter ' . $value['color'] . '">
              <i class="' . $value['icon'] . '"></i>
              <!-- <span class="count-numbers">12</span> -->
              <span class="count-name">' . $value['text'] . '</span>
            </div>
          </a>
        </div>';
      }
    }
  ?>
</div>