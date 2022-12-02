    

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Infyson Exam Management System</b>  | <?php echo SYSTEM_VERSION; ?>
        </div>
        <strong>Copyright © <a href="#" target="blank">Infyson Technology></a>.</strong> <?php echo COPYRIGHT_AFTER; ?>
    </footer>
    
    <!-- jQuery UI 1.11.2 -->
    <!-- <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script> -->
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.2 JS -->
    
    <script type="text/javascript">
        var windowURL = window.location.href;
        pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));

        var x= $('a[href="'+windowURL+'"]');
            x.addClass('active');
            x.parent().addClass('active');
            x.parent().parent().parent().addClass('active');
    </script>
  </body>
</html>