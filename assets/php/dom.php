<?php

function generateMenuHTML($menuItems)
{
    if ($menuItems != null) {
        $html = '<ul class="navbar-nav">';

        foreach ($menuItems as $item) {
            $html .= '<li class="nav-item';

            if (!empty($item->submenus)) {
                $html .= ' dropdown">';
                $html .= '<a class="nav-link dropdown-toggle" href="' . $item->url . '" id="submenu-' . $item->name . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $item->name . '</a>';
                $html .= '<ul class="dropdown-menu dropdown-menu-dark">';

                foreach ($item->submenus as $submenu) {
                    $html .= '<li>';
                    $html .= '<a class="dropdown-item" href="' . $submenu->url . '">' . $submenu->name . '</a>';
                    $html .= '</li>';
                }

                $html .= '</ul>';
            } else {
                $html .= '">';
                $html .= '<a class="nav-link" href="' . $item->url . '">' . $item->name . '</a>';
            }

            $html .= '</li>';
        }

        $html .= '</ul>';
    } else {
        $html = '';
    }



    return $html;
}
function fillListWithObjects($objetos)
{

  foreach ($objetos as $objeto) {
    echo '<option value="' . $objeto->valor . '">' . $objeto->nombre . '</option>';
  }

}




?>