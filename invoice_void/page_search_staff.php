<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript">
function first_text_box_focus()
{
	document.hello.staff_no.focus();
}
</script>
</head>
<body onload="javascript:first_text_box_focus();">
<?php

//echo "update=".$update."staffname=".$staff_name."staffno=".$staff_no;

   include_once("../include/config.php");
    $connection = DB::connect($dsn);
	   if (DB::isError($connection))
      die($connection->getMessage());
   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
	  if (DB::isError($result))
      die ($result->getMessage());?>

<script language="JavaScript1.5" >
function update2(b)
{
<?echo "window.opener.document.form1.elements[$recid].value=b;";?>

window.close();
	}
function Update(where)
{
	var emailto;
	var listname;
	
	if (where == 'partno1')
		emailto = window.opener.document.form1.partno1.value;
	else if (where == 'cc')
		emailto = window.opener.document.ComposeForm.cc.value;
	else if (where == 'bcc')
		emailto = window.opener.document.ComposeForm.bcc.value;
	else if (where == 'addtogrp') {
		listname = window.opener.document.GroupForm.listname.value;
	}
	
	for (var i = 0; i < document.toccbcc.elements.length; i++){
		var e = document.toccbcc.elements[i];
		if (e.name == 'addrlist' && e.checked)	{
			if (emailto)	emailto += ",";
			emailto += e.value;
		}
		if (where == 'addtogrp') {
			i++;
			var e2 = document.toccbcc.elements[i];
			if (e2.name == 'addrname' && e.checked ){
				if (listname)	listname += "&";
				listname += e2.value;
			}
		}
	}

	if (where == 'partno1')
	{
		alert(emailto);
		window.opener.document.form1.partno1.value = emailto;
	}
	else if (where == 'cc')
		window.opener.document.ComposeForm.cc.value = emailto;
	else if (where == 'bcc')
		window.opener.document.ComposeForm.bcc.value = emailto;
	else if (where == 'addtogrp') {
		window.opener.document.GroupForm.listname.value=listname;
		window.opener.document.GroupForm.ADEtype.value='';
		window.opener.document.GroupForm.submit();
	}
	window.close();
}

</script>
<?


///////////////////////////////////////////////////////
//part-no and model INPUT       out=goods_partno,model,update=2
///////////////////////////////////////////////////////
?>
<form name="hello" method="post" action="page_search_staff.php">
  <strong>員工編號</strong>:
  <input name="staff_no" type="text" id="staff_no" maxlength="20">
  <strong>員工名字</strong>:
  <input name="staff_name" type="text" id="staff_name" maxlength="20" />
  <input type="hidden" name="update" value=2>
  <input type="hidden" name="recid" value="<? echo $recid;?>">
  <?$recid2=$recid+3;?>
  <input type="hidden" name="recid2" value="<? echo $recid2;?>">
  <input name="submit" type="submit" id="submit" value="搜尋">
</form>
<?
///////////////////////////////////////////////////////
//part-no and model INPUT
///////////////////////////////////////////////////////
?>
<?
if ($update==2||$update==3)
{

   #$query1="select * from sheet1 where goods_partno='$goods_partno' ";
   if ($update==2 && $staff_name!="" && $staff_no!="")
   $query1="select * from staff where id = $staff_no and name like '%$staff_name%' ";
   else if ($update==2 && $staff_no=="")
   $query1="select * from staff where  name like '%$staff_name%'  order by id";
   else if ($update==2 && $staff_name=="")
   $query1="select * from staff where id = $staff_no ";
   else if ($update==3)
   $query1="select * from staff where id = $staff_no ";
   

   if (DB::isError($result))
      die ($result->getMessage());
	
	echo $query1;
	
   $result1=$connection->query($query1);
   if ($result1!=null)
   {
	$no1=$result1->numRows();
    $row1 = $result1->fetchRow(DB_FETCHMODE_ASSOC);
    
   
   ////////////////////////////////
   //can find record in sumgoods DB
   //即有入貨名的
   //如果冇record 就找其出入記錄
   //好果多個一就gen all partno
   ////////////////////////////////
   //
   //still find record from Invoice and goods db.200312082343 deal by Peggy
   //debug//echo "no1=".$no1;
 /*  if ($no1==1)
   {
   	//echo "此partno在貨名中有記錄\t";
   	$staff_no=$row1["id"];
   }else 
   if ($no1==0)
   {
   	//echo "<b><font color=\"FFFF00\">此partno在貨名中並冇記錄</font> 現在會嘗試找出其出貨入貨記錄 \t</b>";
   }
   
   
    if ($no1==1||$no1==0)
   {
			echo "<a href=javascript:update2('".$row1["id"]."');>";
		echo $row1["id"];
   echo "</a>";
   }
   */
   }


}

?>
<?
if ($no1>=1&&$update==2)
{
?>
<table bgcolor=#DEF123 >
  <tr>
    <td>員工編號</td>
    <td>員工姓名</td>

  </tr>
  <?
	do
	{
	echo "<tr><td>";
	echo "<a href=\"javascript:update2('".htmlspecialchars($row1["name"])."');\">";
	echo $row1["id"];
	echo "</a>";
	echo "</td>";
	echo "<td><font color=#111111>";
	echo $row1["name"];
	echo "</font></td>";
	echo "</tr><p>";
  	}
 	while(  $row1 = $result1->fetchRow(DB_FETCHMODE_ASSOC));
 	?>
  <tr>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
<?
}
 
 /////////////////////////////////////////////////////////
 //if search record >1, that means user will input "55555-"
 //this function will print all partno which start with 55555-%
 //////////////////////////////////////////////////////////
?>
</BODY>
</HTML>
