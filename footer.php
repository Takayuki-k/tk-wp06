  </div>
  <footer>
    <p class="copy">
      <span>&copy;</span>
      <span><?php $year = date( "Y", time() ); echo date('Y'); ?></span>
      <span><a href="<?php echo home_url('/'); ?>"><?php bloginfo('description'); ?></a></span>
    </p>
  </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>