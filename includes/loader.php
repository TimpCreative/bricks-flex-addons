<?php
// Bail if Bricks isn’t active
if ( ! defined( 'BRICKS_VERSION' ) ) { return; }

/* ------------------ 1. PSR‑4 autoloader ------------------ */
spl_autoload_register( function ( $class ) {
  $prefix = 'FlexAddons\\';
  if ( str_starts_with( $class, $prefix ) ) {
    $path = __DIR__ . '/' . str_replace( '\\', '/', substr( $class, strlen( $prefix ) ) ) . '.php';
    if ( file_exists( $path ) ) { require_once $path; }
  }
});

/* ------------------ 2. Register custom elements ------------------ */
add_action( 'init', function () {
  // Register by file path (Bricks’ preferred way → faster)
  \Bricks\Elements::register_element( __DIR__ . '/elements/class-modal.php' );
}, 11 );

/* ------------------ 3. Dynamic‑data tags ------------------ */
/* 3‑A  Tag list shown inside the Builder */
add_filter( 'bricks/dynamic_tags_list', function ( $tags ) {
  $tags[] = [ 'name' => '{parent_page_title}',   'label' => 'Parent Page Title',   'group' => 'Flex Addons' ];
  $tags[] = [ 'name' => '{parent_page_content}', 'label' => 'Parent Page Content', 'group' => 'Flex Addons' ];
  return $tags;
});

/* 3‑B  Supply the value when Bricks renders tags */
add_filter( 'bricks/dynamic_data/render_tag', function ( $tag, $post, $context ) {

  if ( '{parent_page_title}' === $tag ) {
    return $post->post_parent ? get_the_title( $post->post_parent ) : '';
  }

  if ( '{parent_page_content}' === $tag ) {
    if ( $post->post_parent ) {
      $parent = get_post( $post->post_parent );
      return apply_filters( 'the_content', $parent->post_content );
    }
    return '';
  }

  return $tag; // leave untouched for other plugins / Bricks
}, 20, 3 );
