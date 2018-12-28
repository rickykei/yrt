<link rel="stylesheet" type="text/css" href="./address/styles.css" />
<?   require_once("./include/config.php"); ?>
<div id="carbonForm">
	<h1><a href="../" >地址警告 </a> <? echo "[".$AREA."鋪,第".$PC."機]";?></h1>
    <form action="/?page=address&subpage=add2.php" method="post" id="addform">
    <div class="fieldContainer">
<div class="formRow">
            <div class="label">
                <label for="address">地址:</label>
            </div>
            <div class="field">
                <input type="text" name="address" id="address" size="50" maxlength="50" />
                <span id="addressLoading"><img src="indicator.gif" alt="Ajax Indicator" /></span>
				<span id="addressResult"></span>
            </div>
           
        </div>
<div class="formRow">
            <div class="label">
                <label for="alert">警告 : </label>
            </div>
            
            <div class="field">
                <input type="text" name="alert" id="alert" size="50"/>
            </div>
          
        </div>
      
      
    </div> 
    
    <div class="signupButton">
        <input type="submit" name="submit" id="submit" />
    </div>
    
    </form>
        
</div>

<script type="text/javascript" src="/address/script.js"></script>

