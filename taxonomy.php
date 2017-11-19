<?php
/* taxonomy.php */
?>
<?php
$tax_data = na_taxonomy_data();
var_dump($tax_data);
?>
<?php include_once 'conf.php'; ?>
<?php get_header(); ?>

<?php get_template_part( '@@@@' ); ?>
<?php get_footer(); ?>