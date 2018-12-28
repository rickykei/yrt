<div id="content_htmlcontent">

<h1>HtmlContent Tag Demo</h1>

<div style="font-size: 90%; width: 650px;">
  <p>
    The <code>ajax:htmlContent</code> tag fills a content area (e.g., DIV tag) with an HTML fragment
    from another resource.  You may find this tag useful for including blocks of information in a
    sidebar when the user clicks a link or form field.  This tag is a more simplified approach to
    the <code>ajax:portlet</code> and <code>ajax:tabPanel</code> tags.
  </p>

  <p>
    Shown below are three different ways of executing the AJAX event: link, radio button, and select
    field.
  </p>
</div>

<h3>HtmlContent in Action</h3>
<div id="modelDescription"></div>
<div id="htmlContentForm">
  <p>Select by ANCHOR link.</p>
  <ul>
    <li><a href="javascript://nop/" class="contentLink">Ford</a></li>

    <li><a href="javascript://nop/" class="contentLink">Honda</a></li>
    <li><a href="javascript://nop/" class="contentLink">Mazda</a></li>
  </ul>
  <form id="htmlContentForm">
    <p>Select by RADIO option.</p>
    <input type="radio" id="makeford" name="make" value="Ford" class="contentRadio" /> Ford<br/>

    <input type="radio" id="makehonda" name="make" value="Honda" class="contentRadio" /> Honda<br/>
    <input type="radio" id="makemazda" name="make" value="Mazda" class="contentRadio" /> Mazda<br/>
    <br/>
    <p>Select by SELECT option.</p>
    <select id="selmake1" name="selmake1">
      <option value="">Select one</option>

      <option value="Ford">Ford</option>
      <option value="Honda">Honda</option>
      <option value="Mazda">Mazda</option>
    </select>
  </form>
</div>

<script type="text/javascript">

<? 
pat_htmlContent(array(
	'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
	'parameters'=>'action=htmlcontent&make={ajaxParameter}',
	'sourceClass'=>"contentLink",
	'target'=>'modelDescription',
)); 

pat_htmlContent(array(
	'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
	'parameters'=>'action=htmlcontent&make={ajaxParameter}',
	'sourceClass'=>"contentRadio",
	'target'=>'modelDescription',
)); 

pat_htmlContent(array(
	'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
	'parameters'=>'action=htmlcontent&make={selmake1}',
	'source'=>"selmake1",
	'eventType'=>"change",
	'target'=>'modelDescription',	
)); 

?>

</script>

<p>
Page loaded at: Wed Jan 25 05:33:41 EST 2006
</p>
</div>



