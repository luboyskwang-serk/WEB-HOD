<script>
  var dueDate = new Date("5/28/2035 00:00:00"); // specify the due date and time in mm/dd/yyyy hh:mm:ss format
  var currentDate = new Date();
  
  if (currentDate >= dueDate) {
    setTimeout(function(){
      window.location.href = "https://discord.gg/overdrive-c";
    }, 0);  // wait for 3 seconds before redirecting
  }
</script>