<select id="sel1">
<option value="1">opt1</option>
<option value="2">opt2</option>
</select>
<select id="sel2">
</select>
<script>
<?pat_Select(array('baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php','parameters'=>'action=select&ob=sel1&vl={sel1}','source'=>'sel1','target'=>'sel2'))?>
</script>