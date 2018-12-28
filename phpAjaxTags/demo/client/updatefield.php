<h1>Update Form Field Tag Demo</h1>

<div style="font-size: 90%; width: 650px;">
  <p>
    The <code>ajax:updateField</code> tag allows you to update one or more form fields based on the
    value of another single field.
  </p>
  <p>
    The example below uses this concept to implement a simple conversion tool.
  </p>
</div>

<div style="width: 400px;">
<form id="updateForm">
  <fieldset>
    <legend>Velocity Conversion</legend>
    <p>Enter miles per hour and click Calculate</p>

    <label for="mph">Miles/Hour (mph)</label>
    <input type="text" id="mph" />

    <input id="action" type="button" value="Calculate"/>

    <label for="kph">Kilometers/Hour (kph)</label>
    <input type="text" id="kph" />

    <label for="mps">Meters/Second (m/s)</label>
    <input type="text" id="mps" />
  </fieldset>
</form>

</div>

<script type="text/javascript">
<?
pat_updateField(array(
	'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
	'parameters'=>'action=updatefield&mph={mph}',
	'action'=>"action",
	'target'=>'kph,mps',
	'source'=>"mph",
));

?>
</script>