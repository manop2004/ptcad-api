<style>
.button {
	top:50%;
	background-color:#0e3d67;
	color: #fff;
	border:none; 
	border-radius:10px; 
	padding:15px;
	min-height:30px; 
	min-width: 120px;
	font-size: 25px;
	cursor: pointer;
}
</style>
<?php
if(!empty($charge)){
?>
<center>
	<img src="<?php echo $charge['source']['scannable_code']['image']['download_uri']; ?>" width="350">
	<h3>โปรดชำระเงินภายในเวลา  <span id="demo" style="color: red;"></span></h3>
	<br>
	<button id="myButton" class="button" >เมื่อชำระแล้วกรุณากดปุ่มนี้</button>
</center>
<?php
}
?>
        
<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo $charge['expires_at']; ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for hours, minutes and seconds
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = hours + ":"
  + minutes + ":" + seconds;
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);

document.getElementById("myButton").onclick = function () {
	location.href = "<?php echo $charge['authorize_uri']; ?>";
};
</script>