<?php
$analyticstracking_code = get_option('google_analytics');
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  <?php if(!empty($analyticstracking_code)){ ?>
    ga('create', '<?php echo $analyticstracking_code ?>', 'auto');
  <?php }else{ ?>
  ga('create', 'UA-52470449-1', 'auto');
  <?php } ?>
  ga('send', 'pageview');

</script>
