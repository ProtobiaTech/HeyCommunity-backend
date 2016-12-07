<!-- CNZZ tongji -->
<div style="display:none">
<script src="http://s11.cnzz.com/z_stat.php?id=1258838270&web_id=1258838270" language="JavaScript"></script>
</div>


<!-- Google analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68392745-5', 'auto');
  ga('send', 'pageview');
</script>


<!-- DaoVoice -->
<script>(function(i,s,o,g,r,a,m){i["DaoVoiceObject"]=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;a.charset="utf-8";m.parentNode.insertBefore(a,m)})(window,document,"script",('https:' == document.location.protocol ? 'https:' : 'http:') + "//widget.daovoice.io/widget/86480a80.js","daovoice");</script>
@if (Auth::tenant()->guest())
  <script>
    daovoice('init', {
      app_id: "86480a80",
    });
    daovoice('update');
  </script>
@else
  <script>
    daovoice('init', {
      app_id: "86480a80",
      private_deployment: "0",
      domain: "{{ $_SERVER['HTTP_HOST'] }}",
      ip: "{{ $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] }}",
      email: "{{ Auth::tenant()->user()->email }}",
      user_id: "{{ Auth::tenant()->user()->id }}",
      signed_up: {{ Auth::tenant()->user()->created_at->getTimestamp() }},
      name: "{{ Auth::tenant()->user()->site_name }}",
    });
    daovoice('update');
  </script>
@endif
