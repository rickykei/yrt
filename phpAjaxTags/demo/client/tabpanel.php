<h1>Tab Panel Tag Demo</h1>
<div style="margin-top: 0px; padding-top: 0px; font-size: 70%">
  <a href="/ajaxtags/txt/jsp/tabpanel.jsp.txt">JSP source</a>
  | <a href="/ajaxtags/src/org/ajaxtags/demo/servlet/HtmlContentServlet.java">Java source</a>

</div>

<div style="font-size: 90%; width: 650px;">
  <p>
    The <code>ajax:tabPanel</code> tag provides a tabbed page view of content from different
    resources, typically other JSP or HTML pages.  It expects the resource to return a valid HTML
    fragment, but not a complete page.
  </p>
  <p>
    Each panel is defined in a <code>ajax:tab</code> child tag with its own unique URL. The tab
    panel relies heavily on CSS to structure the panels themselves.  The output is generated as an
    unordered list (&lt;ul&gt;) which works very nicely with the styles cataloged at
    <a href="http://css.maxdesign.com.au/listamatic/">List-a-Matic</a>.
  </p>

</div>

<h3>Tab Panel in Action</h3>

<div id="tabPanelWrapper">

<?

pat_tabPanel(array(
'panelStyleId'=>'tabPanel',
'contentStyleId'=>'tabContent',
'currentStyleId'=>'ajaxCurrentTab',
'tabs'=>array(
	'tabFord'=>array(
		'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
		'caption'=>'Ford',
		'defaultTab'=>'1',
		'parameters'=>'action=tabpanel&make=Ford',
	),
	'tabMazda'=>array(
		'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php?action=tabpanel&make=Mazda',
		'caption'=>'Mazda',
	),
	'tabHonda'=>array(
		'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
		'caption'=>'Honda',
		'parameters'=>'action=tabpanel&make=Honda',
	),
	),
));

?>

</div>


