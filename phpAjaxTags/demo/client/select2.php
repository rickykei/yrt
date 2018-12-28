<h1>Select Tag Demo</h1>

<div style="font-size: 90%; width: 650px;">
  <p>
    The <code>ajax:select</code> tag allows one to retrieve a list of values from a backend servlet
    (or other server-side control) and display them in another HTML select box.
  </p>
  <p>
    Here, the example asks the user to select a make from a list of car makers. Once selected, the
    XMLHttpRequest object calls a servlet to retrieve all models for that make, which are then
    populated in the second dropdown.
  </p>
  <p>

    This example also demonatrates the use of a post-function (written in JavaScript).
    Post-functions execute after the AJAX piece is finished its work. In this case, we define a
    post-function to display an image of the car maker.
  </p>
</div>

<form id="carForm" name="carForm">
  <fieldset>
    <legend>Choose Your Car</legend>

    <div>
      <img id="makerEmblem"
           src="/phpAjaxTags/img/placeholder.gif"
           width="76" height="29" />
    </div>

    <label for="make3">Make:</label>
    <select id="make3">
      <option value="">Select make</option>
      <option value="Ford">Ford</option>
      <option value="Honda">Honda</option>
      <option value="Mazda">Mazda</option>

      <option value="dummy">Dummy cars</option>
    </select>

    <label for="model3">Model:</label>
    <select id="model3" disabled="disabled">
      <option value="">Select model</option>
    </select>
  </fieldset>

</form>

<script type="text/javascript">
function showMakerEmblem() {
  var index = document.getElementById("make3").selectedIndex;
  var automaker = document.getElementById("make3").options[index].text;
  var imgTag = document.getElementById("makerEmblem");
  if (index > 0) {
    imgTag.src = "/phpAjaxTags/img/" + automaker.toLowerCase() + "_logo.gif";
  }
}
function handleEmpty() {
  document.getElementById("model3").options.length = 0;
  document.getElementById("model3").options[0] = new Option("None", "");
  document.getElementById("model3").disabled = true;
}
</script>

<script type="text/javascript">

<?pat_Select(array(
	'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
	'parameters'=>'action=select2&make={make3}',
	'source'=>'make3',
	'emptyFunction'=>'handleEmpty',
	'postFunction'=>'showMakerEmblem',
	'target'=>'model3'));
?>
</script>