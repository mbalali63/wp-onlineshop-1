<?php
/**
* Comments.php
* The template for displaying Comments.
* @package WordPress
* @subpackage Electron
* @since Electron 1.0
*
*
* If the current post is protected by a password and
* the visitor has not yet entered the password we will
* return early without loading the comments.
*/
if ( post_password_required() )
return;
?>

<div id="nt-comments" class="comments-container">

    <?php if ( have_comments() ) : ?>

        <div class="blog-single_reply_heading">
            <h3 class="nt-inner-title nt-comments-title"><?php printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;',
            get_comments_number(), 'electron' ),
            number_format_i18n( get_comments_number() ),
            '<span>' . get_the_title() . '</span>' );
            ?></h3>
        </div>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
                <h4 class="assistive-text"><?php esc_html_e( 'Comment navigation', 'electron' ); ?></h4>
                <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'electron' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'electron' ) ); ?></div>
            </nav>
        <?php endif; ?>

        <ol class="nt-commentlist comments-list">
            <?php wp_list_comments('callback=electron_custom_commentlist'); ?>
        </ol>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
                <h4 class="assistive-text"><?php esc_html_e( 'Comment navigation', 'electron' ); ?></h4>
                <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'electron' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'electron' ) ); ?></div>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : 	?>
        <p class="nocomments text-center"><?php esc_html_e( 'Comments are closed.', 'electron' ); ?></p>
    <?php endif; ?>

    <?php if ( comments_open() ) : ?>

        <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
            <p class="alert"><?php esc_html_e( 'You must be ', 'electron' ); ?><a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php esc_html_e( 'logged in', 'electron' ); ?></a> <?php esc_html_e( 'to post a comment.', 'electron' ); ?></p>
        <?php else : ?>
            <?php comment_form(); ?>
        <?php endif; ?>
    <?php endif; ?>

</div>
