<?php /* Smarty version Smarty-3.0.8, created on 2011-07-24 04:54:26
         compiled from "/usr/local/cmdb/www//noc/lib/templates/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20221566344e2b8962d1e723-49091043%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd32cf100fec7648c676d13e092d73c6013e84bf' => 
    array (
      0 => '/usr/local/cmdb/www//noc/lib/templates/main.tpl',
      1 => 1311476065,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20221566344e2b8962d1e723-49091043',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="Your description goes here" />
	<meta name="keywords" content="your,keywords,goes,here" />
	<meta name="author" content="Armand A. Verstappen <averstappen@ebay.com>" />
	<link rel="stylesheet" type="text/css" href="variant-classic.css" title="eCG NOC - <?php echo $_smarty_tpl->getVariable('title')->value;?>
" media="screen,projection" />
	<title>eCG NOC - <?php echo $_smarty_tpl->getVariable('title')->value;?>
</title>
</head>

<body>
<div id="top"><div class="inner">

	<div id="topleft">
		<h1><a href="index.html"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</a></h1>
		<p><?php echo $_smarty_tpl->getVariable('slogan')->value;?>
</p>
	</div>

	<div id="topright">
    <img src="images/ecglogo.png" alt="eBay Classifieds Group" />
	</div>
	<br class="clear" />

	<div id="mainmenu">
		<ul>
		<?php  $_smarty_tpl->tpl_vars['menuitem'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('menu')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['menuitem']->key => $_smarty_tpl->tpl_vars['menuitem']->value){
?>
			<?php if ($_smarty_tpl->getVariable('active')->value==$_smarty_tpl->tpl_vars['menuitem']->value['link']){?>
			<li class="current_page_item"><a href="<?php echo $_smarty_tpl->tpl_vars['menuitem']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['menuitem']->value['title'];?>
</a></li>
			<?php }else{ ?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['menuitem']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['menuitem']->value['title'];?>
</a></li>
			<?php }?>
		<?php }} ?>
		</ul>
	</div>
	<br class="clear" />
</div></div>

<div id="wrap"><div class="inner">

	<div id="content">
		<h2><a href="#"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</a></h2>
		<div class="clearfix">
			<p><?php echo $_smarty_tpl->getVariable('content')->value;?>
</p>
		</div>
	
<!--		<div class="postpagesnav">
			<div class="back">&laquo; <a href="layouts.html">Alternate layout</a></div>
			<div class="forward"><a href="index.html">First page</a> &raquo;</div>
			<br class="clear" />
		</div>
-->
	</div>
	
	<div id="sidebar">
		<h2>Sidebar header</h2>
		<p>Sidebar text</p>
		
		<div class="left">
			<h2>Left side header</h2>
			<p>Left side content</p>
		</div>
		
		<div class="right">
			<h2>Right side header</h2>
			<p>Right side content</p>
		</div>
	</div>

</div>
<br class="clear" />
</div>

<div id="footer"><div class="inner">
	<p><span class="credits">&copy; 2011 eBay Classifieds Group</span></p>
	
</div></div>

</body>
</html>
