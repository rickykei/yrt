<h1>Autocomplete Demo</h1>


<div style="font-size: 90%; width: 650px;">
  <p>
    The <code>ajax:autocomplete</code> tag allows one to retrieve a list of probable values from a
    backend servlet (or other server-side control) and display them in a dropdown beneath an HTML
    text input field.
  </p>
  <p>
    The user may then use the cursor and ENTER keys or the mouse to make a selection from that list
    of labels, which is then populated into the text field. This JSP tag also allows for a second
    field to be populated with the value or ID of the item in the dropdown.
  </p>
  <p>

    You'll notice that an image is used to indicate a busy state while the XMLHttpRequest object is
    making it's request to the server-side. This is a bit of JavaScript/CSS trickery--check the
    source to see how it's done.
  </p>
</div>

<form id="carForm">
  <fieldset>
    <legend>Enter Car Model</legend>
    <p>Available values start with letters: 'A', 'C', 'E', 'F', 'M', 'R', 'T'</p>
sdfds
    <label for="model">Name:</label>

    <input id="model" name="model[]" type="text" size="30" class="form-autocomplete" />

    <label for="make">Make:</label>
    <input id="make" name="make[]" type="text" size="30" />
  </fieldset>
</form>
<script>
<? pat_autocomplete( array(
	'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
	'source'=>'model',
	'target'=>'make',
	'className'=>'autocomplete',
	'parameters'=>'action=autocomplete&model={model}',
	'progressStyle'=>'throbbing',
	'minimumCharacters'=>1,
	));
?>
</script>
