<?php $menus = $this->menu_model->get_menu($group); 
  foreach ($menus as $menu) :
    if ($menu->url !== '#') : ?>
      <li class=""><a href="<?= base_url($menu->url) ?>"><?= $menu->menu ?></a></li>
    <?php else : ?>
      <li class="dropdown">
        <a 
          href="<?= $menu->url ?>" 
          class="dropdown-toggle" 
          data-toggle="dropdown">
          <?= $menu->menu ?> 
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
          <?php $submenus = $this->menu_model->get_submenu($group, $menu->id);
          foreach ($submenus as $submenu) : ?>
            <li><a href="<?= $submenu->url ?>"><?= $submenu->menu ?></a></li>
          <?php endforeach; ?>
        </ul>
      </li>
    <?php endif;
  endforeach; 
?>