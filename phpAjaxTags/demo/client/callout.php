<div id="content">
<h1>Callout Tag Demo</h1>

<div style="font-size: 90%; width: 650px;">
  <p>
    The <code>ajax:callout</code> tag is an easy way to attach a callout or popup balloon to any
    HTML element supporting an onclick event. The style of this callout is fairly flexible, but
    generally has a header/title, a close link ('X'), and the content itself, of course.
  </p>
  <p>
    You may also set a timeout on the callout to disappear after some time has passed (expressed in
    milliseconds).  Alternately, you have it not timeout at all and, thereby, can force the user to
    close the callout manually (by clicking the close link).
  </p>
  <p>

    You must include a generic DIV tag to act as the container for all popups. This is primarily to
    get around an IE bug/feature that (in some cases) prevents inserting DOM elements after the 
    webpage loads.
  </p>
  <p>
    Click the "definition" link below to send a request to the backend servlet, retrieve the callout
    content, and display the callout itself.
  </p>
</div>

<h3>Callout in Action</h3>
<div style="font-size: 90%; width: 650px; border: 1px dashed #999; padding: 10px">
  <p>
    The Hitchhiker's Guide to the Galaxy is a science fiction series written by Douglas Adams
    (1952?2001).  The series follows the adventures of
    <a href="javascript://nop/" class="definition">Arthur Dent</a>, a hapless
    <a href="javascript://nop/" class="definition">Englishman</a> who escapes the destruction of
    Earth by an alien race called the <a href="javascript://nop/" class="definition">Vogons</a> with
    his friend <a href="javascript://nop/" class="definition">Ford Prefect</a>, an alien from a
    small planet somewhere in the vicinity of
    <a href="javascript://nop/" class="definition">Betelgeuse</a> and researcher for the eponymous
    guide. <a href="javascript://nop/" class="definition">Zaphod Beeblebrox</a>, Ford's semi-cousin
    and part-time Galactic President, unknowingly saves the pair from certain death. He brings them
    aboard his stolen spaceship, the
    <a href="javascript://nop/" class="definition">Heart of Gold</a>, whose crew rounds out the main
    cast of characters:
    <a href="javascript://nop/" class="definition">Marvin the Paranoid Android</a> (a severely
    depressed robot), and <a href="javascript://nop/" class="definition">Trillian</a>, a woman known
    by Arthur as the only other surviving human being. After this, the characters get involved in a
    quest to find legendary planet of <a href="javascript://nop/" class="definition">Magrathea</a>

    and the <a href="javascript://nop/" class="definition">Question to the Ultimate Answer.</a>
  </p>
  <p>And this is another example using <a href="javascript://nop/" class="definition2">onmouseover</a> 
  event with no title.</p>
</div>
<script>
<? pat_callout(array(
	'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
	'parameters'=>'action=callout&q={ajaxParameter}',
	'timeout'=>"2000",
	'title'=>'Definition',
	'classNamePrefix'=>"callout",
	'sourceClass'=>"definition",
	'boxPosition'=>"bottom right",
));

pat_callout(array(
	'baseUrl'=>'/phpAjaxTags/demo/sampleAjaxServer.php',
	'parameters'=>'action=callout&q={ajaxParameter}',
	'timeout'=>"2000",
	'title'=>'Definition',
	'classNamePrefix'=>"callout",
	'sourceClass'=>"definition2",
	'boxPosition'=>"bottom right",
	'eventType'=>"mouseover",
));
?>
</script>
</div>