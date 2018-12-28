<h1>Toggle Tag Demo</h1>
<div style="margin-top: 0px; padding-top: 0px; font-size: 70%">
  <a href="/ajaxtags/txt/jsp/toggle.jsp.txt">JSP source</a>
  | <a href="/ajaxtags/src/org/ajaxtags/demo/servlet/ToggleServlet.java">Java source</a>

</div>

<div style="font-size: 90%; width: 650px;">
  <p>
    The <code>ajax:toggle</code> tag will change the value of a hidden form field between true and
    false, toggle an image between two source files, and replace the inner HTML content of another
    tag (div, span, etc).
  </p>
  <p>
    This tag is fairly simple and could be powerful all at the same time.  We envision one could use
    this in a variety of cases such as checking/unchecking recordsets.
  </p>
</div>

<div>
  <h3>Toggle in Action</h3>
  
  <img id="watched"
       src="/phpAjaxTags/img/watched_false.gif"
       align="top"
       onmouseover="this.style.cursor='pointer'" />
  Toggle Me
</div>

<div id="watchedResponseContainer">
  Response
  <div id="watchedResponse"><br/></div>
</div>
<form id="toggleForm">

<input type="hidden" id="watchedStatus" name="watchedStatus" value="false"/>
</form>

<script type="text/javascript">
function populateResponseContent(xml) {
  var root = xml.documentElement;
  var respNode = root.getElementsByTagName("response")[0];
  var content = getValueForNode(respNode, "toggleContent");
  $('watchedResponse').innerHTML = content;
}
</script>

<script type="text/javascript">
<? pat_toggle(array(
'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php?action=toggle',
'stateXmlName'=>"toggleState",
'postFunction'=>'populateResponseContent',
'image'=>"watched",
'state'=> "watchedStatus",
'imagePattern'=>"/phpAjaxTags/img/watched_{0}.gif"
));
?>
</script>