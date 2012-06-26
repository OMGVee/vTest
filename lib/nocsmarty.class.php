<?php
require_once("Smarty-3.0.8/libs/Smarty.class.php");

class NocSmarty extends Smarty {

  public function __construct() {
    parent::__construct();
    $this->template_dir = SMARTY_TEMPLATE_DIR;
    $this->compile_dir = SMARTY_COMPILE_DIR;
    $this->config_dir = SMARTY_CONFIG_DIR;
    $this->cache_dir = SMARTY_CACHE_DIR;
    $this->assign('title','eCG NOC');
    $this->assign('headertext','eCG NOC');
  }
}

?>
