<? include_once (dirname(__FILE__).'/../php/phpAjaxTags.inc.php'); 
pat_Js(array('jsPath'=>'/phpAjaxTags/js'));
?> 
  <link rel="stylesheet" type="text/css" href="/phpAjaxTags/css/ajaxtags.css" />
  <link rel="stylesheet" type="text/css" href="/phpAjaxTags/css/displaytag.css" />
<table><tr><td><hr/></td></tr>
<tr><td>
<? include('client/select2.php')?>
</td></tr>
<table><tr><td><hr/></td></tr>
<tr><td>
<? include('client/autocomplete.php')?>
</td></tr>
<table><tr><td><hr/></td></tr>
<tr><td>
<? include('client/callout.php')?>
</td></tr>
<table><tr><td><hr/></td></tr>
<tr><td>
<? include('client/updatefield.php')?>
</td></tr>
<table><tr><td><hr/></td></tr>
<tr><td>
<? include('client/htmlcontent.php')?>
</td></tr>
<table><tr><td><hr/></td></tr>
<tr><td>
<? include('client/portlet.php')?>
</td></tr>
<table><tr><td><hr/></td></tr>
<tr><td>
<? include('client/tabpanel.php')?>
</td></tr>
<table><tr><td><hr/></td></tr>
<tr><td>
<? include('client/toggle.php')?>
</td></tr>
<table><tr><td><hr/></td></tr>
<tr><td>
<? include('client/select.php')?>
</td></tr>
</table>