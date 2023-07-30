<script>
function delaySeconds(seconds)
{
  var seconds = document.getElementById("countdown").textContent;
  var countdown = setInterval(function() {
      seconds--;
      document.getElementById("countdown").textContent = seconds;
      if (seconds <= 0) clearInterval(countdown);
  }, seconds*30);
}
</script>
