{* Smarty *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="Your description goes here" />
	<meta name="keywords" content="your,keywords,goes,here" />
	<meta name="author" content="Armand A. Verstappen <averstappen@ebay.com>" />
	<link rel="stylesheet" type="text/css" href="variant-classic.css" title="eCG NOC - {$title}" media="screen,projection" />
	<title>eCG NOC - {$title}</title>
</head>

<body>
<div id="top"><div class="inner">

	<div id="topleft">
		<h1><a href="index.html">{$title}</a></h1>
		<p>{$slogan}</p>
	</div>

	<div id="topright">
    <img src="images/ecglogo.png" alt="eBay Classifieds Group" />
	</div>
	<br class="clear" />

	<div id="mainmenu">
		<ul>
		{foreach $menu as $menuitem}
			{if $active == $menuitem.link}
			<li class="current_page_item"><a href="{$menuitem.link}">{$menuitem.title}</a></li>
			{else}
			<li><a href="{$menuitem.link}">{$menuitem.title}</a></li>
			{/if}
		{/foreach}
		</ul>
	</div>
	<br class="clear" />
</div></div>

<div id="wrap"><div class="inner">

	<div id="content">
		<h2><a href="#">{$title}</a></h2>
		<div class="clearfix">
			<p>{$content}</p>
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
