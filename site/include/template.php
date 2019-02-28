<?php
if (!defined('BASE_DIR'))
    exit;

class TemplateManager
{
    public function display($tpl, $args = array())
    {
        extract($args);
        require BASE_DIR . 'include/templates/' . $tpl;
    }
}
