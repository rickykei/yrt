<h1>Portlet Tag Demo</h1>

<div style="font-size: 90%; width: 650px;">
  <p>
    The <code>ajax:portlet</code> tag mimics a true portlet (in the
    <a href="http://www.jcp.org/en/jsr/detail?id=168">JSR-168</a> sense) by allowing you to define a
    portion of the page that pulls content from another location using Ajax with or without a
    periodic refresh. It expects the resource to return a valid HTML fragment, but not a complete
    page.
  </p>
  <p>
    In the example below, the portlet is set to refresh automatically every 5 seconds.  In addition,
    each of the optional toolbar elements (refresh, sizing, and close) is defined.
  </p>

</div>

<h3>Portlet in Action</h3>

<div id="portletArea">
  <div id="portlet_1" class="portletBox"><div class="portletTools"><img class="portletRefresh" src="/phpAjaxTags/img/refresh.png"/><img class="portletSize" src="/phpAjaxTags/img/minimize.png"/><img class="portletClose" src="/phpAjaxTags/img/close.png"/></div><div class="portletTitle">Ford Portlet</div><div class="portletContent"></div></div>
<script type="text/javascript">

<?
pat_portlet(array(
	'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
	'parameters'=>'action=portlet&make=Ford',
	'imageClose'=>"/phpAjaxTags/img/close.png",
	'imageRefresh'=>"/phpAjaxTags/img/refresh.png",
	'title'=>"Ford Portlet",
	'classNamePrefix'=>"portlet",
	'imageMaximize'=>"/phpAjaxTags/img/maximize.png",
	'imageMinimize'=>"/phpAjaxTags/img/minimize.png",
	'source'=>"portlet_1",
	'refreshPeriod'=>"5",	
));
?>
</script>