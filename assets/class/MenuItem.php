<?php
class MenuItem
{
    public $name;
    public $url;
    public $submenus;

    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
        $this->submenus = array();
    }

    public function addSubmenu($submenu)
    {
        $this->submenus[] = $submenu;
    }
}

?>